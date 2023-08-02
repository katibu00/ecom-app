<?php

namespace App\Http\Controllers\CBT;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Classes;
use App\Models\Question;
use App\Models\QuizResponse;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentCBTController extends Controller
{

    public function loginIndex($username)
    {
        $school = School::where('username', $username)->first();

        if (!$school) {
            return redirect()->route('login')->with('message', 'No school found.');
        }
        $classes = Classes::where('school_id', $school->id)->get();
        return view('cbt.student.login', ['school' => $school, 'classes' => $classes]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'admission_number' => 'required',
            'class_field' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $username = $request->input('username');
        $admissionNumber = $request->input('admission_number');
        $classId = $request->input('class_field');

        $student = $this->getStudentDetails($username, $admissionNumber, $classId);

        if ($student) {
            $request->session()->put('student', $student);
            return response()->json(['success' => true, 'redirect' => '/' . $username . '/exams']);
        }

    }

    private function getStudentDetails($schoolUsername, $admissionNumber, $classId)
    {
        $student = DB::table('users')
            ->where('login', $admissionNumber)
            ->where('class_id', $classId)
            ->whereExists(function ($query) use ($schoolUsername) {
                $query->select(DB::raw(1))
                    ->from('schools')
                    ->whereColumn('users.school_id', 'schools.id')
                    ->where('schools.username', $schoolUsername);
            })
            ->first();

        return $student;
    }

    public function listExams(Request $request)
    {
        $student = $request->session()->get('student');

        $exams = Assessment::where('classes', 'LIKE', "%{$student->class_id}%")
            ->with('subject')
            ->get();

        return view('cbt.student.exams', ['exams' => $exams]);
    }

    public function takeExam(Request $request)
    {
        $examId = $request->query('examId');

        if (!$request->session()->has('student')) {
            return redirect()->route('login')->with('error', 'You are not authorized to take the exam.');
        }

        $exam = Assessment::find($examId);

        $now = Carbon::now();
        $startDateTime = Carbon::parse($exam->start_datetime);
        $endDateTime = Carbon::parse($exam->end_datetime);

        if ($now < $startDateTime) {
            // Exam has not started yet
            return redirect()->back()->with('error', 'The ' . $exam->title . ' has not started yet.');
        }

        if ($now > $endDateTime) {
            // Exam has ended
            return redirect()->back()->with('error', 'The ' . $exam->title . ' has already ended.');
        }

        $durationInSeconds = $exam->duration;
        $examTitle = $exam->title;

        $numberOfQuestions = $exam->num_questions;
        $questions = Question::where('exam_id', $examId)->inRandomOrder()->limit($numberOfQuestions)->get();

        $questions = $questions->shuffle();

        $quizData = [];
        foreach ($questions as $index => $question) {
            $options = json_decode($question->options, true);

            shuffle($options);

            $formattedQuestion = [
                'index' => $index + 1,
                'id' => $question->id,
                'question' => $question->question,
                'options' => $options,
            ];

            $quizData[] = $formattedQuestion;
        }

        $quizDataJson = json_encode($quizData);

        return view('cbt.student.take_exam', compact('quizDataJson', 'durationInSeconds', 'examId', 'examTitle'));
    }

    public function submitExam(Request $request)
    {
        if (!$request->session()->has('student')) {
            return redirect()->route('login')->with('error', 'You are not authorized to take the exam.');
        }

        $userResponsesArray = $request->input('responses');
        $examId = (int) $request->examId;
        $student = session('student');

        if (empty($userResponsesArray) || in_array(null, $userResponsesArray, true) || in_array('', $userResponsesArray, true)) {
            return response()->json(['error' => 'Please answer all questions before submitting.']);
        }

        $existingResponse = QuizResponse::where([
            'student_id' => $student->id,
            'exam_id' => $examId,
        ])->first();

        $exam = Assessment::find($examId);
        $showResult = $exam->show_result;

        if ($exam->attempt_limit !== 'unlimited' && $existingResponse) {

            if ($existingResponse->attempt_count >= $exam->attempt_limit) {
                return response()->json(['error' => 'You have exceeded the attempt limit for this exam.']);
            }

            QuizResponse::where([
                'student_id' => $student->id,
                'exam_id' => $examId,
            ])->delete();
        }

        $questionIds = array_keys($userResponsesArray);
        $questions = Question::whereIn('id', $questionIds)->get();
        $correctAnswers = [];
        foreach ($questions as $question) {
            $correctAnswers[$question->id] = $question->correct_answer;
        }

        // Calculate the user's score and save each response
        $score = 0;
        foreach ($userResponsesArray as $questionId => $userAnswer) {
            $isCorrect = isset($correctAnswers[$questionId]) && $userAnswer === $correctAnswers[$questionId];
            $response = new QuizResponse([
                'student_id' => $student->id, // Assuming 'student' is the authenticated user
                'school_id' => $student->school_id,
                'exam_id' => $examId,
                'question_id' => $questionId,
                'response' => $userAnswer,
                'is_correct' => $isCorrect,
                'attempt_count' => $existingResponse ? $existingResponse->attempt_count + 1 : 1,
            ]);
            $response->save();

            if ($isCorrect) {
                $score++;
            }
        }
        $redirectUrl = $showResult === 'yes'
        ? route('cbt.student.exams.result', ['examId' => $examId, 'score' => $score])
        : route('cbt.student.thank_you_page');

        return response()->json(['redirect_url' => $redirectUrl]);

    }

    public function showResult($examId, $score)
    {

        $student = session('student');

        if (!$student) {
            return redirect()->route('login')->with('error', 'You are not authorized to take the exam.');
        }

        $answeredQuestionIds = QuizResponse::where([
            'student_id' => $student->id,
            'exam_id' => $examId,
        ])->pluck('question_id');

        $questionsDetails = Question::whereIn('id', $answeredQuestionIds)->get();

        $attemptedQuestions = count($answeredQuestionIds);

        $totalQuestions = Assessment::find($examId)->num_questions;

        $username = School::select('username')->where('id',$student->school_id)->first();

        return view('cbt.student.exam_result', compact('questionsDetails', 'score', 'student','username', 'attemptedQuestions', 'totalQuestions', 'examId'));
    }

}

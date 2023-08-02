<?php

namespace App\Http\Controllers\CBT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Classes;
use App\Models\QuizResponse;
use App\Models\User;

class ExamAttemptsController extends Controller
{
    public function index()
    {
        $exams = Assessment::where('school_id', auth()->user()->school_id)->get();

        return view('cbt.attempts.index', compact('exams'));
    }








    public function fetchRecords(Request $request)
    {
        $examId = $request->input('exam_id');

        // Find the exam with the provided ID
        $exam = Assessment::find($examId);

        if (!$exam) {
            return redirect()->back()->with('error', 'Exam not found.');
        }

        // Fetch the classes for which the exam was assigned
        $classIds = explode(',', $exam->classes);
        $classes = Classes::whereIn('id', $classIds)->get();

        // Fetch all students and their attempt details for the given exam
        $studentsWithAttempts = [];
        $students = User::where('usertype', 'std')->get();

        foreach ($students as $student) {
            $attempts = QuizResponse::where([
                'student_id' => $student->id,
                'exam_id' => $examId,
            ])->get();

            $attemptedQuestionsCount = count($attempts->pluck('question_id')->unique());

            $score = 0;
            foreach ($attempts as $attempt) {
                if ($attempt->is_correct) {
                    $score++;
                }
            }

            $firstAttempt = $attempts->first(); // Get the first attempt to retrieve the attempt_count
            $attemptCount = $firstAttempt ? $firstAttempt->attempt_count : 0;

            $studentsWithAttempts[] = [
                'student' => $student,
                'attempts' => $attempts,
                'score' => $score,
                'attempted_questions_count' => $attemptedQuestionsCount,
                'attempt_count' => $attemptCount,
            ];
        }

        $exams = Assessment::where('school_id', auth()->user()->school_id)->get();

        return view('cbt.attempts.index', compact('exam', 'exams', 'classes', 'studentsWithAttempts'));
    }






}

<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use App\Models\AssignSubject;
use App\Models\Classes;
use App\Models\Mark;
use App\Models\ProcessedMark;
use App\Models\School;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ResultAnalysisController extends Controller
{
    public function index()
    {
        $data['sessions'] = Session::select('id', 'name')->where('school_id', auth()->user()->school_id)->get();
        $user = auth()->user();

        if ($user->usertype == 'teacher' || $user->usertype == 'accountant') {
            $data['classes'] = Classes::select('id', 'name')->where('school_id', $user->school_id)->where('form_master_id', $user->id)->where('status', 1)->get();
        } else {
            $data['classes'] = Classes::select('id', 'name')->where('school_id', $user->school_id)->where('status', 1)->get();
        }
        $data['school'] = School::select('session_id', 'term')->where('id', auth()->user()->school_id)->first();
        return view('results.analysis', $data);
    }

    public function generate(Request $request)
    {
        $this->validate($request, [
            'session_id' => 'required',
            'class_id' => 'required',
            'term' => 'required',
            'limit' => 'required|numeric',
        ]);

        $classId = $request->input('class_id');
        $term = $request->input('term');
        $limit = $request->input('limit');

        // Get the subjects assigned to the selected class
        $subjects = AssignSubject::select('subjects.name', 'subject_id')
            ->join('subjects', 'assign_subjects.subject_id', '=', 'subjects.id')
            ->where('assign_subjects.class_id', $classId)
            ->get();

        // Get the students in the selected class with their names
        $students = User::select('id', 'first_name', 'last_name')
            ->where('class_id', $classId)
            ->get();

        $classWiseReport = [];

        foreach ($subjects as $subject) {
            // Get the top students in the subject
            $topStudents = Mark::select(DB::raw('MAX(marks) as max_marks'), 'student_id')
            ->join('users', 'marks.student_id', '=', 'users.id')
            ->where('marks.class_id', $classId)
            ->where('marks.term', $term)
            ->where('marks.subject_id', $subject->subject_id)
            ->groupBy('student_id') // Group the records by student ID
            ->orderBy('max_marks', 'DESC') // Order by the maximum marks
            ->limit($limit)
            ->get();
        

            $topStudentsWithNames = $topStudents->map(function ($student) use ($students) {
                $studentUser = $students->firstWhere('id', $student->student_id);
                $student->first_name = $studentUser->first_name;
                $student->last_name = $studentUser->last_name;
                return $student;
            });

            $subjectReport = [
                'subject' => $subject->name, // Use the subject name from the AssignSubject table
                'top_students' => $topStudentsWithNames,
            ];

            $classWiseReport[] = $subjectReport;
        }
        // Get average marks for the class
        $averageMarks = ProcessedMark::where('class_id', $classId)
            ->where('term', $term)
            ->avg('total');

        // Get overall best student
        $overallBestStudent = ProcessedMark::select('student_id', 'total')
            ->join('users', 'processed_marks.student_id', '=', 'users.id')
            ->where('processed_marks.class_id', $classId)
            ->where('processed_marks.term', $term)
            ->orderBy('total', 'DESC')
            ->first();

// Get overall worst student
        $overallWorstStudent = ProcessedMark::select('student_id', 'total')
            ->join('users', 'processed_marks.student_id', '=', 'users.id')
            ->where('processed_marks.class_id', $classId)
            ->where('processed_marks.term', $term)
            ->orderBy('total', 'ASC')
            ->first();

// Get the student names
        $bestStudentName = User::select('first_name', 'last_name')
            ->where('id', $overallBestStudent->student_id)
            ->first();
        $worstStudentName = User::select('first_name', 'last_name')
            ->where('id', $overallWorstStudent->student_id)
            ->first();

// Update the overall best student object
        $overallBestStudent->first_name = $bestStudentName->first_name;
        $overallBestStudent->last_name = $bestStudentName->last_name;

// Update the overall worst student object
        $overallWorstStudent->first_name = $worstStudentName->first_name;
        $overallWorstStudent->last_name = $worstStudentName->last_name;

// Your existing code...

// Prepare the data for JSON response
        $data = [
            'classWiseReport' => $classWiseReport,
            'overallBestStudent' => $overallBestStudent,
            'overallWorstStudent' => $overallWorstStudent,
            'averageMarks' => $averageMarks,
        ];

        // Return the data as JSON response
        return response()->json($data);
    }

}

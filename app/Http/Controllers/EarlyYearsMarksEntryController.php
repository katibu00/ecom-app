<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\EarlyYearMark;
use App\Models\LearningDomain;
use App\Models\LearningOutcome;
use App\Models\Mark;
use App\Models\School;
use App\Models\User;

class EarlyYearsMarksEntryController extends Controller
{
    public function index()
    {
        $classes = Classes::where('school_id', auth()->user()->school_id)->get();
        $learningDomains = LearningDomain::all(); // Retrieve the learning domains from your database
    
        return view('marks.early_years.index', compact('classes', 'learningDomains'));
    }

    public function getStudentsByClass($classId)
    {
        try {
            $students = User::where('class_id', $classId)->where('school_id', auth()->user()->school_id)->get();
            return response()->json($students);
        } catch (\Exception $e) {
            // Handle any errors or exceptions
            return response()->json(['error' => 'Failed to fetch students.'], 500);
        }
    }

   


    public function getMarks($studentId)
    {
        // Retrieve the student based on the ID
        $student = User::find($studentId);
    
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }
    
        // Retrieve all learning domains and outcomes
        $domains = LearningDomain::with('learningOutcomes')->get();
    
        // Retrieve the marks for the selected student
        $marks = EarlyYearMark::where('student_id', $studentId)->pluck('grade', 'learning_outcome_id');
    
        // Return the marks and learning domains as a JSON response
        return response()->json(['domains' => $domains, 'marks' => $marks]);
    }
    







public function store(Request $request)
{
    // Retrieve the current session and school ID
    $school = School::select('id','session_id','term')->where('id',auth()->user()->school_id)->first();

    $term = $school->term;
    $session_id = $school->session_id;

    // Retrieve the student ID and marks from the form data
    $studentId = $request->input('student_id');
    $marks = $request->input('marks');

    // Perform any necessary validation or data processing

    // Iterate over the marks array and save the grades
    foreach ($marks as $outcomeId => $grade) {
        // Create or update the mark record
        EarlyYearMark::updateOrCreate(
            [
                'student_id' => $studentId,
                'learning_outcome_id' => $outcomeId,
                'session_id' => $session_id,
                'school_id' => $school->id,
            ],
            [
                'grade' => $grade,
                'term' => $term,
            ]
        );
    }

    // Return a JSON response indicating the success of the operation
    return response()->json(['message' => 'Marks submitted successfully']);
}



}

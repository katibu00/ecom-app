<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\LearningDomain;
use App\Models\Mark;
use App\Models\ProcessedMark;
use App\Models\ResultSettings;
use App\Models\School;
use App\Models\Session;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class EarlyYearResultController extends Controller
{
    public function index()
    {
        $data['sessions'] = Session::select('id','name')->where('school_id',auth()->user()->school_id)->get(); 
        $user = auth()->user();

        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }  
        $data['school'] = School::select('session_id','term')->where('id',auth()->user()->school_id)->first();
        return view('results.early_year',$data);
    }


    



    public function generateReport(Request $request)
    {
        // Retrieve the form data
        $sessionId = $request->input('session_id');
        $classId = $request->input('class_id');
        $term = $request->input('term');
    
        // Retrieve the students for the selected session, class, and term
        $students = User::where('class_id', $classId)
            ->get();
    
        // Check if any students exist
        if ($students->isEmpty()) {
            toastr()->warning('No students found for the selected criteria.');
            return redirect()->back();
        }
    
        // Retrieve the learning domains and outcomes
        $domains = LearningDomain::with('learningOutcomes')->get();
    
        // Generate the PDF using the "early_years_report" view and pass the data to it
        $pdf = PDF::loadView('pdfs.admin.results.early_years_report', compact('students', 'domains', 'term'));
    
        // Set the filename for the downloaded PDF
        $filename = 'early_years_report_' . date('Ymd') . '.pdf';
    
        // Download the PDF file
        return $pdf->download($filename);
    }
    

}

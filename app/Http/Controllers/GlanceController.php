<?php

namespace App\Http\Controllers;

use App\Models\AssignFee;
use App\Models\AssignMaster;
use App\Models\AssignSubject;
use App\Models\AssignSubjects;
use App\Models\Classes;
use App\Models\ClassSection;
use App\Models\FeeStructure;
use App\Models\School;
use App\Models\SchoolSection;
use App\Models\Section;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GlanceController extends Controller
{



    public function glance_index()
    {
        $data['school'] = School::where('id', auth()->user()->school_id)->first();
        $data['classes'] = Classes::with(['students', 'assignedSubjects', 'formMaster', 'attendanceRecords'])->where('school_id', auth()->user()->school_id)->get();

     
        return view('glance.index', $data);
    }

    public function students(Request $request){

        $id = Auth::user()->school_id;
        $data['school'] = School::where('id', $id)->first();

        $data['students'] = User::where('usertype','std')->where('school_id',$id)->where('class_id',$request->class_id)->where('status',1)->get();
        $data['school_sections'] = Section::where('school_id',$id)->get();
        $data['classes'] = Classes::where('school_id',$id)->get();
        $data['parents'] = User::where('usertype','parent')->where('school_id',$id)->get();

        return view('glance.students',$data);
    }

    public function subjects(Request $request){

        $id = Auth::user()->school_id;

        $data['subjects'] = AssignSubject::where('school_id',$id)->where('class_id', $request->class_id)->get();
 
        return view('glance.subjects',$data);
    }

    public function invoice(Request $request){

        $id = Auth::user()->school_id;
        $count = FeeStructure::where('class_id', $request->class_id)->where('student_type', 'regular')->where('school_id', $id)->get()->count();

        if ($count == 0) {
            Toastr::warning('Fee has Not been Assigned', 'Not Assigned');
            return redirect()->back();
        }

        $data['allData'] = FeeStructure::where('class_id', $request->class_id)->where('student_type', 'regular')->where('school_id', $id)->get();
        return view('glance.invoice', $data);
    }


    public function gradebook(Request $request){

        $school_id = Auth::user()->school_id;
        $school_id = Auth::user()->school_id;
        $institution = School::where('id', $school_id)->first();
        $data['term'] = $institution->term;
        $data['session'] = $institution->session_id;

       


        $data['children'] = User::where('usertype','std')->where('school_id',$school_id)->where('class_id',$request->class_id)->get()->sortBy('first_name');
        $data['school'] = School::where('id', $school_id)->first();
        $data['allData'] = AssignSubject::where('class_id', $request->class_id)->where('school_id', $school_id)->get();
        $data['class_id'] = $request->class_id;

        if( $data['children']->count() == 0){
            Toastr::error('No Students found in the selected class', 'Warning');
            return redirect()->route('glance.index');
        }

        if( $data['allData']->count() == 0){
            Toastr::error('No Subjects have been assigned for the selected class', 'Warning');
            return redirect()->route('glance.index');
        }

        return view('glance.gradebook', $data);
    }


    public function fee(Request $request){
     
        $school_id = Auth::user()->school_id;
        $institution = School::where('id', $school_id)->first();
        $term = $institution->term;
        $session = $institution->session_id;

        $users = User::where('school_id',$school_id)->where('class_id',$request->class_id)->get();
        $class = Classes::where('school_id',$school_id)->where('id',$request->class_id)->first();
        $section = Section::where('school_id',$school_id)->where('id',$request->class_section_id)->first();
        $invoice = FeeStructure::where('school_id', $school_id)->where('class_id',$request->class_id)->where('student_type','Returning')->get();

        return view('glance.fee', compact('institution','users','invoice','school_id','session','term','class','section'));

    }
}

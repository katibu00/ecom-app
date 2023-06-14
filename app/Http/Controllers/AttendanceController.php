<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classes;
use App\Models\School;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
 


    public function overview()
    {
        $user = Auth::user();
        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }
        $data['school'] = School::select('session_id','term')->where('id',$user->school_id)->first();
        return view('attendance.overview',$data);
    }

    public function getDetails(Request $request)
    {
       $attendances = Attendance::with('student')->select('student_id','status')->where('date',date('Y-m-d'))->where('class_id',$request->class_id)->get();

       return response()->json([
        'status'=>200,
        'attendances'=>$attendances,
       ]);
    }



    public function create(Request $request)
    {
        $user = Auth::user();
        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }        
        
        if($request->class_id)
        {
            $data['students'] = User::select('id','first_name','middle_name','last_name')->where('class_id',$request->class_id)->where('school_id',$user->school_id)->where('status',1)->get();
            if ( $data['students']->count() < 1) {
                Toastr::error('No student has been found in the selected class');
                return redirect()->route('attendance.take.index');
            }
            $data['class_id'] = $request->class_id;
        }
        return view('attendance.take',$data);
    }

    public function store(Request $request)
    {

        $school_id = Auth::user()->school_id;
        $school = School::select('id','term','session_id')->where('id', $school_id)->first();
        $term = $school->term;
        $session = $school->session_id;


        $exist = Attendance::where('class_id', $request->class_id)->where('school_id', $school_id)->where('date', $request->date)->first();
        if ($exist) {
            Toastr::error('Attendance has been Recorded for the selected date and class');
            return redirect()->route('attendance.index');
        }


        $studentcount = $request->student_id;
        if ($studentcount) {
            for ($i = 0; $i < count($request->student_id); $i++) {
                $data = new Attendance();
                $attend_status = 'attend_status' . $i;
                $data->student_id = $request->student_id[$i];
                $data->date = $request->date;
                $data->status = $request->$attend_status;
                $data->school_id = $school_id;
                $data->session_id = $session;
                $data->term = $term;
                $data->class_id = $request->class_id;
                $data->save();
            }
            Toastr::success('Attendance has been Recorded sucessfully');
            return redirect()->route('attendance.take.index');
        }
    }

    public function report(Request $request){

        $user = Auth::user();

        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }     

        if($request->class_id)
        {
            $data['dates'] = Attendance::select('date')->where('school_id',$user->school_id)->where('class_id',$request->class_id)->groupBy('date')->orderBy('date','desc')->get();
            if ($data['dates']->count() < 1) {
                Toastr::error('Attendance not Recorded for the selected class');
                return redirect()->route('attendance.report.index');
            }
            $data['class_id'] = $request->class_id;
            $data['students'] = User::select('id','gender','first_name','middle_name','last_name')->where('class_id',$request->class_id)->where('school_id',$user->school_id)->where('status',1)->orderBy('gender', 'desc')->orderBy('first_name')->get();
        }
        return view('attendance.report', $data);
        

    }


    public function print(Request $request){

        $school_id = Auth::user()->school_id;
        $institution = School::where('id', $school_id)->first();
        $term = $institution->term;
        $session = $institution->session_id;


        $school = School::where('id', $school_id)->first();


        $users = User::where('class_id', $request->class)->where('class_section_id',  $request->section)->where('school_id',  $request->school)->get();

        $class = AssignMaster::where('class_id',$request->class)->where('class_section_id',$request->section)->where('school_id',$request->school)->first();

        $pdf = PDF::loadView('pdfs.attendance_report', compact('school', 'class','users','term','session'));

        return $pdf->stream('Termly Report.pdf');
    }


    public function offline_index(){

        $school_id = Auth::user()->school_id;
        $user_id = Auth::user()->id;

        if(Auth::user()->usertype == 'teacher'){

            $data['classes'] = AssignMaster::select('class_id')->where('user_id', $user_id)->where('school_id', $school_id)->groupBy('class_id')->get();
            $data['class_section'] = AssignMaster::select('class_section_id')->where('user_id', $user_id)->where('school_id', $school_id)->groupBy('class_section_id')->get();
            return view('attendance.offline',$data);


        }else{

            $data['classes'] = AssignMaster::select('class_id')->where('school_id', $school_id)->groupBy('class_id')->get();
            $data['class_section'] = AssignMaster::select('class_section_id')->where('school_id', $school_id)->groupBy('class_section_id')->get();
            return view('attendance.offline',$data);
        }

    }

    public function offline_generate(Request $request){

        $school_id = Auth::user()->school_id;
        $school = School::where('id', $school_id)->first();
        $users = User::where('class_id', $request->class_id)->where('class_section_id',  $request->class_section_id)->where('school_id',  $school_id)->get();

        if($users->count() == 0 ){
            Toastr::warning('No Students Found', 'Warning');
            return redirect()->back();
        }

        $pdf = PDF::loadView('pdfs.attendance_sheet', compact('school','users'));

        return $pdf->stream('Offline Attendance Sheet.pdf');
    }
}

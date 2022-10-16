<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Mark;
use App\Models\ProcessedMark;
use App\Models\School;
use App\Models\Session;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminResultController extends Controller
{
    public function termIndex()
    {
        $data['sessions'] = Session::select('id','name')->where('school_id',auth()->user()->school_id)->get(); 
        $data['classes'] = Classes::select('id','name')->where('school_id',auth()->user()->school_id)->get(); 
        $data['school'] = School::select('session_id','term')->where('id',auth()->user()->school_id)->first();
        return view('results.termly',$data);
    }


    public function termGenerate(Request $request)
    {   
        $this->validate($request, [
            'session_id' => 'required',
            'class_id' => 'required',
            'term' => 'required',
        ]);
     
        $user = Auth::user();
        $school = School::select('id','name','email','phone_first','phone_second','address','heading','grading')->where('id', $user->school_id)->first();
      
      

        // if(Auth::user()->usertype == 'teacher' || Auth::user()->usertype == 'Accountant'){
        //     $check = AssignMaster::where('user_id',$user_id)->where('class_id',$request->class_id)->where('class_section_id',$request->class_section_id)->first();

        //     if(!$check){
        //         Toastr::error('You do not have persmission to manage this class. Please check your input and try again.', 'Warning');
        //         return redirect()->back();
        //     }
        // }
        $studentsCheck = Mark::select('student_id')->where('class_id', $request->class_id)->where('term', $request->term)->where('school_id', $school->id)->where('session_id', $request->session_id)->groupBy('student_id')->get();

        if ($studentsCheck->count() == 0) {
            Toastr::error('No Marks Found', 'Warning');
            return redirect()->back();
        }

        ProcessedMark::where('class_id', $request->class_id)->where('term', $request->term)->where('school_id', $school->id)->where('session_id', $request->session_id)->delete();
        foreach ($studentsCheck as $student) {

            $ca = Mark::where('student_id', $student->student_id)->where('class_id', $request->class_id)->where('term', $request->term)->where('session_id', $request->session_id)->where('school_id', $school->id)->where('type', '!=', 'exam')->sum('marks');
            $exam = Mark::where('student_id', $student->student_id)->where('class_id', $request->class_id)->where('term', $request->term)->where('school_id', $school->id)->where('session_id', $request->session_id)->where('type', 'exam')->sum('marks');

            $data = new ProcessedMark();

            $data->student_id = $student->student_id;
            $data->school_id = $school->id;
            $data->session_id = $request->session_id;
            $data->class_id = $request->class_id;
            $data->term = $request->term;
            $data->ca = $ca;
            $data->exam = $exam;
            $data->total = $ca+$exam;
            $data->save();
        }

      
        $students = ProcessedMark::select('student_id','total')->where('class_id',$request->class_id)->where('term',$request->term)->where('school_id',$school->id)->where('session_id',$request->session_id)->groupBy('student_id','total')->orderBy('total','desc')->get();
       
        $session_id = $request->session_id;
        $class_id = $request->class_id;
        $term = $request->term;
        
        $comments = @$request->comments;
        $psychomotor = @$request->psychomotor;
        $next_term = @$request->next_term;
        $date = @$request->date;

        return view('pdfs.admin.results.termly', compact('school', 'students', 'class_id', 'term', 'session_id','comments','next_term','date','psychomotor'));


    }

}


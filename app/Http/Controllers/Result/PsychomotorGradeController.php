<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\ProcessedMark;
use App\Models\PsychomotorCrud;
use App\Models\PsychomotorGrade;
use App\Models\PsychomotorSubmit;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PsychomotorGradeController extends Controller
{
    public function index()
    {
       
        $data['school'] = School::select('id','term','session_id')->where('id', auth()->user()->school_id)->first();
        $data['classes'] = Classes::select('id','name')->where('school_id',auth()->user()->school_id)->get(); 
        return view('psychomotor.index',$data);
    }

    public function getRecords(Request $request)
    {
        $school = School::select('id','session_id','term',)->where('id', Auth::user()->school_id)->first();
        $students = ProcessedMark::with(['student'])->select('student_id','total')->where('class_id',$request->class_id)->where('term', $school->term)->where('session_id',$school->session_id)->where('school_id', $school->id)->groupBy('student_id','total')->orderBy('total','desc')->get();
        $grades = PsychomotorCrud::select('id','name')->where('school_id',Auth::user()->school_id)->get();
      
        return response()->json([
            'students'=>$students,
            'grades'=>$grades,
        ]);
    }

    public function storePsychomotor(Request $request)
    {
        // return $request->all();

        $school = School::select('id','session_id','term',)->where('id', Auth::user()->school_id)->first();
        $exist = PsychomotorSubmit::where('school_id',$school->id)->where('term',$school->term)->where('class_id',$request->class_id)->where('type',$request->type)->first();
        if($exist){
            return response()->json([
                'status'=>404,
                'message'=>'Psychomotor Grades Already addes for the selected class',
            ]);
        }

        $rowCount = count($request->student_id);
        if($rowCount != NULL){
            for ($i=0; $i < $rowCount; $i++){
                $data = new PsychomotorGrade();
                $data->school_id = auth()->user()->school_id;
                $data->session_id = $school->session_id;
                $data->term = $school->term;
                $data->class_id = $request->class_id;
                $data->student_id = $request->student_id[$i];
                $data->grade_id = $request->grade_id[$i];
                $data->score = $request->score[$i];
                $data->save();
            }
        };

        $submit = new PsychomotorSubmit();
        $submit->school_id = auth()->user()->school_id;
        $submit->session_id = $school->session_id;
        $submit->term = $school->term;
        $submit->class_id = $request->class_id;
        $submit->type = $request->type;
        $submit->teacher_id = auth()->user()->id;
        $submit->save();

        return response()->json([
            'status'=>200,
            'message'=>'Psychomotor Grades Added Successfully',
        ]);
    }
}

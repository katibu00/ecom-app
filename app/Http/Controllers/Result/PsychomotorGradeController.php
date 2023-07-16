<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use App\Models\AffectiveCrud;
use App\Models\Classes;
use App\Models\ProcessedMark;
use App\Models\PsychomotorCrud;
use App\Models\PsychomotorGrade;
use App\Models\PsychomotorSubmit;
use App\Models\School;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PsychomotorGradeController extends Controller
{
    public function index()
    {
       
        $data['school'] = School::select('id','term','session_id')->where('id', auth()->user()->school_id)->first();
        $user = auth()->user();

        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }  
        return view('psychomotor.index',$data);
    }

    public function getRecords(Request $request)
    {
        $school = School::select('id','session_id','term',)->where('id', Auth::user()->school_id)->first();
        $students = ProcessedMark::with(['student'])->select('student_id','total')->where('class_id',$request->class_id)->where('term', $school->term)->where('session_id',$school->session_id)->where('school_id', $school->id)->groupBy('student_id','total')->orderBy('total','desc')->get();
        if($request->type == 1)
        {
            $grades = PsychomotorCrud::select('id','name')->where('school_id',Auth::user()->school_id)->get();
        }
        if($request->type == 2)
        {
            $grades = AffectiveCrud::select('id','name')->where('school_id',Auth::user()->school_id)->get();
        }

        if($students->count() < 1)
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Marks Found for the Selected Class. Give marks and Try Again.',
            ]); 
        }
      
        return response()->json([
            'status'=>200,
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
                'message'=>'Psychomotor Grades Already Submitted for the Selected Class',
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
                $data->type = $request->type;
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

    public function viewRecords($class_id, $type)
    {
        $school = School::select('id', 'session_id', 'term')->where('id', Auth::user()->school_id)->first();
        $class = Classes::select('school_id', 'name')->where('id', $class_id)->first();
        
        if (!$class || @$class->school_id != Auth::user()->school_id) {
            Toastr::error('You do not have permission to manage this class.');
            return redirect()->route('psychomotor.index');
        }
        
        $gradesList = [];
        
        if ($type == 1) {
            $gradesList = PsychomotorCrud::select('id', 'name')
                ->where('school_id', $school->id)
                ->get();
        } elseif ($type == 2) {
            $gradesList = AffectiveCrud::select('id', 'name')
                ->where('school_id', $school->id)
                ->get();
        }
        
        $students = User::select('id', 'first_name', 'middle_name', 'last_name')
            ->where('class_id', $class_id)
            ->get();
        
        if ($students->isEmpty() || $gradesList->isEmpty()) {
            Toastr::warning('No data found for the given class and type.');
            return redirect()->back();
        }
        
        return view('psychomotor.viewPage', [
            'students' => $students,
            'gradesLists' => $gradesList,
            'class_id' => $class_id,
            'school' => $school,
            'class' => $class,
            'type' => $type
        ]);
    }
    

    public function updateRecord(Request $request)
{
    // dd($request->all());
    $rowId = $request->input('rowId');
    $newScore = $request->input('newScore');

    // Update the score in the database based on the row ID

    return response()->json(['message' => 'Score updated successfully'], 200);
}
}

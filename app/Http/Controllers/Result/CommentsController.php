<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Comment;
use App\Models\CommentSubmit;
use App\Models\ProcessedMark;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index()
    {
       
        $data['school'] = School::select('id','term','session_id')->where('id', auth()->user()->school_id)->first();
        $data['classes'] = Classes::select('id','name')->where('school_id',auth()->user()->school_id)->get(); 
        return view('comments.index',$data);
    }

    public function getComments(Request $request)
    {
        $school = School::select('id','session_id','term',)->where('id', Auth::user()->school_id)->first();
        $allData = ProcessedMark::with(['student'])->select('student_id','total')->where('class_id',$request->class_id)->where('term', $school->term)->where('session_id',$school->session_id)->where('school_id', $school->id)->groupBy('student_id','total')->orderBy('total','desc')->get();
        return response()->json($allData);
    }
    public function storeComments(Request $request)
    {
        $school = School::select('id','session_id','term',)->where('id', Auth::user()->school_id)->first();
        $exist = CommentSubmit::where('school_id',$school->id)->where('term',$school->term)->where('class_id',$request->class_id)->where('officer',$request->officer)->first();
        if($exist){
            return response()->json([
                'status'=>404,
                'message'=>'Comments Already addes for the selected class/officer',
            ]);
        }

        $rowCount = count($request->student_id);
        if($rowCount != NULL){
            for ($i=0; $i < $rowCount; $i++){
                $data = new Comment();
                $data->school_id = auth()->user()->school_id;
                $data->session_id = $school->session_id;
                $data->term = $school->term;
                $data->class_id = $request->class_id;
                $data->student_id = $request->student_id[$i];
                $data->officer = $request->officer;
                $data->comment = $request->comment[$i];
                $data->additional = $request->additional[$i];
                $data->save();
            }
        };

        $submit = new CommentSubmit();
        $submit->school_id = auth()->user()->school_id;
        $submit->session_id = $school->session_id;
        $submit->term = $school->term;
        $submit->class_id = $request->class_id;
        $submit->officer = $request->officer;
        $submit->teacher_id = auth()->user()->id;
        $submit->save();

        return response()->json([
            'status'=>200,
            'message'=>'Comments Added Successfully',
        ]);
    }

    public function viewComments(Request $request)
    {

            $school = School::select('id','session_id','term',)->where('id', Auth::user()->school_id)->first();
           $comments = Comment::with('student')->select('comment','additional','student_id')->where('officer',$request->officer)->where('class_id',$request->class_id)->where('term', $school->term)->where('session_id',$school->session_id)->where('school_id', $school->id)->get();
           return response()->json($comments);
    }
}

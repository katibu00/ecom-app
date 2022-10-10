<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Comment;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $school = School::select('id','name','email','phone_first','phone_second','address','heading','grading')->where('id', $user->school_id)->first();
        $data['classes'] = Classes::select('id','name')->where('school_id',auth()->user()->school_id)->get(); 

        // $data['comments'] = Comment::where('')
        return view('comments.index',$data);
    }
}

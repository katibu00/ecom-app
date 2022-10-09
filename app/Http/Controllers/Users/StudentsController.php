<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File as File;

class StudentsController extends Controller
{
    public function index()
    {
        $data['classes'] = Classes::select('id', 'name')->where('school_id',auth()->user()->school_id)->get();
        $data['students'] = User::select('id', 'first_name','middle_name','last_name','login','gender','class_id','parent_id')->where('usertype','std')->where('school_id',auth()->user()->school_id)->where('status',1)->with(['class'])->orderBy('gender', 'desc')->orderBy('first_name')->get();
        return view('users.students.index',$data);
    }

    public function create()
    {
        $data['classes'] = Classes::select('id', 'name')->where('school_id',auth()->user()->school_id)->get();
        return view('users.students.create', $data);
    }

    public function store(Request $request)
    {
        $rowCount = count($request->first_name);
        if($rowCount != NULL){
            for ($i=0; $i < $rowCount; $i++){
                $data = new User();
                $data->first_name = $request->first_name[$i];
                $data->middle_name = $request->middle_name[$i];
                $data->last_name = $request->last_name[$i];
                $data->gender = $request->gender[$i];
                $data->login = $request->roll_number[$i];
                $data->usertype = 'std';
                $data->class_id = $request->class_id;
                $data->school_id = auth()->user()->school_id;
                $data->password = Hash::make('123');
                $data->save();
            }
        };
        return response()->json([
            'status'=>200,
            'message'=>'Students(s) Registered Successfully',
        ]);
    }
    

    public function sort(Request $request)
    {
        $data['classes'] = Classes::select('id', 'name')->where('school_id',auth()->user()->school_id)->get();

        if($request->class_id == 'All')
        {
            $data['students'] = User::select('id', 'first_name','middle_name','last_name','login','gender','class_id','parent_id')->where('usertype','std')->where('school_id',auth()->user()->school_id)->where('status',1)->with(['class'])->orderBy('gender', 'desc')->orderBy('first_name')->get();
        }else{

            $data['students'] = User::select('id', 'first_name','middle_name','last_name','login','gender','class_id','parent_id')->where('class_id',$request->class_id)->where('usertype','std')->where('school_id',auth()->user()->school_id)->where('status',1)->with(['class'])->orderBy('gender', 'desc')->orderBy('first_name')->get();
        }
      
        if( $data['students']->count() > 0)
        {
            return view('users.students.table', $data)->render();
        }else
        {
            return response()->json([
                'status' => 404,
            ]);
        }
    }

    public function details(Request $request)
    {
        $student = User::with(['class','parent'])->where('id', $request->student_id)->first();
        $registered = $student->created_at->diffForHumans();
        $school_name = School::select('username')->where('id',auth()->user()->school_id)->first();
       
        if($student)
        {
            return response()->json([
                'status'=>200,
                'student'=>$student,
                'registered'=>$registered,
                'school_name'=>$school_name,
            ]);
        }
       
        return response()->json([
            'status'=>400,
            'message'=>'No User Found',
        ]);
    }

    public function bulk_update(Request $request)
    {
        $data['classes'] = Classes::select('id', 'name')->where('school_id',auth()->user()->school_id)->get();

        if($request->class_id)
        {
            // $data['students'] = User::where('usertype','std')->get();
            $data['students'] = User::select('id', 'first_name','middle_name','last_name','login','parent_id','image')->where('usertype','std')->where('school_id',auth()->user()->school_id)->where('status',1)->with(['class'])->orderBy('gender', 'desc')->orderBy('first_name')->get();
            $data['school'] = School::select('username')->where('id',auth()->user()->school_id)->first();
            $data['parents'] = User::where('usertype','std')->get();
            $data['class_id'] = $request->class_id;
        }
        return view('users.students.bulk_update', $data);
    }

    public function bulk_store(Request $request)
    {
        // return $request->all();
        $school = School::select('username')->where('id',auth()->user()->school_id)->first();

        $rowCount = count($request->user_id);
        if($rowCount != NULL){
            for ($i=0; $i < $rowCount; $i++){

                $user = User::find($request->user_id[$i]);
                $user->parent_id = $request->parent_id[$i];
                $user->dob = $request->dob[$i];

                if ($request->file('image'.$i) != null) {
                    $destination = 'uploads/' . $school->username . '/' . $user->image;
                    File::delete($destination);
                    $file = $request->file('image'.$i);
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/' . $school->username, $filename);
                    $user->image = $filename;
                }
                
                $user->update();
            }
        };
        return response()->json([
            'status'=>200,
            'message'=>'Students(s) Updated Successfully',
        ]);
    }
}

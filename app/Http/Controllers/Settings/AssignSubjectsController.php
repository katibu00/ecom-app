<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\AssignSubject;
use App\Models\Classes;
use App\Models\Mark;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssignSubjectsController extends Controller
{
    public function index()
    {
        $data['classes'] = Classes::select('id','name')->where('school_id',auth()->user()->school_id)->where('status',1)->get();
        $data['subjects'] = Subject::select('id','name')->where('school_id',auth()->user()->school_id)->get();
        $data['staffs'] = User::select('id','first_name','last_name')->where('usertype','!=','student')->where('usertype','!=','parent')->get();
        return view('settings.assign_subjects.index',$data);
    }

    public function store(Request $request)
    {

        $rowCount = count($request->subject_id);
        if($rowCount != NULL){
            for ($i=0; $i < $rowCount; $i++){
                $data = new AssignSubject();
                $data->class_id = $request->class_id;
                $data->subject_id = $request->subject_id[$i];
                $data->teacher_id = $request->teacher_id[$i];
                $data->designation = $request->designation[$i];
                $data->school_id = auth()->user()->school_id;
                $data->save();
            }
        }

        return response()->json([
            'status'=>200,
            'message'=>'Subject(s) Assigned Successfully',
        ]);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'teacher_id'=>'required',
            'designation'=>'required',
        ]);
       
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
      
        $data = AssignSubject::findOrFail($request->id);
        $data->teacher_id = $request->teacher_id;
        $data->designation = $request->designation;
        $data->update();

        return response()->json([
            'status'=>200,
            'message'=>'Subject Assignment Updated Successfully',
        ]);
    }

    public function delete(Request $request){
       
        $data = AssignSubject::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'Assign Subject Deleted Successfully'
            ]);

        };
    
    }
}

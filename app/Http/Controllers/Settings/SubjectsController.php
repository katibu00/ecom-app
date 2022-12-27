<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\AssignSubject;
use App\Models\Mark;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectsController extends Controller
{
    public function index()
    {
        $data['subjects'] = Subject::where('school_id',auth()->user()->school_id)->get();
        return view('settings.subjects.index', $data);
    }

    public function store(Request $request)
    {

        $classCount = count($request->name);
        if($classCount != NULL){
            for ($i=0; $i < $classCount; $i++){
                $data = new Subject();
                $data->name = $request->name[$i];
                $data->school_id = auth()->user()->school_id;
                $data->save();
            }
        }

        return response()->json([
            'status'=>200,
            'message'=>'Subject(s) Created Successfully',
        ]);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'=>'required',
        ]);
       
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
      
        $data = Subject::findOrFail($request->id);
        $data->name = $request->name;
        $data->update();

        return response()->json([
            'status'=>200,
            'message'=>'Subject Updated Successfully',
        ]);
    }

    public function delete(Request $request){
        $check = Mark::where('subject_id', $request->id)->first();
        if($check)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Subject has marks data and hence cannot be deleted'
            ]);
        }
        $check2 = AssignSubject::where('subject_id', $request->id)->first();
        if($check2)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Subject has Assign Subject data and hence cannot be deleted'
            ]);
        }
        $data = Subject::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'Subject Deleted Successfully'
            ]);

        };
    
    }
}

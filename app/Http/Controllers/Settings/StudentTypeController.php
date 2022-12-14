<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\FeeStructure;
use App\Models\StudentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentTypeController extends Controller
{
    public function index()
    {
        $data['student_types'] = StudentType::select('id', 'name','status')->where('school_id',auth()->user()->school_id)->latest()->get();
        return view('settings.student_type.index', $data);
    }

    public function store(Request $request)
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

        $dataCount = count($request->name);
        if($dataCount != NULL){
            for ($i=0; $i < $dataCount; $i++){
                $data = new StudentType();
                $data->name = $request->name[$i];
                $data->school_id = auth()->user()->school_id;
                $data->save();
            }
        }

        return response()->json([
            'status'=>201,
            'message'=>'Student Types Created Successfully',
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
      
        $data = StudentType::findOrFail($request->id);
        $data->name = $request->name;
        $data->status = $request->status;
        $data->update();

        return response()->json([
            'status'=>200,
            'message'=>'Student Type Updated Successfully',
        ]);
    }

    public function delete(Request $request){
        $check = FeeStructure::where('student_type', $request->id)->first();
        if($check)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Student Type has been used and hence cannot be deleted'
            ]);
        }
        $data = StudentType::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'Student Type Deleted Successfully'
            ]);

        };
    
    }
}

<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassesController extends Controller
{
    public function index()
    {
        $data['classes'] = Classes::with('section')->where('school_id',auth()->user()->school_id)->get();
        $data['sections'] = Section::select('id','name')->where('school_id',auth()->user()->school_id)->get();
        return view('settings.classes.index', $data);
    }

    public function store(Request $request)
    {

        $classCount = count($request->name);
        if($classCount != NULL){
            for ($i=0; $i < $classCount; $i++){
                $data = new Classes();
                $data->name = $request->name[$i];
                $data->school_id = auth()->user()->school_id;
                $data->section_id = $request->section_id;
                $data->save();
            }
        }

        return response()->json([
            'status'=>200,
            'message'=>'class(s) Created Successfully',
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
      
        $data = Classes::findOrFail($request->id);
        $data->name = $request->name;
        $data->status = $request->status;
        $data->update();

        return response()->json([
            'status'=>200,
            'message'=>'Class Updated Successfully',
        ]);
    }

    public function delete(Request $request){

        $data = Classes::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'Class Deleted Successfully'
            ]);

        };
    
    }
}

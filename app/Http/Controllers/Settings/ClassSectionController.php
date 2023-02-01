<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\ClassSection;
use App\Models\Mark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassSectionController extends Controller
{
    public function index()
    {
        $data['sections'] = ClassSection::select('id','name','status')->where('school_id',auth()->user()->school_id)->get();
        return view('settings.class_section.index', $data);
    }

    public function store(Request $request)
    {

        $classCount = count($request->name);
        if($classCount != NULL){
            for ($i=0; $i < $classCount; $i++){
                $data = new ClassSection();
                $data->name = $request->name[$i];
                $data->school_id = auth()->user()->school_id;
                $data->save();
            }
        }

        return response()->json([
            'status'=>200,
            'message'=>'class Section(s) Created Successfully',
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
      
        $data = ClassSection::findOrFail($request->id);
        $data->name = $request->name;
        $data->status = $request->status;
        $data->update();

        return response()->json([
            'status'=>200,
            'message'=>'Class Section Updated Successfully',
        ]);
    }

    public function delete(Request $request){
        $check = Mark::where('class_section_id', $request->id)->first();
        if($check)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Class Section has marks data and hence cannot be deleted'
            ]);
        }
        $data = ClassSection::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'Class Section Deleted Successfully'
            ]);

        };
    
    }
}

<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionsController extends Controller
{
    public function index()
    {
        $data['sections'] = Section::select('id','name')->where('school_id',auth()->user()->school_id)->get();
        return view('settings.school_sections.index', $data);
    }

    public function store(Request $request)
    {

        $dataCount = count($request->name);
        if($dataCount != NULL){
            for ($i=0; $i < $dataCount; $i++){
                $data = new Section();
                $data->name = $request->name[$i];
                $data->school_id = auth()->user()->school_id;
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
      
        $data = Section::findOrFail($request->id);
        $data->name = $request->name;
        $data->update();

        return response()->json([
            'status'=>200,
            'message'=>'Class Updated Successfully',
        ]);
    }

    public function delete(Request $request){

        $data = Section::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'School Section Deleted Successfully'
            ]);

        };
    
    }
}

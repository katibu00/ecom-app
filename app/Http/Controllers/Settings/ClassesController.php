<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\FeeStructure;
use App\Models\Mark;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassesController extends Controller
{
    public function index()
    {
        $school_id = auth()->user()->school_id;
        $data['classes'] = Classes::with('section','formMaster')->where('school_id',$school_id)->get();
        $data['sections'] = Section::select('id','name')->where('school_id', $school_id)->get();
        $data['staffs'] = User::select('id', 'first_name', 'last_name')
                                ->where('school_id', $school_id)
                                ->where('status', 1)
                                ->whereNotIn('usertype', ['std', 'parent', 'intellisas'])
                                ->orderBy('first_name')
                                ->get();

        return view('settings.classes.index', $data);
    }

    public function store(Request $request)
    {
        $school_id =  auth()->user()->school_id;

        $count = Classes::where('school_id', $school_id)->count();

        $classCount = count($request->name);
        if($classCount != NULL){
            for ($i=0; $i < $classCount; $i++){
                $data = new Classes();
                $data->name = $request->name[$i];
                $data->form_master_id = $request->form_master_id[$i];
                $data->school_id = $school_id;
                $data->section_id = $request->section_id;
                $data->save();
            }
        }

        return response()->json([
            'status'=>200,
            'count'=>$count,
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
        $data->form_master_id = $request->form_master_id;
        $data->status = $request->status;
        $data->update();

        return response()->json([
            'status'=>200,
            'message'=>'Class Updated Successfully',
        ]);
    }

    public function delete(Request $request){
        // Check if the class has related data in the `marks` table
        $checkMarks = Mark::where('class_id', $request->id)->first();
    
        // Check if the class has related data in the `fee_structures` table
        $checkFeeStructures = FeeStructure::where('class_id', $request->id)->first();
    
        if ($checkMarks || $checkFeeStructures) {
            return response()->json([
                'status' => 400,
                'message' => 'Class cannot be deleted because it is associated with other data (e.g., marks or fee structures).'
            ]);
        }
    
        $class = Classes::find($request->id);
    
        if ($class->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Class Deleted Successfully'
            ]);
        }
    
        return response()->json([
            'status' => 400,
            'message' => 'Failed to delete the class. Please try again later.'
        ]);
    }
    
}

<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\FeeCategory;
use App\Models\FeeStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeeStructuresController extends Controller
{
    public function index()
    {
        $school_id = auth()->user()->school_id;
        $data['fees'] = FeeCategory::select('id', 'name','priority')->where('school_id',$school_id)->where('status',1)->orderBy('priority', 'asc')->latest()->get();
        $data['classes'] = Classes::select('id','name')->where('school_id',$school_id)->get();
        return view('settings.fee_structure.index', $data);
    }

    public function store(Request $request)
    {
        // return $request->all();

        $isExist = FeeStructure::where('school_id',auth()->user()->school_id)->where('class_id',$request->class_id)->where('student_type',$request->student_type)->first();
        if($isExist)
        {
            return response()->json([
                'status'=>400,
                'message'=>'Fee Structure Already Created',
            ]);
        }

        $dataCount = count($request->fee_id);
        if($dataCount != NULL){
            for ($i=0; $i < $dataCount; $i++){
                $data = new FeeStructure();
                $data->school_id = auth()->user()->school_id;
                $data->class_id = $request->class_id;
                $data->student_type = $request->student_type;
                $data->fee_category_id = $request->fee_id[$i];
                $data->amount = $request->amount[$i];
                $data->save();
            }
        }

        return response()->json([
            'status'=>201,
            'message'=>'Fee Structure Created Successfully',
        ]);
    }
    
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'priority'=>'required',
        ]);
       
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
      
        $data = FeeStructure::findOrFail($request->id);
        $data->name = $request->name;
        $data->priority = $request->priority;
        $data->status = $request->status;
        $data->update();

        return response()->json([
            'status'=>200,
            'message'=>'Fee Category Updated Successfully',
        ]);
    }

    public function delete(Request $request){

        $data = FeeStructure::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'Fee Category Deleted Successfully'
            ]);

        };
    
    }

    public function details(Request $request)
    {
       
        $student_type = '';

        if($request->std_type == 'Regular')
        {
            $student_type = 'r';
        }
        else
        {
            $student_type = 't';
        };

        $fees = FeeStructure::with('fee_category')->where('school_id',auth()->user()->school_id)->where('class_id',$request->class_id)->where('student_type',$student_type)->get();
        $amount = FeeStructure::select('amount')->where('school_id',auth()->user()->school_id)->where('class_id',$request->class_id)->where('student_type',$student_type)->sum('amount');

        return response()->json([
            'status'=>200,
            'fees'=>$fees,
            'amount'=>number_format($amount,0),
        ]);
     

    }
}

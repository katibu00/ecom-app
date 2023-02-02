<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\FeeCategory;
use App\Models\FeeStructure;
use App\Models\StudentType;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeeStructuresController extends Controller
{
    public function index()
    {
        $school_id = auth()->user()->school_id;
        $data['fees'] = FeeCategory::select('id', 'name','priority')->where('school_id',$school_id)->where('status',1)->orderBy('priority', 'asc')->latest()->get();
        $data['classes'] = Classes::select('id','name')->where('school_id',$school_id)->get();
        $data['student_types'] = StudentType::select('id','name')->where('school_id',$school_id)->where('status',1)->get();
        return view('settings.fee_structure.index', $data);
    }

    public function store(Request $request)
    {
       

        $dataCount = count($request->fee_id);
        if($dataCount != NULL){
            for ($i=0; $i < $dataCount; $i++){

                $isExist = FeeStructure::where('school_id',auth()->user()->school_id)
                ->where('class_id',$request->class_id)
                ->where('student_type',$request->student_type)
                ->where('fee_category_id',$request->fee_id[$i])
                ->first();
                if(!$isExist)
                {
                    $data = new FeeStructure();
                    $data->school_id = auth()->user()->school_id;
                    $data->class_id = $request->class_id;
                    $data->student_type = $request->student_type;
                    $data->fee_category_id = $request->fee_id[$i];
                    $data->amount = $request->amount[$i];
                    $data->save();
                }else
                {
                    Toastr::error('Fee Structure Already Exist in the selected Class and Student Type');
                    return redirect()->route('settings.fee_structure.index');     
                }
               
            }
        }

        Toastr::success('Fee Structure Created Successfully');
        return redirect()->route('settings.fee_structure.index');
    }
    
    public function delete(Request $request){

        $data = FeeStructure::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'Fee Category Unassigned Successfully'
            ]);

        };
    
    }

    public function details(Request $request)
    {
       $school_id = auth()->user()->school_id;
        $student_type = '';

        if($request->std_type == 'Regular')
        {
            $student_type = 'r';
        }
        else if($request->std_type == 'Transfer')
        {
            $student_type = 't';
        }else{
            $student_type = StudentType::where('school_id',$school_id)->where('name',$request->std_type)->first()->id;
        };

        $fees = FeeStructure::with('fee_category')->where('school_id', $school_id)->where('class_id',$request->class_id)->where('student_type',$student_type)->get();
        $amount = FeeStructure::select('amount')->where('school_id', $school_id)->where('class_id',$request->class_id)->where('student_type',$student_type)->sum('amount');

        return response()->json([
            'status'=>200,
            'fees'=>$fees,
            'amount'=>number_format($amount,0),
        ]);
     

    }

    public function edit(Request $request)
    {
        $school_id =auth()->user()->school_id;
        $student_type = '';
        if($request->student_type == 'regular')
        {
            $student_type = 'r';
        }
        else
        {
            $student_type = 't';
        };
        $data['fees'] = FeeCategory::select('id', 'name')->where('school_id',$school_id)->get();
        $data['rows'] = FeeStructure::with('fee_category')->select('id','fee_category_id', 'amount','status')->where('school_id', $school_id)->where('class_id',$request->class_id)->where('student_type',$student_type)->get();
        $data['student_type'] = $student_type;
        $data['class_id'] = $request->class_id;
        return view('settings.fee_structure.edit',$data);
    }
    public function update(Request $request)
    {
        $data = FeeStructure::find($request->id);
        $data->amount = $request->amount;
        $data->status = $request->status;
        $data->update();

        return response()->json([
            'status'=>200,
            'message'=>'Fee Structure Updated Successfully',
        ]);
       
    }
}

<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\FeeCategory;
use App\Models\FeeStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeeCategoriesController extends Controller
{
    public function index()
    {
        $data['fee_categories'] = FeeCategory::select('id', 'name','priority','status')->where('school_id',auth()->user()->school_id)->orderBy('priority', 'asc')->latest()->get();
        return view('settings.fee_category.index', $data);
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
                $data = new FeeCategory();
                $data->name = $request->name[$i];
                $data->priority = $request->priority[$i];
                $data->school_id = auth()->user()->school_id;
                $data->save();
            }
        }

        return response()->json([
            'status'=>201,
            'message'=>'Fee Category Created Successfully',
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
      
        $data = FeeCategory::findOrFail($request->id);
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
        $check = FeeStructure::where('fee_category_id', $request->id)->first();
        if($check)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Fee has been assigned and hence cannot be deleted'
            ]);
        }
        $data = FeeCategory::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'Fee Category Deleted Successfully'
            ]);

        };
    
    }
}

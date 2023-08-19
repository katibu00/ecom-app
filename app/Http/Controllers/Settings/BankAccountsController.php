<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankAccountsController extends Controller
{
    public function index()
    {
        $data['bank_accounts'] = BankAccount::select('id', 'name','bank','number','status')->where('school_id',auth()->user()->school_id)->get();
        return view('settings.bank_accounts.index', $data);
    }

    public function store(Request $request)
    {

        $dataCount = count($request->name);
        if($dataCount != NULL){
            for ($i=0; $i < $dataCount; $i++){
                $data = new BankAccount();
                $data->name = $request->name[$i];
                $data->bank = $request->bank[$i];
                $data->number = $request->number[$i];
                $data->school_id = auth()->user()->school_id;
                $data->save();
            }
        }

        return response()->json([
            'status'=>201,
            'message'=>'Bank Account Created Successfully',
        ]);
    }
    
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'number'=>'required',
            'bank'=>'required',
        ]);
       
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
      
        $data = BankAccount::findOrFail($request->id);
        $data->name = $request->name;
        $data->bank = $request->bank;
        $data->number = $request->number;
        $data->status = $request->status;
        $data->update();

        return response()->json([
            'status'=>200,
            'message'=>'Bank Account Updated Successfully',
        ]);
    }

    public function delete(Request $request){
        // $check = BankAccount::where('id', $request->id)->first();
        // if($check)
        // {
        //     return response()->json([
        //         'status' => 400,
        //         'message' => 'Fee has been assigned and hence cannot be deleted'
        //     ]);
        // }
        $data = BankAccount::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'Bank Account Deleted Successfully'
            ]);

        };
    
    }
}

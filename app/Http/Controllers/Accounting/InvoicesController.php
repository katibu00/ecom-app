<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\FeeStructure;
use App\Models\Invoice;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    public function index()
    {
       
        $school = School::select('id','term','session_id')->where('id', auth()->user()->school_id)->first();
        $data['classes'] = Classes::select('id','name')->where('school_id',$school->id)->get();
        $data['invoices'] = Invoice::with(['student','class'])->where('school_id',$school->id)->where('session_id',$school->session_id)->where('term',$school->term)->get(); 
        return view('accounting.invoices.index',$data);
    }

    public function getRecords(Request $request)
    {
        $students = User::select('first_name','middle_name','last_name','id','login','parent_id')->where('class_id',$request->class_id)->where('usertype','std')->where('school_id',auth()->user()->school_id)->where('status',1)->with('parent')->orderBy('gender', 'desc')->orderBy('first_name')->get();
      
        return response()->json([
            'students'=>$students,
        ]);
    }

    public function storeInvoices(Request $request)
    {
        // return $request->all();

        $regular = FeeStructure::select('amount')->where('school_id',auth()->user()->school_id)->where('class_id',$request->class_id)->where('student_type','r')->sum('amount');
        $transfer = FeeStructure::select('amount')->where('school_id',auth()->user()->school_id)->where('class_id',$request->class_id)->where('student_type','t')->sum('amount');

        $school = School::select('id','session_id','term',)->where('id', Auth::user()->school_id)->first();
        
        $rowCount = count($request->student_id);
        if($rowCount != NULL){
            for ($i=0; $i < $rowCount; $i++){
                $data = new Invoice();
                $data->school_id = $school->id;
                $data->session_id = $school->session_id;
                $data->term = $school->term;
                $data->class_id = $request->class_id;
                $data->student_id = $request->student_id[$i];
                $data->student_type = $request->student_type[$i];

                @$number = Invoice::select('number')->where('school_id',$school->id)->where('session_id',$school->session_id)->where('term',$school->term)->orderBy('id','desc')->first()->number;
               
                if(!$number){
                    $number = 0;
                }
                $data->number = $number+1;
          
                if($request->student_type[$i] == 'r' || $request->student_type[$i] == 's'){
                    $data->amount = $regular;
                }
                if($request->student_type[$i] == 't'){
                    $data->amount = $transfer;
                }
               
                if($request->student_type[$i] == 's'){
                    $data->discount = $regular;
                }else{
                    $data->discount = $request->discount[$i];
                }
               
                $data->save();
            }
        };

        return response()->json([
            'status'=>200,
            'message'=>'Invoices Generated Successfully',
        ]);
    }
}

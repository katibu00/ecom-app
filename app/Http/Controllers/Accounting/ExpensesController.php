<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function index()
    {
        $data['expense_cats'] = ExpenseCategory::all();
        $data['staffs'] = User::select('id','first_name','last_name')
                        ->where('usertype','!=','std')
                        ->where('usertype','!=','parent')
                        ->where('usertype','!=','intellisas')
                        ->where('school_id',auth()->user()->school_id)
                        ->where('status',1)
                        ->orderBy('first_name')
                        ->get();      
        $data['expenses'] = Expense::where('school_id', auth()->user()->school_id)->orderBy('date','desc')->get();
        return view('accounting.expenses.index',$data);
    }

    public function store(Request $request)
    {
        // return $request->all();
        $school = School::select('id', 'term', 'session_id')->where('id', auth()->user()->school_id)->first();

        $dataCount = count($request->date);
        if($dataCount != NULL){
            for ($i=0; $i < $dataCount; $i++){
                $data = new Expense();
                $data->school_id = $school->id;
                $data->session_id = $school->session_id;
                $data->term = $school->term;
                $data->date = $request->date[$i];
                @$number = Expense::select('number')->where('school_id', $school->id)->where('session_id', $school->session_id)->where('term', $school->term)->orderBy('id', 'desc')->first()->number;

                if (!$number) {
                    $number = 0;
                }
                $data->number = $number + 1;
                $data->description = $request->description[$i];
                $data->expense_category_id = $request->expense_category_id[$i];
                $data->payer_id = auth()->user()->id;
                $data->payee_id = $request->payee_id[$i];
                $data->amount = $request->amount[$i];
                $data->save();
            }
        }

        return response()->json([
            'status'=>201,
            'message'=>'Expenses Recorded Successfully',
        ]);
    }
}

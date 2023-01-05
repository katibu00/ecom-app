<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Invoice;
use App\Models\PaymentRecord;
use App\Models\School;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function intellisas()
    {
        return view('home.intellisas');
    }
    public function admin()
    {
        $school = School::select('id','term','session_id')->where('id',auth()->user()->school_id)->first();
        $data['fee_collected'] = PaymentRecord::select('paid_amount')->where('session_id',$school->session_id)
                                ->where('term',$school->term)
                                ->where('school_id',$school->id)
                                ->sum('paid_amount');
        $data['total_expenses'] = Expense::select('amount')->where('session_id',$school->session_id)
                                ->where('term',$school->term)
                                ->where('school_id',$school->id)
                                ->sum('amount');
        $invoices = Invoice::select('amount','discount','pre_balance')->where('session_id',$school->session_id)
                            ->where('term',$school->term)
                            ->where('school_id',$school->id)
                            ->get();

        $data['total_invoice'] = 0;
        $data['total_discount'] = 0;
        $data['total_pre_bal'] = 0;
        foreach($invoices as $invoice)
        {
            $data['total_invoice'] += $invoice->amount;
            $data['total_discount'] += $invoice->discount;
            $data['total_pre_bal'] += $invoice->pre_balance;
        }
        return view('home.admin',$data);
    }
}

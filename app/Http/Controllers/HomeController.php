<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\PaymentRecord;
use App\Models\PaymentSlip;
use App\Models\ReservedAccount;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $data['payments'] = PaymentRecord::selectRaw('MONTH(created_at) as month, SUM(paid_amount) as total')
        ->where('school_id',$school->id)
        ->where('session_id', $school->session_id)
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();


        $attendance = Attendance::select(DB::raw('status, COUNT(*) as total'))
                ->where('term', $school->term)
                ->groupBy('status')
                ->get();
        $present = 0;
        $absent = 0;
        $leave = 0;
        foreach($attendance as $row){
            if($row->status == 'present'){
                $present = $row->total;
            }else if($row->status == 'absent'){
                $absent = $row->total;
            }else if($row->status == 'leave'){
                $leave = $row->total;
            }
        }
        $total = $present + $absent + $leave;
        $data['present_percent'] = round(($present / $total) * 100, 2);
        $data['absent_percent'] = round(($absent / $total) * 100, 2);
        $data['leave_percent'] = round(($leave / $total) * 100, 2);
        $data['total'] = $total;

        return view('home.admin',$data);
    }

    public function parent()
    {
        $school_id = auth()->user()->school_id;
        $data['school'] = School::select('id','term','session_id','username')->where('id',$school_id)->first();

        $data['children'] = User::select('id','first_name','middle_name','last_name','class_id','image')
        ->where('parent_id', auth()->user()->id)
        ->where('school_id', $school_id)
        ->get();


        $total_amount_due = 0;
        $total_discount = 0;
        $total_pre_balance = 0;
        $total_paid = 0;

        foreach($data['children'] as $child)
        {
            $paymentSlip = PaymentSlip::select('payable','discount','paid','invoice_id')
                            ->where('student_id', $child->id)
                            ->where('school_id', $school_id)
                            ->where('session_id', $data['school']->session_id)
                            ->where('term',  $data['school']->term)
                            ->first();
            if($paymentSlip)
            {
                $total_amount_due += $paymentSlip->payable;
                $pre_balance = Invoice::select('pre_balance')->where('id',$paymentSlip->invoice_id)->first();
                $total_discount += $paymentSlip->discount;
                $total_pre_balance += @$pre_balance->pre_balance;
            }else
            {
                $invoice = Invoice::select('amount','discount','pre_balance')
                            ->where('student_id', $child->id)
                            ->where('school_id', $school_id)
                            ->where('session_id', $data['school']->session_id)
                            ->where('term',  $data['school']->term)
                            ->first();
                if($invoice)
                {
                    $total_amount_due +=  $invoice->amount;
                    $total_discount +=  $invoice->discount;
                    $total_pre_balance +=  $invoice->pre_balance;
                }
               
            }

            $total_paid += PaymentRecord::select('paid_amount')
                            ->where('student_id', $child->id)
                            ->where('school_id', $school_id)
                            ->where('session_id', $data['school']->session_id)
                            ->where('term',  $data['school']->term)
                            ->sum('paid_amount');
            
        }
        $data['total_amount_due'] = $total_amount_due;
        $data['total_discount'] = $total_discount;
        $data['total_pre_balance'] = $total_pre_balance;
        $data['total_paid'] = $total_paid;
       
        $query = ReservedAccount::where('user_id', auth()->user()->id)->first();

        if ($query) {
            $data['accounts'] = json_decode($query->accounts, true);
        } else {
            $data['accounts'] = [];
        }

        return view('home.parent',$data);
    }
    public function teacher()
    {
        $school_id = auth()->user()->school_id;
        $data['school'] = School::select('id','term','session_id','username')->where('id',$school_id)->first();

       


        return view('home.teacher',$data);
    }
}

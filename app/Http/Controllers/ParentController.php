<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\FeeStructure;
use App\Models\Invoice;
use App\Models\PaymentSlip;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function feesIndex()
    {
        $school_id = auth()->user()->school_id;
        $data['school'] = School::select('id', 'term', 'session_id', 'username', 'address', 'phone_first', 'phone_second', 'website', 'name', 'email')->where('id', $school_id)->first();
        $data['accounts'] = BankAccount::where('school_id',$school_id)->where('status',1)->get();
        $data['children'] = User::select('id', 'first_name', 'middle_name', 'last_name', 'class_id', 'image')
            ->where('parent_id', auth()->user()->id)
            ->where('school_id', $school_id)
            ->get();

        

        return view('parents.fees_billing.index', $data);
    }
    public function markOptional(Request $request)
    {
        // dd($request->all());
        $school_id = auth()->user()->school_id;
        $school = School::select('id', 'term', 'session_id')->where('id', $school_id)->first();
        $message = '';
        $paymentSlip = PaymentSlip::select('id', 'payable', 'additional')
            ->where('school_id', $school->id)
            ->where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->where('student_id', $request->student_id)
            ->first();

        if ($paymentSlip) {

            $additionalDataString = $paymentSlip->additional;

            $additionalDataArray = explode(',', $additionalDataString);

            if ($request->action === 'checked') {
                if (!in_array($request->fee_id, $additionalDataArray)) {

                    $additionalDataArray[] = $request->fee_id;
                    $paymentSlip->payable += $request->amount;
                    $message = "Fee Added Successfully";

                }
            } elseif ($request->action === 'unchecked') {
                $index = array_search($request->fee_id, $additionalDataArray);
                if ($index !== false) {

                    unset($additionalDataArray[$index]);
                    $paymentSlip->payable -= $request->amount;
                    $message = "Fee Removed Successfully";

                }
            }

            $additionalDataArray = array_filter($additionalDataArray);

            $additionalDataString = implode(',', $additionalDataArray);
            $paymentSlip->additional = $additionalDataString;
            $paymentSlip->save();

            return response()->json([
                'status' => 200,
                'total_due' =>  $paymentSlip->payable,
                'message' => $message,
            ]);

        } else {
            $slip = new PaymentSlip();
            $slip->school_id = $school_id;
            $slip->session_id = $school->session_id;
            $slip->term = $school->term;
            $slip->student_id = $request->student_id;
            $slip->invoice_id = $request->invoice_id;

            $number = PaymentSlip::select('number')->where('school_id', $school->id)
                ->where('session_id', $school->session_id)
                ->where('term', $school->term)
                ->orderBy('id', 'desc')
                ->first();

            if ($number) {
                $slip->number = $number->number + 1;
            } else {
                $slip->number = 1;
            }
            $slip->additional = $request->fee_id;

            $invoice = Invoice::select('amount', 'discount', 'pre_balance', 'id')
                ->where('school_id', $school->id)
                ->where('session_id', $school->session_id)
                ->where('term', $school->term)
                ->where('student_id', $request->student_id)
                ->first();
            $class = User::select('class_id')->where('id', $request->student_id)->first();

            $mandatory = FeeStructure::select('amount', 'id')
                ->where('school_id', $school->id)
                ->where('class_id', $class->class_id)
                ->where('priority', 'm')
                ->where('status', 1)
                ->where('student_type', 'r')
                ->sum('amount');

            $slip->invoice_id = $invoice->id;
            $slip->payable = $mandatory + $request->amount;
            $slip->discount = $invoice->discount;
            $slip->save();

            return response()->json([
                'status' => 200,
                'total_due' =>  $slip->payable,
                'message' => 'Fee Added Successfully',
            ]);
        }

    }

    public function proccedPayment(Request $request)
    {
        // dd($request->all());

        if($request->payment_method == 'bank')
        {
            $school_id = auth()->user()->school_id;
            $data['accounts'] = BankAccount::where('school_id',$school_id)->where('status',1)->get();
            return view('parents.fees_billing.bank_transfer', $data);
        }
    }

}

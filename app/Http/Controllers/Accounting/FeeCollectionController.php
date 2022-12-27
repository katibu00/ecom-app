<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Classes;
use App\Models\FeeStructure;
use App\Models\Invoice;
use App\Models\PaymentRecord;
use App\Models\PaymentSlip;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FeeCollectionController extends Controller
{
    public function index()
    {

        $school = School::select('id', 'term', 'session_id')->where('id', auth()->user()->school_id)->first();
        $data['classes'] = Classes::select('id', 'name')->where('school_id', $school->id)->get();
        $data['accounts'] = BankAccount::where('school_id',$school->id)->where('status',1)->get();
        return view('accounting.fee_collection.index', $data);
    }

    public function getInvoices(Request $request)
    {
        $school = School::select('id', 'term', 'session_id')->where('id', auth()->user()->school_id)->first();
        $invoices = Invoice::select('student_id', 'id', 'number', 'discount')
            ->with('student')
            ->where('school_id', $school->id)
            ->where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->where('class_id', $request->class_id)

            ->get();
        return response()->json([
            'invoices' => $invoices,
        ]);
    }

    public function getFees(Request $request)
    {
        $paymentSlip = PaymentSlip::where('invoice_id', $request->invoice_id)
                    ->where('school_id',auth()->user()->school_id)
                    ->first();

        if ($paymentSlip) {
            $mandatories = FeeStructure::with('fee_category')
                ->whereHas('fee_category', function ($query) {
                    $query->where('priority', 'm');
                })
                ->where('school_id', auth()->user()->school_id)
                ->where('class_id', $request->class_id)
                ->where('student_type', 'r')->get();

            $mandatory_sum = FeeStructure::with('fee_category')
                ->whereHas('fee_category', function ($query) {
                    $query->where('priority', 'm');
                })
                ->where('school_id', auth()->user()->school_id)
                ->where('class_id', $request->class_id)
                ->where('student_type', 'r')->sum('amount');

            $total_invoice = FeeStructure::where('school_id', auth()->user()->school_id)
                ->where('class_id', $request->class_id)
                ->where('student_type', 'r')->sum('amount');

            $invoice_discount = Invoice::where('id', $request->invoice_id)->first();
            $student = User::select('first_name','middle_name','last_name')->where('id',$invoice_discount->student_id)->first();
            $additional_fees = explode(',', @$paymentSlip->additional); 
          
            $additionals = [];
            foreach($additional_fees as $field){
                $data_row = FeeStructure::with('fee_category')->where('id',$field)->first();
                array_push($additionals, $data_row);
            }
         
            $all_payments = PaymentRecord::select('id','student_id','number','paid_amount','description')->where('invoice_id',$request->invoice_id)->latest()->get();
            $total_paid = 0;
            foreach($all_payments as $payment)
            {
                $total_paid+= $payment->paid_amount;
            }
            $balance = (int)$paymentSlip->payable-(int)$invoice_discount->discount-(int)$total_paid;

            return response()->json([
                'mandatories' => $mandatories,
                'additionals' => $additionals,
                'recommededs' => [],
                'mandatory_sum' => $mandatory_sum,
                'total_invoice' => $total_invoice,
                'student' => $student,
                'all_payments' => $all_payments,
                'total_paid' => $total_paid,
                'balance' => $balance,
                'total_payable' => $paymentSlip->payable,
                'discounted_amount' => $paymentSlip->payable-$paymentSlip->discount,
                'initial' => 'no',
                'invoice_discount' => $invoice_discount->discount,
            ]);
            
        } else {

            $mandatories = FeeStructure::with('fee_category')
                ->whereHas('fee_category', function ($query) {
                    $query->where('priority', 'm');
                })
                ->where('school_id', auth()->user()->school_id)
                ->where('class_id', $request->class_id)
                ->where('student_type', 'r')->get();
            $mandatory_sum = FeeStructure::with('fee_category')
                ->whereHas('fee_category', function ($query) {
                    $query->where('priority', 'm');
                })
                ->where('school_id', auth()->user()->school_id)
                ->where('class_id', $request->class_id)
                ->where('student_type', 'r')->sum('amount');
            $recommededs = FeeStructure::with('fee_category')
                ->whereHas('fee_category', function ($query) {
                    $query->where('priority', 'r');
                })
                ->where('school_id', auth()->user()->school_id)
                ->where('class_id', $request->class_id)
                ->where('student_type', 'r')->get();
            $optionals = FeeStructure::with('fee_category')
                ->whereHas('fee_category', function ($query) {
                    $query->where('priority', 'o');
                })
                ->where('school_id', auth()->user()->school_id)
                ->where('class_id', $request->class_id)
                ->where('student_type', 'r')->get();

            $total_invoice = FeeStructure::where('school_id', auth()->user()->school_id)
                ->where('class_id', $request->class_id)
                ->where('student_type', 'r')->sum('amount');
            $invoice_discount = Invoice::where('id', $request->invoice_id)->first();
            $student = User::select('first_name','middle_name','last_name')->where('id',$invoice_discount->student_id)->first();
            $balance = $mandatory_sum- $invoice_discount->discount;
            return response()->json([
                'mandatories' => $mandatories,
                'recommededs' => $recommededs,
                'optionals' => $optionals,
                'additionals' => [],
                'mandatory_sum' => $mandatory_sum,
                'total_invoice' => $total_invoice,
                'balance' => $balance,
                'student' => $student,
                'initial' => 'yes',
                'invoice_discount' => $invoice_discount->discount,
            ]);

        }

    }

    public function InitializePayment(Request $request)
    {

        $school = School::select('id', 'term', 'session_id')->where('id', auth()->user()->school_id)->first();
        $invoice = Invoice::select('student_id', 'class_id')->where('id', $request->invoice_id)->first();

        $data = new PaymentSlip();
        $data->school_id = $school->id;
        $data->session_id = $school->session_id;
        $data->term = $school->term;
        $data->student_id = $invoice->student_id;
        $data->class_id = $invoice->class_id;
        $data->invoice_id = $request->invoice_id;

        @$number = PaymentSlip::select('number')->where('school_id', $school->id)->where('session_id', $school->session_id)->where('term', $school->term)->orderBy('id', 'desc')->first()->number;

        if (!$number) {
            $number = 0;
        }
        $data->number = $number + 1;

        $additional_fields = [];
        if($request->additional != ''){
            $additional_fields = $request->additional;
        }
        $data->additional = implode(',', @$additional_fields);
        $data->payable = $request->total_amount;
        $data->discount = $request->discount;
        $data->save();

        return response()->json([
            'status' => 200,
            'message' => 'Payment Initiated Successfully',
        ]);

    }

    public function recordPayment(Request $request)
    {

        $school = School::select('id', 'term', 'session_id')->where('id', auth()->user()->school_id)->first();
        $invoice = Invoice::select('student_id', 'class_id')->where('id', $request->invoice_id)->first();

        $data = new PaymentRecord();
        $data->school_id = $school->id;
        $data->session_id = $school->session_id;
        $data->term = $school->term;
        $data->student_id = $invoice->student_id;
        $data->class_id = $invoice->class_id;
        $data->invoice_id = $request->invoice_id;

        @$number = PaymentRecord::select('number')->where('school_id', $school->id)->where('session_id', $school->session_id)->where('term', $school->term)->orderBy('id', 'desc')->first()->number;

        if (!$number) {
            $number = 0;
        }
        $data->number = $number + 1;
      
        $data->paid_amount = $request->paid_amount;
        $data->method = $request->method;
        $data->description = $request->description;
        $data->save();

        $slip = PaymentSlip::where('school_id', $school->id)->where('invoice_id',$request->invoice_id)->first();
        $slip->paid = $slip->paid + $request->paid_amount;
        $slip->update();

        return response()->json([
            'status' => 200,
            'message' => 'Payment Recorded Successfully',
        ]);

    }


    public function refreshPayment(Request $request)
    {
        $all_payments = PaymentRecord::select('id','student_id','number','paid_amount','description')->where('invoice_id',$request->invoice_id)->latest()->get();
        $total_paid = PaymentRecord::select('id')->where('invoice_id',$request->invoice_id)->sum('paid_amount');
       
        $paymentSlip = PaymentSlip::where('invoice_id', $request->invoice_id)
                    ->where('school_id',auth()->user()->school_id)
                    ->first();
        $invoice_discount = Invoice::where('id', $request->invoice_id)->first();

        $balance = (int)$paymentSlip->payable-(int)$invoice_discount->discount-(int)$total_paid;

        return response()->json([
            'all_payments' => $all_payments,
            'total_paid' => $total_paid,
            'balance' => $balance,
        ]);

    }

    public function generateReceipt($id)
    {
        $payment_record = PaymentRecord::select('number','student_id','session_id','term','invoice_id','paid_amount','description','created_at')->where('id',$id)->first();
        $payment_slip = PaymentSlip::select('session_id','term','number','payable','discount','paid')->where('invoice_id',$payment_record->invoice_id)->first();
    
        $school = School::select('name','username','motto','address','phone_first','phone_second','email','website','logo','heading')->where('id', auth()->user()->school_id)->first();

        $student = User::where('id',$payment_record->student_id)->first();

         $pdf = Pdf::loadView('pdfs.account.admin.receipt', compact('school','student','payment_slip','payment_record'));
         return $pdf->stream('SPR - '.$student->login.'.pdf');
 
    }
}

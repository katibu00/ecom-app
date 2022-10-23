<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\FeeStructure;
use App\Models\Invoice;
use App\Models\PaymentRecord;
use App\Models\PaymentSlip;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class FeeCollectionController extends Controller
{
    public function index()
    {

        $school = School::select('id', 'term', 'session_id')->where('id', auth()->user()->school_id)->first();
        $data['classes'] = Classes::select('id', 'name')->where('school_id', $school->id)->get();
        // $data['invoices'] = Invoice::with(['student','class'])->where('school_id',$school->id)->where('session_id',$school->session_id)->where('term',$school->term)->get();
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

        $school = School::select('id', 'term', 'session_id')->where('id', auth()->user()->school_id)->first();

        $paymentSlip = PaymentSlip::where('invoice_id', $request->invoice_id)
                    ->where('school_id',$school->id)
                    ->where('session_id',$school->session_id)
                    ->where('term',$school->term)
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
            $fields = explode(',', @$paymentSlip->additional); 
           
            $additionals = [];
            foreach($fields as $field){
                $data_row = FeeStructure::with('fee_category')->where('id',$field)->first();
                array_push($additionals, $data_row);
            }

            $all_payments = PaymentRecord::select('student_id','number','paid_amount','description')->where('invoice_id',$request->invoice_id)->get();

            return response()->json([
                'mandatories' => $mandatories,
                'additionals' => $additionals,
                'recommededs' => [],
                'mandatory_sum' => $mandatory_sum,
                'total_invoice' => $total_invoice,
                'student' => $student,
                'all_payments' => $all_payments,
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

            return response()->json([
                'mandatories' => $mandatories,
                'recommededs' => $recommededs,
                'optionals' => $optionals,
                'additionals' => [],
                'mandatory_sum' => $mandatory_sum,
                'total_invoice' => $total_invoice,
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
}
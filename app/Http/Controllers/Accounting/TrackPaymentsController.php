<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\PaymentRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrackPaymentsController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('paymentSlip')->where('school_id', auth()->user()->school_id)->get();

        return view('accounting.track_payments.index', compact('invoices'));
    }

    public function sort(Request $request)
    {
        $status = $request->input('status');
        $userType = $request->input('userType');

        $invoices = Invoice::query();

        if ($status === 'completed') {
            $invoices->whereHas('paymentSlip', function ($query) {
                $query->whereColumn('payable', '=', 'paid');
            });
        } elseif ($status === 'partial') {
            $invoices->whereHas('paymentSlip', function ($query) {
                $query->whereColumn('payable', '>', 'paid');
            });
        } elseif ($status === 'no_payment') {
            $invoices->whereDoesntHave('paymentSlip');
        }

        $invoices = $invoices->get();

        return view('accounting.track_payments.table', compact('invoices'));
    }




    
    public function fetchInvoiceDetails(Request $request)
    {
        $invoiceId = $request->input('invoiceId');
        
        $invoice = Invoice::find($invoiceId);
        
        if ($invoice) {
            $invoiceDetails = [
                'invoiceNumber' => $invoice->number,
                'totalAmount' => $invoice->amount,
                'previousBalance' => $invoice->pre_balance,
                'discount' => $invoice->discount,
            ];
            
            return response()->json(['invoiceDetails' => $invoiceDetails]);
        }
                return response()->json(['error' => 'Invoice not found.'], 404);
    }







    public function getPaymentHistory(Request $request)
    {
        $studentId = $request->input('studentId');
        $invoiceId = $request->input('invoiceId');
    
        $paymentHistory = PaymentRecord::where('student_id', $studentId)
            ->where('invoice_id', $invoiceId)
            ->get(['created_at', 'paid_amount'])
            ->map(function ($payment) {
                $payment->created_at = Carbon::parse($payment->created_at)->toDateString();
                $payment->paid_amount = number_format($payment->paid_amount, 2, '.', ',');
                return $payment;
            });
    
        return response()->json(['paymentHistory' => $paymentHistory]);
    }
    

    

}

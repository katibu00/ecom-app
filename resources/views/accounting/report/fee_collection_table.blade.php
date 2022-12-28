<div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr class="text-nowrap">
          <th>#</th>
          <th>Student</th>
          <th>Invoice Amount</th>
          <th>Total Payable</th>
          <th>Discount</th>
          <th>Previous Balance</th>
          <th>Total AMount Payable</th>
          <th>Total Ampunt Paid</th>
          <th>Balance</th>
          <th></th>
          
        </tr>
      </thead>
      <tbody>
        @foreach ($students as $key => $student )
        <tr>
          <th scope="row">{{ $key+1 }}</th>
          <td>{{ $student->first_name.' '.$student->middle_name.' '.$student->last_name}}</td>
          @php
            $invoice = App\Models\Invoice::select('id','amount','pre_balance','discount')->where('student_id',$student->id)->where('session_id',$school->session_id)->where('term',$school->term)->first();
            $slip = App\Models\PaymentSlip::select('payable','paid')->where('invoice_id',$invoice->id)->first();
            $paid = App\Models\PaymentRecord::select('paid_amount')->where('student_id',$student->id)->where('invoice_id',$invoice->id)->sum('paid_amount');
            $payable = @$slip->payable-$invoice->discount+$invoice->pre_balance;
          @endphp
          <td>{{ number_format($invoice->amount,0) }}</td>
          <td>{{ number_format(@$slip->payable,0) }}</td>
          <td>{{ number_format($invoice->discount,0) }}</td>
          <td>{{ number_format($invoice->pre_balance,0) }}</td>
          <td>{{ number_format($payable,0) }}</td>
          <td>{{ number_format($paid,0) }}</td>
          <td>{{ number_format($payable-$paid,0) }}</td>
          <td></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
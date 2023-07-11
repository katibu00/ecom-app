<div class="table-responsive text-nowrap">
  <table class="table table-hover table-bordered table-sm" style="font-size: 12px;">
    <thead>
      <tr class="text-nowrap">
        <th >#</th>
        <th>Student</th>
        <th class="table-secondary">Payable (&#8358;)</th>
        <th>Paid (&#8358;)</th>
        <th class="table-primary">Balance (&#8358;)</th>
        {{-- <th></th> --}}
        
      </tr>
    </thead>
    <tbody>
      @php
          $total_payable = 0;
          $total_paid = 0;
          $total_balance = 0;
      @endphp

      @foreach ($students as $key => $student )
     
      @php
          @$invoice = App\Models\Invoice::select('id','amount','pre_balance','discount')->where('student_id',$student->id)->where('session_id',$school->session_id)->where('term',$school->term)->first();
          $slip = App\Models\PaymentSlip::select('payable','paid','additional')->where('invoice_id',@$invoice->id)->first();
          $additionals = 0;
          if($slip)
          {
            $rows = explode(',', $slip->additional); 
            foreach ($rows as $row) {
              $fee_amount = App\Models\FeeStructure::where('id',$row)->first()->amount;
              $additionals+=$fee_amount;
            }
          }

          $mandatory_sum = App\Models\FeeStructure::where('priority', 'm')
                            ->where('term', $school->term)
                            ->where('school_id', $school->id)
                            ->where('class_id', $student->class_id)
                            ->where('student_type', @$invoice->student_type)->sum('amount'); 
        
          $paid = App\Models\PaymentRecord::select('paid_amount')->where('student_id',$student->id)->where('invoice_id',@$invoice->id)->sum('paid_amount');
          $payable = @$slip->payable-@$invoice->discount+@$invoice->pre_balance;
        @endphp

    @if(@$slip)
      <tr class="table-success">
        <th scope="row">{{ $key+1 }}</th>
        <td>{{ $student->first_name.' '.$student->middle_name.' '.$student->last_name}}</td>
        <td class="table-secondary">{{ number_format($payable,0) }}</td>
        <td>{{ number_format($paid,0) }}</td>
        <td class="table-primary">{{ number_format($payable-$paid,0) }}</td>
        {{-- <td></td> --}}
      </tr>
      @php
          $total_payable+= $payable;
          $total_paid+= $paid;
      @endphp
      @else
      <tr class="table-danger">
        <th scope="row">{{ $key+1 }}</th>
        <td>{{ $student->first_name.' '.$student->middle_name.' '.$student->last_name}}</td>
        <td class="table-danger text-center" colspan="3">Payment Slip Not Generated</td>
        {{-- <td></td>
        <td class="table-primary"></td> --}}
      </tr>
      @endif
      @endforeach
      <tr class="table-warning">
        <td></td>
        <td></td>
        <td class="text-center">Payable <br /><strong>&#8358;{{ number_format($total_payable,0) }}</strong></td>
        <td class="text-center">Paid <br /><strong>&#8358;{{ number_format($total_paid,0) }}</strong></td>
        <td class="text-center">Balance <br /><strong>&#8358;{{ number_format($total_payable-$total_paid,0) }}</strong></td>
      </tr>
    </tbody>
  </table>
</div>
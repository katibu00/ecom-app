<div class="table-responsive text-nowrap">
    <table class="table table-hover table-bordered table-sm" style="font-size: 12px;">
      <thead>
        <tr class="text-nowrap">
          <th >#</th>
          <th>Class</th>
          <th class="text-center">Revenue (This Term)</th>
        </tr>
      </thead>
      <tbody>
        @php
          $total = 0;
        @endphp
       @foreach ($classes as $key => $class)
           @php
               $revenue = App\Models\PaymentRecord::select('amount')->where('class_id',$class->id)
               ->where('session_id',$school->session_id)
               ->where('term',$school->term)
               ->sum('amount');
               $total += $revenue;
           @endphp
          <tr>
            <td>{{ $key+1}}</td>
            <td>{{ $class->name }}</td>
            <td>&#8358;{{ number_format($revenue,0) }}</td>
          </tr>
          @endforeach
          <tr>
            <td></td>
            <td>Total Revenue This Term</td>
            <td>&#8358;{{ number_format($total,2) }}</td>
          </tr>
      </tbody>
    </table>
  </div>
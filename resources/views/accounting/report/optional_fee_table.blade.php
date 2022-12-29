<div class="table-responsive text-nowrap">
    <table class="table table-hover table-bordered table-sm" style="font-size: 12px;">
      <thead>
        <tr class="text-nowrap">
          <th >#</th>
          <th>Class</th>
          <th>Fee/Student</th>
          <th class="text-center">Paying</th>
          <th class="text-center">Total (&#8358;)</th>
        </tr>
      </thead>
      <tbody>
       @php
             $sub_total = 0;
       @endphp
       @foreach ($classes as $key => $class)
       @php
            $students = App\Models\User::where('class_id',$class->id)->where('status',1)->count();
            $optional = App\Models\FeeStructure::where('school_id', auth()->user()->school_id)
                ->where('class_id', $class->id)
                ->where('fee_category_id', @$report)->first();
            $paying = App\Models\PaymentSlip::where('class_id',$class->id)->where('additional','like','%'.@$optional->id.'%')->count();
            $total = @$optional->amount*$paying;
            $sub_total+=$total;
        @endphp
       <tr>
            <td>{{ $key+1}}</td>
            <td>{{ $class->name .' ('.$students.' Students)' }}</td>
            <td class="text-center">{{ @$optional->amount }}</td>
            <td class="text-center">{{ $paying != 0? number_format($paying,0) : '' }}</td>
            <td class="text-center">{{ $total != 0? number_format($total,0) : '' }}</td>
      </tr>
       @endforeach
       <tr>
        <td  class="table-success" colspan="4"></td>
        <td class="table-success text-center"><strong>{{ $sub_total != 0? number_format($sub_total,0) : '' }}</strong></td>
      </tr>
      </tbody>
    </table>
  </div>
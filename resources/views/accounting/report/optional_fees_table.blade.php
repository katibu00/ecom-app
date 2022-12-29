<div class="table-responsive text-nowrap">
    <table class="table table-hover table-bordered table-sm" style="font-size: 12px;">
      <thead>
        <tr class="text-nowrap">
          <th >#</th>
          <th>Class</th>
          <th>Fee Name</th>
          <th class="text-center">Amount</th>
          <th class="text-center">Paying</th>
          <th class="text-center">Total (&#8358;)</th>
        </tr>
      </thead>
      <tbody>
       
       @foreach ($classes as $key => $class)
            @php
                $optionals = App\Models\FeeStructure::with('fee_category')
                ->whereHas('fee_category', function ($query) {
                    $query->where('priority','!=', 'm');
                })
                ->where('school_id', auth()->user()->school_id)
                ->where('class_id', $class->id)
                ->where('student_type', 'r')->get();
              
                $students = App\Models\User::where('class_id',$class->id)->where('status',1)->count();
                $sub_total = 0;
            @endphp

            @foreach ($optionals as $key2 => $optional)
            @php
                $paying = App\Models\PaymentSlip::where('class_id',$class->id)->where('additional','like','%'.$optional->id.'%')->count();
            @endphp
          <tr>
            @if($loop->first)
            <td>{{ $key+1}}</td>
            <td>{{ $class->name .' ('.$students.' Students)' }}</td>
            @else
            <td></td>
            <td></td>
            @endif
            <td>{{ $optional->fee_category->name }}</td>
            <td class="text-center">{{ number_format($optional->amount,0) }}</td>
            <td class="text-center">{{ $paying != 0? $paying:'' }}</td>
            @php
                $total = $optional->amount*$paying;
                $sub_total+=$total;
            @endphp
            <td class="text-center">{{ $total != 0? number_format($total,0) : '' }}</td>
          </tr> 
         
          @endforeach
          <tr>
            <td colspan="5"></td>
            <td class="text-center"><strong>{{ $sub_total != 0? number_format($sub_total,0) : '' }}</strong></td>
          </tr>
       @endforeach
      </tbody>
    </table>
  </div>
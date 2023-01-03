<div class="table-responsive text-nowrap">
    <table class="table table-hover">    <thead>
        <tr>
            <th>S/N</th>
            <th>Date</th>
            <th>Invoice #</th>
            <th>Student</th>
            <th>Amount Paid</th>
            <th>Method </th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
       
        @foreach ($payments as $key => $value)
        <tr>
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{{ $value->created_at->diffForHumans() }}</td>
            <td>#{{ $value->invoice->number }}</td>
            <td>{{ $value->student->first_name.' '.$value->student->middle_name.' '.$value->student->last_name }}</td>
            <td class="text-center">{{ number_format($value->paid_amount,0) }}</td>
            <td class="text-center">{{ ucfirst($value->method) }}</td>
            <td>{{ $value->description }}</td>
          
            <td>
                <a href="{{ route("admin.generate.receipt", $value->id)}}" class="btn btn-success" target="__blank"><i class="ti ti-printer me-2"></i></a>
            </td>
        </tr>
        @endforeach
      
    </tbody>
</table>
</div>

<div class="d-flex justify-content-center d-none" id="loading_div">
    <div class="spinner-border" style="margin: 80px; height: 40px; width: 40px;" role="status"><span class="sr-only">Loading...</span></div>
 </div>
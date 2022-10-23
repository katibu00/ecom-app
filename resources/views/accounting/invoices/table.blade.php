<table class="table card-table display mb-4 dataTablesCard " id="example4">
    <thead>
        <tr>
            <th>
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="checkAll">
                <label class="form-check-label" for="checkAll">
                </label>
                </div>
            </th>
            <th>ID Invoice</th>
            <th>Date</th>
            <th>Recipient</th>
            <th>Amount</th>
            <th>Discount</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        @foreach ($invoices as $key => $invoice)
        <tr>
            <td>
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                <label class="form-check-label" for="flexCheckDefault2">
                </label>
                </div>
            </td>
            <td><span class="text-black font-w500">#{{ $invoice->number }}</span></td>
            <td><span class="text-black text-nowrap">{{ $invoice->created_at->diffForHumans() }}</span></td>
            <td>
                <div class="d-flex align-items-center">
                    <img @if($invoice->student->image == 'default.png') src="/uploads/default.png" @else src="/uploads/default.png" @endif alt="" class="rounded me-3" width="50">
                    <div>
                        <h6 class="fs-16 text-black font-w600 mb-0 text-nowrap">{{ $invoice->student->first_name.' '.$invoice->student->middle_name.' '.$invoice->student->last_name }}</h6>
                        <span class="fs-12">{{ $invoice->class->name }} - @if($invoice->student_type == 'r') Regular @elseif($invoice->student_type == 't') Transfer @elseif($invoice->student_type == 's') Scholarship @endif</span>
                    </div>
                </div>
            </td>
            <td><span class="text-black">&#8358;{{ number_format($invoice->amount,0) }}</span></td>
        
            <td>&#8358;{{ number_format($invoice->discount,0) }}</td>
            <td>
                <div class="dropdown">
                    <a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                        <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
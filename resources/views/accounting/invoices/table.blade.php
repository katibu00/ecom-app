<div class="table-responsive text-nowrap mb-3">
    <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th>Recipient</th>
                <th>Amount</th>
                <th>Balance Brough Forward</th>
                <th>Discount</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

            @forelse ($invoices as $key => $invoice)
                <tr>
                    <td><span class="text-black font-w500">#{{ $invoice->number }}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img @if ($invoice->student->image == 'default.png') src="/uploads/default.png" @else src="/uploads/default.png" @endif
                                alt="" class="rounded me-3" width="50">
                            <div>
                                <h6 class="fs-16 text-black font-w600 mb-0 text-nowrap">
                                    {{ $invoice->student->first_name . ' ' . $invoice->student->middle_name . ' ' . $invoice->student->last_name }}
                                </h6>
                                <span class="fs-12">{{ $invoice->class->name }} -
                                    @if ($invoice->student_type == 'r')
                                        Regular
                                    @elseif($invoice->student_type == 't')
                                        Transfer
                                    @elseif($invoice->student_type == 's')
                                        Scholarship
                                    @else
                                    @php
                                        $type_name = App\Models\StudentType::select('name')->where('id',$invoice->student_type)->first()->name;
                                    @endphp
                                    {{ $type_name }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </td>
                    <td><span class="text-black">&#8358;{{ number_format($invoice->amount, 0) }}</span></td>

                    <td class="text-center">&#8358;{{ number_format($invoice->pre_balance, 0) }}</td>
                    <td class="text-center">&#8358;{{ number_format($invoice->discount, 0) }}</td>
                    <td><span class="text-black text-nowrap">{{ $invoice->created_at->diffForHumans() }}</span></td>
                    <td>
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z"
                                        stroke="#575757" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path
                                        d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z"
                                        stroke="#575757" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path
                                        d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z"
                                        stroke="#575757" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item editItem" data-id="{{ $invoice->id }}" data-student_type="{{ $invoice->student_type }}" data-pre_balance="{{ $invoice->pre_balance }}" data-discount="{{ $invoice->discount }}" data-name=" {{ $invoice->student->first_name . ' ' . $invoice->student->middle_name . ' ' . $invoice->student->last_name }}" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#">SMS Parent</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="7">  <div class="alert alert-warning" role="alert">No Invoices have been generated - Click on the plus icon above to start.</div></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $invoices->links() }}

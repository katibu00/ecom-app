<div class="table-responsive text-nowrap mb-3">
<table class="table invoices_table">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Student Name</th>
            <th>Class</th>
            <th>Invoice Amount</th>
            <th>Optional Fees</th>
            <th>Total Paid</th>
            <th>Progress</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $key => $invoice)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $invoice->student->first_name.' '.$invoice->student->middle_name.' '.$invoice->student->last_name }}</td>
            <td>{{ $invoice->class->name }}</td>
            <td>&#8358;{{ number_format($invoice->amount, 0) }}</td>
            <td>
                @if (optional($invoice->paymentSlip)->additional)
                    @php
                        $optionalFees = explode(',', $invoice->paymentSlip->additional);
                        $optionalFeesNames = [];
                        
                        foreach ($optionalFees as $feeId) {
                            $feeCategory = App\Models\FeeStructure::where('id', $feeId)->first(); 
                            if ($feeCategory) {
                                $optionalFeesNames[] = $feeCategory->fee_category->name;
                            }
                        }
                        
                    @endphp
                {!! implode('<br>', $optionalFeesNames) !!}
                @else
                    <span class="badge bg-danger">No Payment Slip</span>
                @endif
            </td>
            <td>&#8358;{{ number_format(optional($invoice->paymentSlip)->paid ?? 0, 2) }}</td>
            <td>
                @if ($invoice->paymentSlip)
                    @php
                        $progress = ($invoice->paymentSlip->paid / $invoice->amount) * 100;
                    @endphp
                    {{ number_format(round($progress, 0), ) }}%
                @else
                    0%
                @endif
            </td>
            <td>
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        {{-- <a class="dropdown-item remind_parent" href="javascript:void(0);">
                            <i class="ti ti-bell me-1"></i> Remind Parent
                        </a> --}}
                        {{-- <a class="dropdown-item send_home" href="javascript:void(0);">
                            <i class="ti ti-home me-1"></i> Send Home
                        </a> --}}
                        <a class="dropdown-item payment_details" href="javascript:void(0);" data-student_id="{{ $invoice->student->id }}" data-invoice_id="{{ $invoice->id }}" data-student_name="{{ @$invoice->student->first_name . ' ' . @$invoice->student->middle_name . ' ' . @$invoice->student->last_name }}" data-bs-toggle="modal" data-bs-target="#paymentHistoryModal">
                            <i class="ti ti-wallet me-1"></i> Payment History
                        </a>
                        
                        <a class="dropdown-item invoice_details" href="#" data-student_id="{{ $invoice->student->id }}" data-student_name="{{ @$invoice->student->first_name . ' ' . @$invoice->student->middle_name . ' ' . @$invoice->student->last_name }}" data-invoice_id="{{ $invoice->id }}">
                            <i class="ti ti-file-text me-1"></i> Invoice Details
                        </a>
                                              
                    </div>
                </div>
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>
</div>

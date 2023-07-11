<div class="table-responsive text-nowrap mb-3">
    <table class="table invoices_table">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>Invoice Type</th>
                <th>Parent Linked</th>
                <th>Amount</th>
                <th>Previous</th>
                <th>Discount</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoices as $key => $invoice)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $invoice->student->first_name . ' ' . $invoice->student->middle_name . ' ' . $invoice->student->last_name }}
                    </td>
                    <td>{{ $invoice->class->name }}</td>
                    <td>
                        @if ($invoice->student_type == 'r')
                            Regular
                        @elseif($invoice->student_type == 't')
                            Transfer
                        @elseif($invoice->student_type == 's')
                            Scholarship
                        @else
                            @php
                                $type_name = App\Models\StudentType::select('name')
                                    ->where('id', $invoice->student_type)
                                    ->first()->name;
                            @endphp
                            {{ $type_name }}
                        @endif
                    </td>
                    <td>
                        @if ($invoice->student->parent_id !== null)
                            <span class="badge bg-success">Linked</span>
                        @else
                            <span class="badge bg-danger">Not Linked</span>
                        @endif
                    </td>
                    <td>&#8358;{{ number_format($invoice->amount, 0) }}</td>
                    <td>&#8358;{{ number_format($invoice->pre_balance, 0) }}</td>
                    <td>&#8358;{{ number_format($invoice->discount, 0) }}</td>
                    <td>&#8358;{{ number_format($invoice->amount + $invoice->pre_balance - $invoice->discount, 0) }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="actionsDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionsDropdown">
                                {{-- <li><a class="dropdown-item" href="#">View</a></li> --}}
                                <li><a class="dropdown-item editItem" data-id="{{ $invoice->id }}" data-student_type="{{ $invoice->student_type }}" data-pre_balance="{{ $invoice->pre_balance }}" data-discount="{{ $invoice->discount }}" data-name=" {{ $invoice->student->first_name . ' ' . $invoice->student->middle_name . ' ' . $invoice->student->last_name }}" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a><li>
                                {{-- <li><a class="dropdown-item" href="#">Delete</a></li> --}}
                            </ul>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">
                        <div class="alert alert-danger" role="alert">No Invoices have been generated - Click on the
                            plus icon above to start.</div>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>

</div>
{{-- {{ $invoices->links() }} --}}

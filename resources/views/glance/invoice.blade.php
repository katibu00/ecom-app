@extends('layouts.app')
@section('PageTitle', 'Invoices')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row mb-5">
        <div class="col-md">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="m-0">{{ $name->name }} Invoices</h5>
                </div>
                <div class="card-body">
                    @if (count($invoices) > 0)
                        <div class="table-responsive text-nowrap">
                            <table class="table mb-2 table-sm">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Student</th>
                                        <th>Invoice</th>
                                        <th>Student Type</th>
                                        <th>Amount</th>
                                        <th>Pre-Balance</th>
                                        <th>Discount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $key => $invoice)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ @$invoice->student->first_name.' '. @$invoice->student->middle_name.' '. @$invoice->student->last_name }}</td>
                                            <td>{{ $invoice->number }}</td>
                                            <td>
                                                @if ($invoice->student_type == 'r')
                                                    Regular
                                                @elseif ($invoice->student_type == 't')
                                                    Transfer
                                                @else
                                                    {{ $invoice->studentType->name ?? 'N/A' }}
                                                @endif
                                            </td>
                                            <td>{{ '₦' . number_format($invoice->amount, 2, ',', '.') }}</td>
                                            <td>{{ $invoice->pre_balance ? '₦' . number_format($invoice->pre_balance, 2, ',', '.') : 'N/A' }}</td>
                                            <td>{{ $invoice->discount ? '₦' . number_format($invoice->discount, 2, ',', '.') : 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">No invoices for the selected class.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

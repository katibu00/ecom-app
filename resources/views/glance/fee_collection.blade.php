@extends('layouts.app')
@section('PageTitle', 'Fee Collection')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-5">
        <div class="col-md">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="m-0">{{ @$name->name }} Fee Collection</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table mb-2 table-sm">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Total Due</th>
                                    <th>Total Payment Made</th>
                                    <th>Previous Balance</th>
                                    <th>Status</th>
                                    <th>Payment Records</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                <tr>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                    <td>{{ number_format($student->totalDue, 2) }}</td>
                                    <td>{{ number_format($student->totalPaymentMade, 2) }}</td>
                                    <td>{{ number_format($student->previousBalance, 2) }}</td>
                                    <td>{{ $student->status }}</td>
                                    <td>
                                        @foreach ($student->paymentRecords as $record)
                                            <div>
                                                Paid: {{ number_format($record->paid_amount, 2) }} |
                                                Method: {{ $record->method }}<br>
                                                Description: {{ $record->description ?? 'N/A' }}
                                            </div><br>
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if (count($students) === 0)
                    <div class="alert alert-info" role="alert">
                        No fee collection data available for the selected class.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('PageTitle', 'Fee Schedule')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row mb-5">
        <div class="col-md">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="m-0">{{ $name->name }} Fee Schedule</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table mb-2 table-sm">
                            <thead>
                                <tr>
                                    <th>Student Type</th>
                                    <th>Term</th>
                                    <th>Fee Category</th>
                                    <th>Amount</th>
                                    <th>Priority</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totals = [];
                                    $currentStudentType = null;
                                    $currentTerm = null;
                                @endphp

                                @foreach ($fixed_fee_structures as $fee)
                                    @php
                                        $studentTypeTermKey = $fee->student_type . '_' . $fee->term;
                                        if (!isset($totals[$studentTypeTermKey])) {
                                            $totals[$studentTypeTermKey] = 0;
                                        }
                                        $totals[$studentTypeTermKey] += $fee->amount;
                                    @endphp

                                    @if ($currentStudentType !== $fee->student_type || $currentTerm !== $fee->term)
                                        @if ($currentStudentType !== null)
                                            <tr>
                                                <td colspan="3"></td>
                                                <td><strong>Total</strong></td>
                                                <td>{{ '₦' . number_format($totals[$currentStudentType . '_' . $currentTerm], 2, ',', '.') }}</td>
                                            </tr>
                                        @endif
                                        @php
                                            $currentStudentType = $fee->student_type;
                                            $currentTerm = $fee->term;
                                        @endphp
                                    @endif

                                    <tr>
                                        <td>{{ $fee->student_type == 'r' ? 'Regular' : ($fee->student_type == 't' ? 'Transfer' : $fee->student_type) }}</td>
                                        <td>{{ $fee->term }}</td>
                                        <td>{{ @$fee->fee_category->name }}</td>
                                        <td>{{ '₦' . number_format($fee->amount, 2, ',', '.') }}</td>
                                        <td>
                                            @switch($fee->priority)
                                                @case('m')
                                                    Mandatory
                                                    @break
                                                @case('o')
                                                    Optional
                                                    @break
                                                @case('r')
                                                    Recommended
                                                    @break
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach

                                @if ($currentStudentType !== null)
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><strong>Total</strong></td>
                                        <td>{{ '₦' . number_format($totals[$currentStudentType . '_' . $currentTerm], 2, ',', '.') }}</td>
                                    </tr>
                                @endif

                                @foreach ($studentTypes as $studentType)
                                    @foreach ($studentType->feeStructure as $fee)
                                        @php
                                            $studentTypeTermKey = $studentType->id . '_' . $fee->term;
                                            if (!isset($totals[$studentTypeTermKey])) {
                                                $totals[$studentTypeTermKey] = 0;
                                            }
                                            $totals[$studentTypeTermKey] += $fee->amount;
                                        @endphp

                                        @if ($currentStudentType !== $studentType->id || $currentTerm !== $fee->term)
                                            @if ($currentStudentType !== null)
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td><strong>Total</strong></td>
                                                    <td>{{ '₦' . number_format($totals[$currentStudentType . '_' . $currentTerm], 2, ',', '.') }}</td>
                                                </tr>
                                            @endif
                                            @php
                                                $currentStudentType = $studentType->id;
                                                $currentTerm = $fee->term;
                                            @endphp
                                        @endif

                                        <tr>
                                            <td>{{ $studentType->name }}</td>
                                            <td>{{ $fee->term }}</td>
                                            <td>{{ @$fee->fee_category->name }}</td>
                                            <td>{{ '₦' . number_format($fee->amount, 2, ',', '.') }}</td>
                                            <td>
                                                @switch($fee->priority)
                                                    @case('m')
                                                        Mandatory
                                                        @break
                                                    @case('o')
                                                        Optional
                                                        @break
                                                    @case('r')
                                                        Recommended
                                                        @break
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach

                                @if ($currentStudentType !== null)
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><strong>Total</strong></td>
                                        <td>{{ '₦' . number_format($totals[$currentStudentType . '_' . $currentTerm], 2, ',', '.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

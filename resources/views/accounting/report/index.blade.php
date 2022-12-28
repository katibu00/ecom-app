@extends('layouts.app')
@section('PageTitle', 'Financial Activities Report')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">

            <!-- Select Election -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex4 align-items-center he4ader-elements">
                            <form action="{{ route('billing.report.generate') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <label for="">Report Type</label>
                                        <select class="form-select form-select-sm mb-2" name="report">
                                            <option value=""></option>
                                            <option value="fee_collection"
                                                {{ @$report == 'fee_collection' ? 'selected' : '' }}>Fee Collection</option>
                                            <option value="summary" {{ @$report == 'summary' ? 'selected' : '' }}>Summary
                                                Report</option>
                                            <option value="detailed" {{ @$report == 'detailed' ? 'selected' : '' }}>Detailed
                                                Report</option>
                                            <option value="expenses" {{ @$report == 'expenses' ? 'selected' : '' }}>Expenses
                                            </option>
                                            <option value="payments" {{ @$report == 'payments' ? 'selected' : '' }}>Recent Fee
                                                Payments</option>
                                            <option value="accounts" {{ @$report == 'accounts' ? 'selected' : '' }}>Banks
                                                Accounts</option>
                                            @foreach ($fee_cats as $fee)
                                                <option value="{{ $fee->id }}">{{ $fee->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('report')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-2" id="class">
                                        <label for="">Class</label>
                                        <select class="form-select form-select-sm mb-2" name="class">
                                            <option value=""></option>
                                            <option value="all" {{ @$class == 'all' ? 'selected' : '' }}>All</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ @$selected_class == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('class')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-2" id="">
                                        <label for="">Time</label>
                                        <select class="form-select form-select-sm mb-2" name="time">
                                            <option value=""></option>
                                            <option value="term" {{ @$time == 'term' ? 'selected' : '' }}>This Term
                                            </option>
                                            <option value="session" {{ @$time == 'session' ? 'selected' : '' }}>This Session
                                            </option>
                                        </select>
                                        @error('time')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mt-md-3">
                                        <button type="submit" class="btn btn-sm btn-primary">Fetch Record</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if (@$report_type == 'fee_collection')
                <div class="col-lg-12 col-12 mb-4">
                    <div class="card">
                        <h5 class="card-header">Fee Collection</h5>
                        <div class="card-body">
                            @include('accounting.report.fee_collection_table')
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection

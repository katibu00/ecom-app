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
                                    <select class="form-select form-select-sm mb-2" name="report" id="report">
                                        <option value=""></option>
                                        <option value="fee_collection_sum"
                                            {{ @$report == 'fee_collection_sum' ? 'selected' : '' }}>Fee Collection
                                            (Summary)</option>
                                        <option value="fee_collection"
                                            {{ @$report == 'fee_collection' ? 'selected' : '' }}>Fee Collection
                                            (Detailed)</option>
                                        <option value="optional_fees"
                                            {{ @$report == 'optional_fees' ? 'selected' : '' }}>Optional Fees Payment
                                        </option>

                                        <option value="outstanding" {{ @$report == 'outstanding' ? 'selected' : '' }}>Oustanding
                                            Fees Report</option>
                                        <option value="revenue" {{ @$report == 'revenue' ? 'selected' : '' }}>Revenue
                                            Report</option>
                                        <option value="expenses" {{ @$report == 'expenses' ? 'selected' : '' }}>Expenses
                                            Report</option>
                                        <option value="summary" {{ @$report == 'summary' ? 'selected' : '' }}>Fee
                                            Category-Wise Report</option>
                                        <option value="summary" {{ @$report == 'summary' ? 'selected' : '' }}>Payment
                                            Mode-Wise Report</option>
                                        <option value="summary" {{ @$report == 'summary' ? 'selected' : '' }}>Fee
                                            Discount Report</option>
                                        <option value="summary" {{ @$report == 'summary' ? 'selected' : '' }}>Account Receivables</option>
                                        <option value="summary" {{ @$report == 'summary' ? 'selected' : '' }}>Student's Payment History</option>

                                    </select>
                                    @error('report')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-2" id="class_div">
                                    <label for="">Class</label>
                                    <select class="form-select form-select-sm mb-2" name="class">
                                        <option value=""></option>
                                        <option value="all" {{ @$selected_class == 'all' ? 'selected' : '' }}>All
                                        </option>
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
                                {{-- <div class="col-md-3 mb-2" id="">
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
                                    </div> --}}

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
                    <h5 class="card-header">Fee Collection (Detailed) Report</h5>
                    <div class="card-body">
                        @include('accounting.report.fee_collection_table')
                    </div>
                </div>
            </div>
        @endif
        @if (@$report_type == 'fee_collection_sum')
            <div class="col-lg-12 col-12 mb-4">
                <div class="card">
                    <h5 class="card-header">Fee Collection (Summary) Report</h5>
                    <div class="card-body">
                        @include('accounting.report.fee_collection_sum')
                    </div>
                </div>
            </div>
        @endif
        @if (@$report_type == 'optional_fees')
            <div class="col-lg-12 col-12 mb-4">
                <div class="card">
                    <h5 class="card-header">Optional Fees Payment Report</h5>
                    <div class="card-body">
                        @include('accounting.report.optional_fees_table')
                    </div>
                </div>
            </div>
        @endif
        @if (@$report_type == 'one_optional')
            <div class="col-lg-12 col-12 mb-4">
                <div class="card">
                    <h5 class="card-header">Optional Fee Report</h5>
                    <div class="card-body">
                        @include('accounting.report.optional_fee_table')
                    </div>
                </div>
            </div>
        @endif
        
        @if (@$report_type == 'outstanding')
            <div class="col-lg-12 col-12 mb-4">
                <div class="card">
                    <h5 class="card-header">Outstanding Fee Report</h5>
                    <div class="card-body">
                        @include('accounting.report.outstanding_fee_table')
                    </div>
                </div>
            </div>
        @endif

        @if (@$report_type == 'revenue')
            <div class="col-lg-12 col-12 mb-4">
                <div class="card">
                    <h5 class="card-header">Revenue Collected Report</h5>
                    <div class="card-body">
                        @include('accounting.report.revenue_table')
                    </div>
                </div>
            </div>
        @endif
        @if (@$report_type == 'expenses')
            <div class="col-lg-12 col-12 mb-4">
                <div class="card">
                    <h5 class="card-header">Expenses Report</h5>
                    <div class="card-body">
                        @include('accounting.report.expenses_table')
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(function() {
        $(document).on('change', '#report', function() {
            var report = $('#report').val();
            if (report == 'optional_fees' || report == 'revenue') {
                $('#class_div').addClass("d-none");
            } else {
                $('#class_div').removeClass("d-none");
            }
        });
    });
</script>
@if (@$report == 'optional_fees' || @$report == 'revenue')
<script type="text/javascript">
    $('#class_div').addClass("d-none");
</script>
@endif
@endsection

@extends('layouts.app')
@section('PageTitle', 'Fee Collection')
@section('css')
    <link href="/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
@endsection
@section('content')

<div class="content-body">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 order-lg-2 mb-4 d-none" id="sidebar">
                            
                                <div class="rounded text-white bg-warning text-black mb-2">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between"><h5 class="mb-0 text-muted text-warning fs-14">Transaction Summary</h5></li>
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Invoice Amount :</span><strong id="total_invoice"></strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Total Amount Payable :</span><strong class="payable"></strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Discount :</span><strong class="discount"></strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">UNPAID BALANCE :</span><strong class="balance"></strong></li>
                                    </ul>
                                </div>

                               
                            <div class="input-group">
                                <button type="button" class="btn btn-info btn-block mb-2" data-bs-toggle="modal" data-bs-target=".add_record_modal"><i class="fa fa-plus me-2"></i>Add payment</button>
                            </div>
                            @include('accounting.fee_collection.add_payment_modal')
                               
                            </div>
                            <div class="col-lg-8 order-lg-1">
                                <form id="payment_form">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="class_id" class="form-label">Class</label>
                                            <select class="default-select form-control wide mb-3" id="class_id">
                                                <option value="">--select Class --</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invoice_id"  class="form-label">Invoice</label>
                                            <select id="invoice_id" class="form-control wide mb-3">
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="hidden_payable"/>
                                    <input type="hidden" id="hidden_balance"/>
                                    <input type="hidden" id="hidden_discount"/>
                                    <div class="d-none" id="bottom_bar">
                                        <hr class="mb-4">

                                        <div id="mandatory_fees">
                                        
                                        </div>
                                    </div>
                                    <div class="d-none" id="btn_div">
                                        <hr class="mb-4">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit" id="initialize_btn">Initialize Payment</button>
                                    </div>
                                </form>

                                <div class="d-none" id="table_div">
                                    <hr class="mb-4">
                                    <h5>Recent Payments</h5>

                                    @include('accounting.fee_collection.recent_payment_table')
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    @include('accounting.fee_collection.scripts')
    <script src="/js/sweetalert.min.js"></script>
  
    <script src="/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
    {!! Toastr::message() !!}
@endsection

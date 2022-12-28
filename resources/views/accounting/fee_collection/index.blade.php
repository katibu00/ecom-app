@extends('layouts.app')
@section('PageTitle', 'Fee Collection')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Fee Collection</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 order-lg-2 mb-4 d-none" id="sidebar">
                            
                                <div class="rounded text-white bg-warning text-black mb-2">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between"><h5 class="mb-0 text-white fs-14">Transaction Summary</h5></li>
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Invoice Amount :</span><strong id="total_invoice"></strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Balance Brought Forward :</span><strong id="bbf"></strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Amount Payable (This Invoice) :</span><strong class="payable"></strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Discount :</span><strong class="discount"></strong></li>
                                        <li class="list-group-item d-flex justify-content-between d-none" id="discounted_amount_li"><span class="mb-0">Total Amount Payable:</span><strong class="discounted_amount"></strong></li>
                                        <li class="list-group-item d-flex justify-content-between d-none" id="total_paid_li"><span class="mb-0">Total Amount Paid :</span><strong class="total_paid"></strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">UNPAID BALANCE :</span><strong class="balance"></strong></li>
                                    </ul>
                                </div>

                               
                            <div class="d-none" id="add_record_div">
                                <button type="button" class="btn btn-info btn-block mb-2" data-bs-toggle="modal" data-bs-target=".add_record_modal"><i class="fa fa-plus me-2"></i>Add payment</button>
                            </div>
                            @include('accounting.fee_collection.add_payment_modal')
                               
                            </div>
                            <div class="col-lg-8 order-lg-1">
                                <form id="payment_form">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label for="class_id" class="form-label">Class</label>
                                            <select class="default-select form-control wide mb-3" id="class_id">
                                                <option value="">--select Class --</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="invoice_id"  class="form-label">Invoice</label>
                                            <select id="invoice_id" class="form-control wide mb-3">
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="hidden_payable"/>
                                    <input type="hidden" id="hidden_balance"/>
                                    <input type="hidden" id="hidden_modal_balance"/>
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
                                    <h5>Payments (This Invoice)</h5>
                                    <div class="table-responsive">
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
@endsection

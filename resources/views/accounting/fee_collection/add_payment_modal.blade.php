<div class="modal fade add_record_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Loading...</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form id="add_payment_form">
                <div class="modal-body">
                    <div class="basic-form">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Payment Amount</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="add_payment_amount" placeholder="Payment Amount">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" placeholder="Payment Description">
                            </div>
                        </div>
                        <fieldset class="mb-3">
                            <div class="row">
                                <label class="col-form-label col-sm-3 pt-0">Payment Method</label>
                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input class="form-check-input method" type="radio" name="account" value="cash">
                                        <label class="form-check-label">
                                            Cash Transaction
                                        </label>
                                    </div>
                                   @foreach ($accounts as $account)
                                    <div class="form-check">
                                        <input class="form-check-input method" type="radio" name="account" value="{{ $account->bank }}">
                                        <label class="form-check-label">
                                            {{ $account->bank }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </fieldset>
                        {{-- <div class="mb-3 row">
                            <div class="col-sm-3">Total Amount Payable</div>
                            <div class="col-sm-9">
                                <h5 class="payable"></h5>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-3">Discount Allowed</div>
                            <div class="col-sm-9">
                                <h5 class="discount"></h5>
                            </div>
                        </div> --}}
                        <div class="mb-3 row">
                            <div class="col-sm-3">Remaining Balance</div>
                            <div class="col-sm-9">
                                <h5 class="modal_balance"></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="add_record_btn">Add Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
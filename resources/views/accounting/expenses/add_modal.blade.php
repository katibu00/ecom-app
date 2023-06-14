<div class="modal fade bd-example-modal-lg" id="addModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Record new Expenditure(s)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form id="create_data_form">
                <div class="modal-body">
    
                        <ul id="error_list"></ul>
                        <div class="add_item">
                            <div class="row">
                                <div class="col-xl-12">

                                    <div class="mb-2 row">
                                        <div class="col-lg-2">
                                            <input type="date" class="form-control mb-2" name="date[]" >                                    
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control mb-2" name="description[]" placeholder="Description" >                                    
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-select mb-2" name="expense_category_id[]" required>
                                                <option value="">--Category--</option>
                                                @foreach ($expense_cats as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>                                      
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-select mb-2" name="payee_id[]" required>
                                                <option value="">-- Recipient --</option>
                                                @foreach ($staffs as $staff)
                                                    <option value="{{ $staff->id }}">{{ @$staff->title }} {{ $staff->first_name }} {{ $staff->last_name }}</option>
                                                @endforeach
                                            </select>                                      
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="number" class="form-control mb-2" name="amount[]" placeholder="Amount" >                                    
                                        </div>
                                       
                                        <div class="col-lg-2">
                                            <span class="btn btn-success btn-sm addeventmore "><i class="ti ti-plus me-1"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
                </div>
        </form>
        </div>
    </div>
</div>

<div style="visibility: hidden;">
    <div class="whole_extra_item_add" id="whole_extra_item_add">
        <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">

            <div class="row">
                <div class="col-xl-12">
                    <div class="mb-2 row">
                        <div class="col-lg-2">
                            <input type="date" class="form-control mb-2" name="date[]" >                                    
                        </div>
                        <div class="col-lg-2">
                            <input type="text" class="form-control mb-2" name="description[]" placeholder="Description" >                                    
                        </div>
                        <div class="col-lg-2">
                            <select class="default-select form-control wide mb-2" name="fee_category_id[]" required>
                                <option value="">--Category--</option>
                                @foreach ($expense_cats as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>                                      
                        </div>
                        <div class="col-lg-2">
                            <select class="default-select form-control wide mb-2" name="payee_id[]" required>
                                <option value="">-- Recipient --</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ @$staff->title }} {{ $staff->first_name }} {{ $staff->last_name }}</option>
                                @endforeach
                            </select>                                      
                        </div>
                        <div class="col-lg-2">
                            <input type="number" class="form-control mb-2" name="amount[]" placeholder="Amount" >                                    
                        </div>
                        <div class="col-lg-2 d-f4lex">
                            <span class="btn btn-success btn-sm addeventmore"><i class="ti ti-plus me-1"></i></span>
                            <span class="btn btn-danger btn-sm removeeventmore"><i class="ti ti-minus me-1"></i></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
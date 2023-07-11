<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title editTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form>
                <div class="modal-body">

                    <ul id="error_list"></ul>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="mb-3 row">
                                <label class="col-lg-4 col-form-label" for="name">Student Type
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-8">
                                    <select class="form-select form-select-sm mb-2" id="student_type" required>
                                        <option value=""></option>
                                        <option value="r">Regular</option>
                                        <option value="t">Transfer</option>
                                        @foreach ($studentTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option> 
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="update_id">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="mb-2 row">
                                <label class="col-lg-4 col-form-label" for="name">Previous Balance
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-8">
                                    <input type="number" class="form-control form-control-sm" id="pre_balance"
                                        placeholder="Balance Brought Forward" />
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="mb-2 row">
                                <label class="col-lg-4 col-form-label" for="name">Discount
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-8">
                                    <input type="number" class="form-control form-control-sm" id="discount"
                                        placeholder="Discount" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="update_btn">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

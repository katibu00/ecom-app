<div class="modal fade" id="addNewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-3">
                    <h3 class="mb-2">Add New Fee Category</h3>
                </div>
                <form id="addNewForm" class="row g-3">
                    <ul id="error_list"></ul>
                    <div class="add_item">
                        <div class="row  mb-2">
                            <div class="col-lg-9">
                                <input type="text" class="form-control mb-2" name="name[]"
                                    placeholder="Fee Category Name" required>
                            </div>
                            <div class="col-md-2">
                                <span class="btn btn-success btn-sm  addeventmore"><i
                                        class="ti ti-plus me-1"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1" id="submit_btn">Submit</button>
                        <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal"
                            aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div style="visibility: hidden;">
    <div class="whole_extra_item_add" id="whole_extra_item_add">
        <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
            <div class="row mb-2">
                <div class="col-lg-9">
                    <input type="text" class="form-control mb-2" name="name[]" placeholder="Fee Category Name"
                        required>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="d-flex">
                        <span class="btn btn-success  addeventmore me-2"><i class="ti ti-plus me-1"></i></span>
                        <span class="btn btn-danger  removeeventmore"><i class="ti ti-minus me-1"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Credit Card Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-3">
                    <h3 class="mb-2">Edit Session</h3>
                </div>

                <form id="addNewForm" class="row g-3">


                    <ul id="update_error_list"></ul>
                    <input type="hidden" id="update_id">

                    <div class="add_item">
                        <div class="form-group  mb-2">
                            <div class="col-md-12">
                                <input type="text" id="edit_name" class="form-control" placeholder="Enter Session Name" />
                            </div>
                        </div>
                    </div>



                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 mb-1 me-1" id="update_btn">Update</button>
                        <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal"
                            aria-label="Close">
                            Dismiss
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add New Credit Card Modal -->

<!-- Add New Credit Card Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-3">
                    <h3 class="mb-2">Edit Class</h3>
                </div>

                <form id="addNewForm" class="row g-3">


                    <ul id="update_error_list"></ul>
                    <input type="hidden" id="update_id">

                    <div class="add_item">
                        <div class="form-group  mb-3">
                            <div class="col-md-12 mb-3">
                                <input type="text" id="edit_name" class="form-control" placeholder="Edit Class Name" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <select class="form-select mb-3" id="edit_form_master_id" name="edit_form_master_id" required>
                                    <option value="">-- Select Form Master --</option>
                                    @foreach ($staffs as $staff)
                                        <option value="{{ $staff->id }}">{{ $staff->first_name.' '.$staff->last_name }}</option>
                                    @endforeach
                                </select>                           
                             </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="status">
                                <label class="form-check-label">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>



                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1" id="update_btn">Update</button>
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
<!--/ Add New Credit Card Modal -->

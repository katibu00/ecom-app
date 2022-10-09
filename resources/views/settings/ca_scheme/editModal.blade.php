<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form>
                <div class="modal-body">
                
                        <ul id="error_list"></ul>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="mb-3 row">
                                   <div class="col-lg-4">
                                        <input type="text" class="form-control m-2" id="code"  placeholder="CA Code" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control m-2" id="desc"  placeholder="CA Description" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="number" class="form-control m-2" id="marks"  placeholder=" marks percentage" required>
                                    </div>
                                      <input type="hidden" id="update_id">
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-sm-4">Active Status</div>
                                    <div class="col-sm-8">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="status">
                                            <label class="form-check-label">
                                               Active
                                            </label>
                                        </div>
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
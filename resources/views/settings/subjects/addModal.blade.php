<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a New Class(s)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form id="create_class_form">
                <div class="modal-body">
                
                        <ul id="error_list"></ul>
                        <div class="add_item">
                            <div class="row">
                                <div class="col-xl-12">

                                    <div class="mb-2 row">
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control m-2" name="name[]"  placeholder="Enter Subject name" required>
                                        </div>
                                        <div class="col-lg-4">
                                            <span class="btn btn-success btn-sm addeventmore m-2"><i class="fa fa-plus-circle"></i></span>
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
                        <div class="col-lg-8">
                            <input type="text" class="form-control m-2" name="name[]"  placeholder="Enter Subject name" required>
                        </div>
                        <div class="col-lg-4 d-flex">
                            <span class="btn btn-success btn-sm addeventmore m-2"><i class="fa fa-plus-circle"></i></span>
                            <span class="btn btn-danger btn-sm removeeventmore m-2"><i class="fa fa-minus-circle"></i></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
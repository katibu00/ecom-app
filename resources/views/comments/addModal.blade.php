<div class="modal fade bd-example-modal-lg" id="addModal">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enter Comments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form id="create_data_form">
                <div class="modal-body" style="min-height: 80vh">
                
                        <ul id="error_list"></ul>
                      
                        <div class="row">
                            <div class="col-xl-12">

                                <div class="mb-2 row">
                                    <div class="col-lg-3">
                                        <select class="default-select form-control wide mb-3" name="class_id" required>
                                            <option value="">--Select Class--</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select class="default-select form-control wide mb-3" name="class_id" required>
                                            <option value="">--Select Type--</option>
                                            <option value="form">Form Master</option>
                                            <option value="prin">Principal/Director</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="submit" class="btn btn-primary mb-2">Search Records</button>
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

<div class="modal fade bd-example-modal-lg" id="addModal">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Comments Entery</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
           
                <div class="modal-body" style="min-height: 80vh">
                    
                    <form id="search_form">
                        <div class="row">
                            <div class="col-xl-12">

                                <div class="mb-2 row">
                                    <div class="col-lg-3">
                                        <select class="form-select form-select-sm mb-3" id="class_id">
                                            <option value="">--Select Class--</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select class="form-select form-select-sm mb-3" id="officer">
                                            <option value="">--Select Officer--</option>
                                            <option value="fm">Form Master</option>
                                            <option value="p">Principal/Director</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="submit" class="btn btn-secondary mb-2" id="search_btn">Search Records</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                    <form id="comments_form">
                    <div class="row d-none" id="marks-generate">
                        <div class="table-responsive">
                            <input type="hidden" id="send_class_id" name="class_id" />
                            <input type="hidden" id="send_officer" name="officer" />

                            <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>Roll Number</th>
                                        <th>Student Name</th>
                                        <th style="width: 5%">Position</th>
                                        <th style="width: 5%">Total Marks</th>
                                        <th style="width: 20%">Comment</th>
                                        <th style="width: 20%">Additional Comment</th>
                                    </tr>
                                </thead>
                                <tbody id="marks-generate-tr">

                                </tbody>
                            </table>

                        </div>
                    </div>
                       
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary d-none" id="submit_btn">Submit</button>
                </div>
            </form>
       
        </div>
    </div>
</div>

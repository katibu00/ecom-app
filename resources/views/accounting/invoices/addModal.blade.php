<div class="modal fade bd-example-modal-lg" id="addModal">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Generate Invoices</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body" style="min-height: 80vh">

                <form id="search_form">
                    <div class="row">
                        <div class="col-xl-12">

                            <div class="mb-2 row">
                                <div class="col-lg-3">
                                    <select class="default-select form-control wide mb-3" id="class_id">
                                        <option value="">--Select Class--</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-secondary mb-2" id="search_btn">Fetch
                                        Students</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>

                <form id="invoices_form">
                    <div class="row d-none" id="marks-generate">
                        <div class="table-responsive">
                            <input type="hidden" id="send_class_id" name="class_id" />

                            <div class="table-responsive text-nowrap">
                                <table class="table table-responsive-sm table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Registration Number</th>
                                            <th>Full Name</th>
                                            <th>Student Type</th>
                                            <th>Balance Carried Foward</th>
                                            <th>Discount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="marks-generate-tr">

                                    </tbody>
                                </table>
                            </div>

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

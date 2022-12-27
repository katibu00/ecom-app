<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a New CA Scheme</h5>
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
                                             <label class="form-label" for="class_ids">Code</label>
                                            <input type="text" class="form-control m-2" name="code"  placeholder="Code" required>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label" for="class_ids">Description</label>
                                            <input type="text" class="form-control m-2" name="desc"  placeholder="Description" required>
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label" for="class_ids">Marks</label>
                                            <input type="number" class="form-control m-2" name="marks"  placeholder="Marks %" required>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label" for="class_ids">Classes</label>
                                            <select
                                            id="class_ids"
                                            name="class_ids[]"
                                            class="select2 form-select"
                                            multiple
                                            required
                                          >
                                            <option value=""></option>
                                            @foreach ($classes as $class)
                                              <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                          </select>
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

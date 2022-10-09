<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">

                <div id="content_div">

                    <div class="mb-3 row">
                        <div class="col-6">
                            <div class="profile-img-edit">
                                <img class="profile-pic" width="150" height="150" src="/uploads/no-image.jpg" alt="school logo">
                            </div>
                            <div class="input-group">
                                <div class="form-file">
                                    <input class="form-file-input" type="file" accept="image/*" name="logo">
                                </div>
                            </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">School Name</label>
                            <input type="text" class="form-control" id="edit_name" placeholder="School Name">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Username</label>
                            <input type="email" class="form-control" id="edit_username" placeholder="Username">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Service Fee/Head/Term</label>
                            <input type="number" class="form-control" id="edit_service" placeholder="Service Fee/Head/Term">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Heading</label>
                            <select class="default-select form-control wide mb-3" name="edit_heading">
                                <option></option>
                                <option value="h1">H1</option>
                                <option value="h2">H2</option>
                                <option value="h3">H3</option>
                                <option value="h4">H4</option>
                                <option value="h5">H5</option>
                                <option value="h6">H6</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_staff_modal_title">Loading . . .</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form id="edit_staff_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="" id="edit_loading_div">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="spinner-border" style="height: 40px; width: 40px; margin: 0 auto;" role="status"></div>
                        </div>
                    </div>
                    <input type="hidden" id="edit_staff_id" name="edit_staff_id" />
                
                    <div class="profile-personal-info d-none" id="edit_content_div">
        

                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <div class="profile-img-edit">
                                    <img class="profile-pic" id="edit_staff_picture" width="150" height="150" src="/uploads/default.png" alt="staff picture">
                                    <div class="p-image">
                                    <i class="fa fa-pencil  upload-button"></i>
                                    <input class="file-upload" type="file" accept="image/*" name="image" />
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_first_name">First Name</label>
                                <input type="text" class="form-control" id="edit_first_name" value="" name="first_name" placeholder="First Name">
                            </div>
                            <div class="col-md-6 mt-2 mt-sm-0">
                                <label for="edit_last_name">Other Names</label>
                                <input type="text" class="form-control" id="edit_last_name" name="last_name" placeholder="Other Names">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_email">Email</label>
                                <input type="text" class="form-control" id="edit_email" name="email" placeholder="Email">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_roll_number">Phone Number</label>
                                <input type="text" class="form-control" id="edit_phone_number" name="phone" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 mt-2 mt-sm-0">
                                <label for="edit_usertype">Role</label>
                                <select class="form-select" name="usertype" id="edit_usertype" required>
                                    <option value=""></option>
                                    <option value="teacher">Teacher</option>
                                    <option value="admin">Administrator</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="proprietor">Proprietor</option>
                                    <option value="director">Director</option>
                                    <option value="staff">Non-teaching Staff</option>
                                </select>  
                            </div>
                            {{-- <div class="col-md-6 mt-2 mt-sm-0">
                                <label for="edit_dob">Managed Class (Form Master)</label>
                                <select class="form-select" name="class_id" required>
                                    <option value=""></option>
                                    
                                </select>  
                            </div> --}}
                        </div>
                        
                    
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Dismiss</button>
                    <button type="submit" id="edit_staff_btn" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
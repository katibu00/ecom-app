<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
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
                                    <label class="col-lg-4 col-form-label" for="name">Teacher
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <select class="default-select form-control wide mb-3" id="update_teacher_id" required>
                                            <option value="">--Select Teacher--</option>
                                            @foreach ($staffs as $staff)
                                                <option value="{{ $staff->id }}">{{ $staff->title }} {{ $staff->first_name }} {{ $staff->last_name }}</option>
                                            @endforeach
                                        </select> 
                                        <input type="hidden" id="update_id">
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
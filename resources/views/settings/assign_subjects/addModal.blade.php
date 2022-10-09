<div class="modal fade bd-example-modal-lg" id="addModal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Subject(s)</h5>
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
                                        <div class="col-lg-4">
                                            <select class="default-select form-control wide mb-3" name="class_id" required>
                                                <option value="">--Select Class--</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-2 row">
                                        <div class="col-lg-4">
                                            <select class="default-select form-control wide mb-3" name="subject_id[]" required>
                                                <option value="">--Select Subject--</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                            </select>                                      
                                          </div>
                                        <div class="col-lg-4">
                                            <select class="default-select form-control wide mb-3" name="teacher_id[]" required>
                                                <option value="">--Select Teacher--</option>
                                                @foreach ($staffs as $staff)
                                                    <option value="{{ $staff->id }}">{{ $staff->title }} {{ $staff->first_name }} {{ $staff->last_name }}</option>
                                                @endforeach
                                            </select>                                      
                                          </div>
                                        <div class="col-lg-4">
                                            <span class="btn btn-success btn-sm addeventmore "><i class="fa fa-plus-circle"></i></span>
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
                        <div class="col-lg-4">
                            <select class="default-select form-control wide mb-3" name="subject_id[]" required>
                                <option value="">--Select Subject--</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>                                      
                          </div>
                        <div class="col-lg-4">
                            <select class="default-select form-control wide mb-3" name="teacher_id[]" required>
                                <option value="">--Select Teacher--</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->title }} {{ $staff->first_name }} {{ $staff->last_name }}</option>
                                @endforeach
                            </select>                                      
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
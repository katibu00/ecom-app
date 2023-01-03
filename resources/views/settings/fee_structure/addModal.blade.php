<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a New Fee Structure</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form id="create_data_form1" action="{{ route('settings.fee_structure.index')}}" method="post">
                <div class="modal-body">
                @csrf
                    <div class="add_item">
                        <div class="row">
                            <div class="col-xl-12">
                    
                                <div class="mb-2 row">
                                    <div class="col-lg-4">
                                        <select class="form-select form-select-sm mb-2" name="class_id" required>
                                            <option value=""></option>
                                            @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-5">
                                        <select class="form-select form-select-sm mb-2" name="student_type" required>
                                            <option value=""></option>
                                            <option value="r">Rugular</option>
                                            <option value="t">Transfer</option>
                                            @foreach ($student_types as $student_type)
                                            <option value="{{ $student_type->id }}">{{ $student_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <div class="col-lg-4">
                                        <select class="form-select form-select-sm mb-2" name="fee_id[]" required>
                                            <option value=""></option>
                                            @foreach ($fees as $fee)
                                            <option value="{{ $fee->id }}">{{ $fee->name }} (@if(@$fee->priority == 'o') Optional @elseif(@$fee->priority == 'r') Recommended @elseif(@$fee->priority == 'm') Mandatory @endif)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control form-control-sm mb-2" name="amount[]"  placeholder="Amount" required>
                                    </div>
                                    <div class="col-lg-3">
                                        <span class="btn btn-success btn-sm addeventmore"><i class="ti ti-plus me-2"></i></span>
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
                            <select class="form-select form-select-sm mb-2" name="fee_id[]" required>
                                <option></option>
                                @foreach ($fees as $fee)
                                <option value="{{ $fee->id }}">{{ $fee->name }} (@if(@$fee->priority == 'o') Optional @elseif(@$fee->priority == 'r') Recommended @elseif(@$fee->priority == 'm') Mandatory @endif)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-5">
                            <input type="text" class="form-control form-control-sm mb-2" name="amount[]"  placeholder="Amount" required>
                        </div>
                        <div class="col-lg-3">
                            <span class="btn btn-success btn-sm addeventmore me-1"><i class="ti ti-plus"></i></span>
                            <span class="btn btn-danger btn-sm removeeventmore me-1"><i class="ti ti-minus"></i></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
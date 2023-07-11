<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a New Fee Structure</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="create_data_form1" action="{{ route('settings.fee_structure.index')}}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="classSelect" class="form-label">Class:</label>
                            <select class="form-select form-select-sm" id="classSelect" name="class_id" required>
                                <option value=""></option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="studentTypeSelect" class="form-label">Student Type:</label>
                            <select class="form-select form-select-sm" id="studentTypeSelect" name="student_type" required>
                                <option value=""></option>
                                <option value="r">Regular</option>
                                <option value="t">Transfer</option>
                                @foreach ($student_types as $student_type)
                                    <option value="{{ $student_type->id }}">{{ $student_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="termSelect" class="form-label">Term:</label>
                            <select class="form-select form-select-sm" id="termSelect" name="term" required>
                                <option value=""></option>
                                <option value="1">First Term</option>
                                <option value="2">Second Term</option>
                                <option value="3">Third Term</option>
                            </select>
                        </div>
                    </div>
                    <div class="whole_extra_item_add">
                        <div class="delete_whole_extra_item_add">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <select class="form-select form-select-sm" name="fee_category_id[]" required>
                                        <option value=""></option>
                                        @foreach ($fees as $fee)
                                            <option value="{{ $fee->id }}">{{ $fee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <input type="number" class="form-control form-control-sm" name="amount[]" placeholder="Amount" required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <select class="form-select form-select-sm" name="priority[]" required>
                                        <option value=""></option>
                                        <option value="m">Mandatory</option>
                                        <option value="r">Recommended</option>
                                        <option value="o">Optional</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <button type="button" class="btn btn-success btn-sm addeventmore"><i class="ti ti-plus"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm removeeventmore"><i class="ti ti-minus"></i></button>
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

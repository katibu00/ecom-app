<div class="modal fade" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="copyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="copyModalLabel">Copy Fee Structure for [Class Name]</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="copyForm">
                    <div class="form-group mb-2">
                        <label for="copyToClass">Copy to Class</label>
                        <select class="form-select" id="copyToClass" name="copy_to_class">
                            <option value=""></option>
                            @foreach ($feeStructure as $row)
                                <option value="{{ @$row['class']->id }}">{{ @$row['class']->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="copyStudentType">Student Type</label>
                        <select class="form-select" id="copyStudentType" name="copy_student_type">
                            <option value=""></option>
                            <option value="r">Regular</option>
                            <option value="t">Transfer</option>
                            @foreach ($student_types as $student_type)
                                <option value="{{ $student_type->id }}">{{ $student_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="copyTerm">Term</label>
                        <select class="form-select" id="copyTerm" name="copy_term">
                            <option value=""></option>
                            <option value="1">First Term</option>
                            <option value="2">Second Term</option>
                            <option value="3">Third Term</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmCopy">Copy</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Question Modal -->
<div class="modal modal-lg fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuestionModalLabel">Add New Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Question Form -->
                <form id="questionForm">
                    @csrf
                    <div class="mb-3">
                        <label for="questionContent" class="form-label">Question Content</label>
                        <textarea id="questionContent" name="questionContent" class="form-control"></textarea>
                    </div>
                    <input type="hidden" value="{{ $examId }}" name="examId">
                    <div id="optionsContainer">
                        <!-- Options will be added dynamically here -->
                        <div class="mb-3 option-row">
                            <label class="form-label">Option 1</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="option[]" required>
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="1" required>
                                    <label class="form-check-label ms-2">Correct</label>
                                </div>
                                <button type="button" class="btn btn-danger remove-option-btn">Remove</button>
                            </div>
                        </div>

                        <!-- Add more rows for additional options -->
                    </div>

                    <button type="button" class="btn btn-secondary mt-2" id="addOptionBtn">+ Add Option</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveQuestionBtn">Save Question</button>
            </div>
        </div>
    </div>
</div>

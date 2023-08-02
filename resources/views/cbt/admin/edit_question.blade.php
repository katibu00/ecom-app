@extends('layouts.app')
@section('PageTitle', 'Edit Question')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
           
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Question</div>

                    <div class="card-body">
                        <form id="editQuestionForm">
                            @csrf
                            <div class="mb-3">
                                <label for="questionContent" class="form-label">Question Content</label>
                                <textarea id="questionContent" name="questionContent" class="form-control">{{ $question->question }}</textarea>
                            </div>

                            <div id="optionsContainer">
                                @php
                                    $options = json_decode($question->options, true);
                                    $correctAnswer = $question->correct_answer;
                                @endphp

                                @foreach ($options as $index => $option)
                                    <div class="mb-3 option-row">
                                        <label class="form-label">Option {{ $index + 1 }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="option[]" required
                                                value="{{ $option }}">
                                            <div class="input-group-text">
                                                <input type="radio" name="correct_option" value="{{ $option }}"
                                                    {{ $option === $correctAnswer ? 'checked' : '' }} required>
                                                <label class="form-check-label ms-2">Correct</label>
                                            </div>
                                            <button type="button" class="btn btn-danger remove-option-btn">Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-secondary mt-2" id="addOptionBtn">+ Add Option</button>
                            <button type="button" class="btn btn-primary mt-2" id="saveQuestionBtn">Save Question</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')


    <script src="https://cdn.tiny.cloud/1/k9osr3m8tz88vazuys0nr7q1fytr8gnfem7ho34o6h90d62d/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: '200px',
            submit_unmodified: false,
            plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
                "See docs to implement AI Assistant"))
        });
    </script>

    <!-- Script for adding and removing options -->
    <script>
        $(document).ready(function() {
            // Function to add a new option input field
            var optionCount = 1;

            function addOptionInput() {
                if (optionCount <= 5) {
                    var optionsContainer = $('#optionsContainer');

                    var optionRow = $('<div class="mb-3 option-row"></div>');
                    var optionLabel = $('<label class="form-label">Option ' + optionCount + '</label>');
                    var inputGroup = $('<div class="input-group"></div>');
                    var optionInput = $('<input type="text" class="form-control" name="option[]" required>');
                    var inputGroupText = $('<div class="input-group-text"></div>');
                    var correctOptionRadio = $('<input type="radio" name="correct_option" value="' + optionInput
                        .val() + '" required>');
                    var correctOptionLabel = $('<label class="form-check-label ms-2">Correct</label>');
                    var removeOptionBtn = $(
                        '<button type="button" class="btn btn-danger remove-option-btn">Remove</button>');

                    inputGroupText.append(correctOptionRadio);
                    inputGroupText.append(correctOptionLabel);

                    inputGroup.append(optionInput);
                    inputGroup.append(inputGroupText);
                    inputGroup.append(removeOptionBtn);

                    optionRow.append(optionLabel);
                    optionRow.append(inputGroup);

                    optionsContainer.append(optionRow);

                    optionCount++;
                }
            }


            function removeOptionInput() {
                $(this).closest('.option-row').remove();
                optionCount--;
            }

            $('#addOptionBtn').on('click', addOptionInput);

            $(document).on('click', '.remove-option-btn', removeOptionInput);

            function saveEditedQuestion() {
                var questionContent = tinymce.get('questionContent').getContent();
                var formData = $('#editQuestionForm').serialize();

                formData += '&questionContent=' + encodeURIComponent(questionContent);

                $.ajax({
                    type: 'PUT',
                    url: '{{ route('cbt.questions.update', ['question' => $question->id]) }}',
                    data: formData,
                    success: function(response) {
                        console.log('Question updated successfully!');
                        toastr.success('Question updated successfully!');
                        window.location.href = '{{ route('cbt.questions.index',$question->exam_id) }}';
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            }

            $('#saveQuestionBtn').on('click', saveEditedQuestion);
        });
    </script>

@endsection

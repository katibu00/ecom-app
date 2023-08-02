@extends('layouts.app')
@section('PageTitle', 'Questions')

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Questions List</h5>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">Add
                            New Question</a>
                    </div>
                    <div class="card-body">
                        @if (count($questions) > 0)
                            @include('cbt.admin.questions_table')
                        @else
                            <p>No questions found.</p>
                        @endif
                    </div>
                </div>
                @include('cbt.admin.new_question_modal')
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


    <script>
        $(document).ready(function() {
            // Function to add a new option input field
            var optionCount = 2;

            function addOptionInput() {
                if (optionCount <= 5) {
                    var optionsContainer = $('#optionsContainer');

                    var optionRow = $('<div class="mb-3 option-row"></div>');
                    var optionLabel = $('<label class="form-label">Option ' + optionCount + '</label>');
                    var inputGroup = $('<div class="input-group"></div>');
                    var optionInput = $('<input type="text" class="form-control" name="option[]" required>');
                    var inputGroupText = $('<div class="input-group-text"></div>');
                    var correctOptionCheckbox = $('<input type="radio" name="correct_option" value="' +
                        optionCount + '" required>');
                    var correctOptionLabel = $('<label class="form-check-label ms-2">Correct</label>');
                    var removeOptionBtn = $(
                        '<button type="button" class="btn btn-danger remove-option-btn">Remove</button>');

                    inputGroupText.append(correctOptionCheckbox);
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

            // Function to handle renumbering of options
            function renumberOptions() {
                $('.option-row').each(function(index) {
                    $(this).find('.form-label').text('Option ' + (index + 1));
                });
            }

            // Function to handle removal of an option
            function removeOptionInput() {
                $(this).closest('.option-row').remove();
                optionCount--;
                renumberOptions();
            }

            // Event listener to add option on button click
            $('#addOptionBtn').on('click', addOptionInput);

            // Event listener to remove option on button click
            $(document).on('click', '.remove-option-btn', removeOptionInput);
        });
    </script>


    <script>
        $(document).ready(function() {
            function saveQuestion() {
                var questionContent = tinymce.get('questionContent').getContent();
                var formData = $('#questionForm').serialize();
                formData += '&questionContent=' + encodeURIComponent(questionContent);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('cbt.questions.store') }}',
                    data: formData,
                    success: function(response) {
                        $('#addQuestionModal').modal('hide');
                        $('#questionForm')[0].reset();
                        $('.table').load(location.href + ' .table');

                        tinymce.get('questionContent').setContent('');
                        toastr.success('Question saved successfully!');

                    },
                    error: function(error) {
                        console.error('Failed to save question:', error.responseJSON);
                        toastr.error(error.responseJSON.message);
                    }
                });
            }

            $('#saveQuestionBtn').on('click', saveQuestion);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function deleteQuestion(questionId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete this question!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('cbt.questions.destroy', ['question' => '__questionId__']) }}'
                            .replace('__questionId__', questionId),
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('.table').load(location.href + ' .table');
                            Swal.fire('Deleted!', 'The question has been deleted.', 'success');

                        },
                        error: function(error) {
                            Swal.fire('Error!', 'Failed to delete the question.', 'error');
                        }
                    });
                }
            });
        }
    </script>





@endsection

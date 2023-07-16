<script>
    $(document).ready(function() {

        //search records
        $(document).on('submit', '#search_form', function(e) {
            e.preventDefault();

            var class_id = $('#class_id').val();
            var officer = $('#officer').val();

            $('#send_class_id').val(class_id);
            $('#send_officer').val(officer);

            if (class_id == '' || officer == '') {
                Command: toastr["error"]("All fields are required")

                return;
            }

            spinner =
                '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div>&nbsp; Fetching data . . .'
            $('#search_btn').html(spinner);
            $('#search_btn').attr("disabled", true);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('comments.get') }}",
                data: {
                    'class_id': class_id
                },
                success: function(res) {

                    if (!$.trim(res)) {
                        Command: toastr["error"](
                            "Generate End of Term Report First for the Selected Class")

                        $('#marks-generate').addClass('d-none');
                        $('#marks-generate-tr').html('');
                        $('#search_btn').html("Search Records");
                        $('#search_btn').attr("disabled", false);
                        return;
                    }

                    $('#marks-generate').removeClass('d-none');

                    var html = '';
                    $.each(res, function(key, v) {

                        html +=
                            '<tr>' +
                            '<td>' + v.student.login +
                            '<input type="hidden" name="student_id[]" value="' + v
                            .student.id + '"></td>' +
                            '<td>' + v.student.first_name + ' ' + v.student
                            .middle_name + ' ' + v.student.last_name + '</td>' +
                            '<td>' + (key + 1) + '</td>' +
                            '<td>' + v.total + '</td>' +
                            '<td> <select name="comment[]" class="form-select" >' +
                            '<option value=""></option>' +
                            '<optgroup label="High Performers">' +
                            '<option value="Great work! Your outstanding performance shows your dedication and hard work.">Great work! Your outstanding performance shows your dedication and hard work.</option>' +
                            '<option value="Impressive! Your consistent top scores reflect your commitment to excellence.">Impressive! Your consistent top scores reflect your commitment to excellence.</option>' +
                            '<option value="Excellent! Your exceptional results highlight your passion for learning.">Excellent! Your exceptional results highlight your passion for learning.</option>' +
                            '<option value="Excellent performance! Keep up the great work!">Excellent performance! Keep up the great work!</option>' +
                            '<option value="Outstanding performance! Congratulations!">Outstanding performance! Congratulations!</option>' +
                            '<option value="Top-notch performance! Keep aiming high!">Top-notch performance! Keep aiming high!</option>' +
                            '</optgroup>' +
                            '<optgroup label="Medium Performers">' +
                            '<option value="Good effort! Keep up the progress!">Good effort! Keep up the progress!</option>' +
                            '<option value="Nice going! Your performance is improving.">Nice going! Your performance is improving.</option>' +
                            '<option value="You are on track! Keep working towards your goals.">You are on track! Keep working towards your goals.</option>' +
                            '<option value="Good effort! Keep striving for improvement.">Good effort! Keep striving for improvement.</option>' +
                            '<option value="Nice work! You\'re making progress.">Nice work! You\'re making progress.</option>' +
                            '<option value="Solid performance! Keep it up.">Solid performance! Keep it up.</option>' +
                            '<option value="Decent effort! Keep pushing yourself.">Decent effort! Keep pushing yourself.</option>' +
                            '</optgroup>' +
                            '<optgroup label="Low Performers">' +
                            '<option value="Room for improvement. Let\'s work together to enhance your results.">Room for improvement. Let\'s work together to enhance your results.</option>' +
                            '<option value="Keep trying! You can do better.">Keep trying! You can do better.</option>' +
                            '<option value="You have potential! Let\'s work on boosting your performance.">You have potential! Let\'s work on boosting your performance.</option>' +
                            '<option value="Keep persevering! We\'re here to support you.">Keep persevering! We\'re here to support you.</option>' +
                            '</optgroup>' +

                            '</select></td>' +
                            '<td><input type="text" class="form-control" name="additional[]" value=""></td>' +
                            '</tr>';
                    });
                    html = $('#marks-generate-tr').html(html);
                    $('#search_btn').html("Search Records");
                    $('#search_btn').attr("disabled", false);
                    $('#submit_btn').removeClass('d-none');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    if (xhr.status === 419) {
                        Command: toastr["error"](
                            "Session expired. please login again."
                        );


                        setTimeout(() => {
                            window.location.replace('{{ route('login') }}');
                        }, 2000);
                    }
                },
            });

        });

        //store comments
        $(document).on('submit', '#comments_form', function(e) {
            e.preventDefault();

            let formData = new FormData($('#comments_form')[0]);

            spinner =
                '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div>&nbsp; Submitting . . .'
            $('#submit_btn').html(spinner);
            $('#submit_btn').attr("disabled", true);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('comments.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.status == 200) {
                        $('.comments-table').load(location.href + ' .comments-table');
                        $('#addModal').modal('hide');
                        $('#comments_form')[0].reset();
                        Command: toastr["success"](response.message)


                        $('#submit_btn').text("Submit");
                        $('#submit_btn').attr("disabled", false);
                    }
                    if (response.status == 404) {
                        $('#comments_form')[0].reset();
                        Command: toastr["error"](response.message)

                        $('#submit_btn').text("Submit");
                        $('#submit_btn').attr("disabled", false);
                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    if (xhr.status === 419) {
                        Command: toastr["error"](
                            "Session expired. please login again."
                        );

                        setTimeout(() => {
                            window.location.replace('{{ route('login') }}');
                        }, 2000);
                    }
                },
            });

        });

        //view comments click modal
        $(document).on('click', '.viewDetails', function() {

            let class_id = $(this).data('class_id');
            let class_name = $(this).data('class_name');
            $('.viewTitle').html('Fetch Comments for Class ' + class_name);
            $('#view_class_id').val(class_id);
            $('#loading_div').addClass('d-none');
            $('#content_div').addClass('d-none');
            html = $('#comments-generate-tr').html(null);
            $('#view_officer').val('');

        });

        //on change officer fetch and display comments
        $(document).on('change', '#view_officer', function() {
            let class_id = $('#view_class_id').val();
            let officer = $('#view_officer').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('comments.view') }}",
                data: {
                    'class_id': class_id,
                    'officer': officer
                },
                beforeSend: function() {
                    $('#loading_div').removeClass('d-none');
                    $('#content_div').addClass('d-none');
                    html = $('#comments-generate-tr').html(null);
                },
                success: function(data) {
                    if (!$.trim(data)) {
                        Command: toastr["error"](
                            "No Comment has been Entered for the Selected Class/officer."
                        );

                        $('#loading_div').addClass('d-none');
                        $('#content_div').addClass('d-none');
                        html = $('#comments-generate-tr').html(null);
                        return;
                    }

                    var html = '';
                    $.each(data, function(key, v) {
                        var middle_name = '';
                        var additional = '';
                        if (v.student.middle_name !== null) {
                            middle_name = v.student.middle_name;
                        }
                        if (v.additional !== null) {
                            additional = v.additional;
                        }
                        html +=
                            '<tr>' +
                            '<td>' + (key + 1) + '</td>' +
                            '<td>' + v.student.login + '</td>' +
                            '<td>' + v.student.first_name + ' ' + middle_name +
                            ' ' + v.student.last_name + '</td>' +
                            '<td class="comment" data-comment-id="' + v.id + '">' +
                            v.comment + '</td>' +
                            '<td class="additional" data-comment-id="' + v.id +
                            '">' + additional + '</td>' +
                            '<td>' +
                            '<button class="btn btn-primary btn-sm edit-comment-btn" ' +
                            'data-comment-id="' + v.id + '" ' +
                            'data-student-name="' + v.student.first_name + '" ' +
                            'data-comment="' + v.comment + '" ' +
                            'data-additional="' + additional + '">Edit</button>' +
                            '</td>' +
                            '</tr>';
                    });
                    html = $('#comments-generate-tr').html(html);
                    $('#loading_div').addClass('d-none');
                    $('#content_div').removeClass('d-none');
                },

                error: function(xhr, ajaxOptions, thrownError) {
                    if (xhr.status === 419) {
                        Command: toastr["error"](
                            "Session expired. please login again."
                        );


                        setTimeout(() => {
                            window.location.replace('{{ route('login') }}');
                        }, 2000);
                    }
                },
            });

        });

        //on click edit comment btn
        $(document).on('click', '.edit-comment-btn', function() {
            var commentID = $(this).data('comment-id');
            var studentName = $(this).data('student-name');
            var comment = $(this).data('comment');
            var additional = $(this).data('additional');

            $('.edit-comment-title').html('Edit Comment for: ' + studentName);
            $('#editAdditionalComment').val(additional);
            $('#edit_comment_student_id').val(commentID);
            $('#editComment option').filter(function() {
                return $(this).val() === comment;
            }).prop('selected', true);

            $('#editCommentModal').modal('show');
        });




        $(document).on('click', '.delete-comments-p', function(e) {
            e.preventDefault();

            var classId = $(this).data('class-id');
            var className = $(this).data('class-name');

            swal({
                title: 'Are you sure?',
                text: 'You are about to delete the Director Comments for ' + className + '.',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route('comments.delete') }}',
                        method: 'POST',
                        data: {
                            class_id: classId,
                            officer: 'p',
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                swal({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    $('.comments-table').load(location
                                        .href + ' .comments-table');
                                });
                            } else if (response.status === 'error') {
                                swal({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                        },


                        error: function(xhr, status, error) {
                            // Handle the error response
                        }
                    });
                }
            });
        });

        $(document).on('click', '.delete-comments-fm', function(e) {
            e.preventDefault();

            var classId = $(this).data('class-id');
            var className = $(this).data('class-name');

            swal({
                title: 'Are you sure?',
                text: 'You are about to delete the Form Master Comments for ' + className + '.',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route('comments.delete') }}',
                        method: 'POST',
                        data: {
                            class_id: classId,
                            officer: 'fm',
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                swal({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    $('.comments-table').load(location
                                        .href + ' .comments-table');
                                });
                            } else if (response.status === 'error') {
                                swal({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                        },


                        error: function(xhr, status, error) {
                            // Handle the error response
                        }
                    });
                }
            });
        });




    });
</script>


<script>
    function saveChanges() {
        var commentID = $('#edit_comment_student_id').val();
        var comment = $('#editComment').val();
        var additional = $('#editAdditionalComment').val();

        var saveButton = $('#saveChangesButton');
        saveButton.prop('disabled', true);
        saveButton.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

        $.ajax({
            url: "{{ route('comments.edit') }}",
            method: 'POST',
            data: {
                commentID: commentID,
                comment: comment,
                additional: additional
            },
            success: function(response) {
                if (response.status == 200) {
                    Command: toastr["success"](response.message);
                    var commentID = $('#edit_comment_student_id').val();
                    var viewModal = $('#viewCommentsModal');
                    var commentElement = viewModal.find('.comment[data-comment-id="' + commentID + '"]');
                    var additionalElement = viewModal.find('.additional[data-comment-id="' + commentID +
                        '"]');

                    var comment = $('#editComment option:selected').text();
                    var additional = $('#editAdditionalComment').val();

                    commentElement.text(comment);
                    additionalElement.text(additional);

                    saveButton.prop('disabled', false);
                    saveButton.html('Save Changes');
                    $('#editCommentModal').modal('hide');
                }
                if (response.status == 404) {
                    Command: toastr["error"](response.message);

                    saveButton.prop('disabled', false);
                    saveButton.html('Save Changes');
                    $('#editCommentModal').modal('hide');
                }
            },


            error: function(xhr, status, error) {
                // Handle the error response here
                console.error('Form submission failed');
                // Optionally, you can display an error message or perform any error handling
            },

        });
    }
</script>

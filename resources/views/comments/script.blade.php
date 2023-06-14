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
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
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
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
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
                        toastr.options = {
                            closeButton: false,
                            debug: false,
                            newestOnTop: false,
                            progressBar: false,
                            positionClass: "toast-top-right",
                            preventDuplicates: false,
                            onclick: null,
                            showDuration: "300",
                            hideDuration: "1000",
                            timeOut: "5000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                        };

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
                        $('.table').load(location.href + ' .table');
                        $('#addModal').modal('hide');
                        $('#comments_form')[0].reset();
                        Command: toastr["success"](response.message)
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }

                        $('#submit_btn').text("Submit");
                        $('#submit_btn').attr("disabled", false);
                    }
                    if (response.status == 404) {
                        $('#comments_form')[0].reset();
                        Command: toastr["error"](response.message)
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        $('#submit_btn').text("Submit");
                        $('#submit_btn').attr("disabled", false);
                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    if (xhr.status === 419) {
                        Command: toastr["error"](
                            "Session expired. please login again."
                        );
                        toastr.options = {
                            closeButton: false,
                            debug: false,
                            newestOnTop: false,
                            progressBar: false,
                            positionClass: "toast-top-right",
                            preventDuplicates: false,
                            onclick: null,
                            showDuration: "300",
                            hideDuration: "1000",
                            timeOut: "5000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                        };

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
                        toastr.options = {
                            closeButton: false,
                            debug: false,
                            newestOnTop: false,
                            progressBar: false,
                            positionClass: "toast-top-right",
                            preventDuplicates: false,
                            onclick: null,
                            showDuration: "300",
                            hideDuration: "1000",
                            timeOut: "5000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                        };
                        $('#loading_div').addClass('d-none');
                        $('#content_div').addClass('d-none');
                        html = $('#comments-generate-tr').html(null);
                        return;
                    }

                    var html = '';
                    $.each(data, function(key, v) {
                        var middle_name = '';
                        if (v.student.middle_name !== null) {
                            middle_name = v.student.middle_name;
                        }
                        html +=
                            '<tr>' +
                            '<td>' + (key + 1) + '</td>' +
                            '<td>' + v.student.login + '</td>' +
                            '<td>' + v.student.first_name + ' ' + middle_name +
                            ' ' + v.student.last_name + '</td>' +
                            '<td>' + v.comment + ' ' + v.additional + '</td>' +
                            '<td>' +
                            '<button class="btn btn-primary btn-sm edit-comment-btn" ' +
                            'data-comment-id="' + v.id + '" ' +
                            'data-student-name="' + v.student.first_name + '" ' +
                            'data-comment="' + v.comment + '" ' +
                            'data-additional="' + v.additional + '">Edit</button>' +
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
                        toastr.options = {
                            closeButton: false,
                            debug: false,
                            newestOnTop: false,
                            progressBar: false,
                            positionClass: "toast-top-right",
                            preventDuplicates: false,
                            onclick: null,
                            showDuration: "300",
                            hideDuration: "1000",
                            timeOut: "5000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                        };

                        setTimeout(() => {
                            window.location.replace('{{ route('login') }}');
                        }, 2000);
                    }
                },
            });

        });


        $(document).on('click', '.edit-comment-btn', function() {
            var studentID = $(this).data('student-id');
            var studentName = $(this).data('student-name');
            var comment = $(this).data('comment');
            var additional = $(this).data('additional');

            $('.edit-comment-title').html('Edit Comment for: ' + studentName);
            $('#editAdditionalComment').val(additional);
            $('#edit_comment_student_id').val(studentID);

            // Select the matching comment option in the edit modal
            $('#editComment option').filter(function() {
                return $(this).val() === comment;
            }).prop('selected', true);

            // Show the edit comment modal
            $('#editCommentModal').modal('show');
        });



        $(document).on('click', '.edit-comment-btn', function() {
            var commmentID = $(this).data('comment-id');
            var studentName = $(this).data('student-name');
            var comment = $(this).data('comment');
            var additional = $(this).data('additional');

            $('.edit-comment-title').html('Edit Comment for: ' + studentName);
            $('#editAdditionalComment').val(additional);
            $('#edit_comment_student_id').val(commmentID);

            // Select the matching comment option in the edit modal
            $('#editComment option').filter(function() {
                return $(this).val() === comment;
            }).prop('selected', true);

            // Show the edit comment modal
            $('#editCommentModal').modal('show');
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

                    Command: toastr["success"](response.message)
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }

                    saveButton.prop('disabled', false);
                    saveButton.html('Save Changes');
                    $('#editCommentModal').modal('hide');
                }
                if (response.status == 404) {

                    Command: toastr["error"](response.message)
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
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

<script>
    $(document).ready(function() {

        //create
        $(document).on('submit', '#create_data_form', function(e) {
            e.preventDefault();

            let formData = new FormData($('#create_data_form')[0]);

            spinner =
                '<div class="spinner-border" style="height: 20px; width: 20px;" role="status"></div> Submitting . . .'
            $('#submit_btn').html(spinner);
            $('#submit_btn').attr("disabled", true);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('users.students.store') }}",
                data: formData,
                contentType: false,
                processData: false,
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

                        window.location.replace('{{ route('users.students.index') }}');
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

        ///student details
        $(document).on('click', '.student_details', function() {

            $('#details_content_div').addClass('d-none');
            $('#details_loading_div').removeClass('d-none');

            let student_name = $(this).data('student_name');
            let student_id = $(this).data('student_id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "POST",
                url: "{{ route('users.students.details') }}",
                data: {
                    'student_id': student_id
                },
                dataType: "json",
                success: function(res) {

                    if (res.status == 200) {

                        if (res.student.image != 'default.png') {
                            $("#picture").attr("src", "/uploads/" + res.school_name + '/' +
                                res.student.image);
                        }

                        $('#first_name').html(res.student.first_name);
                        $('#middle_name').html(res.student.middle_name);
                        $('#last_name').html(res.student.last_name);
                        $('#roll_number').html(res.student.login);
                        $('#class').html(res.student.class.name);

                        $('#registered').html(res.registered);
                        if(res.student.parent)
                        {
                            $('#parent_name').html(res.student.parent.title + ' ' + res.student.parent.first_name + ' ' + res.student.parent.last_name);
                            $('#parent_email').html(res.student.parent.email);
                            $('#parent_phone').html(res.student.parent.phone);
                            $('#parent_address').html(res.student.parent.name);
                        }

                        $('.modal-title').html('Details for ' + student_name);
                        $('#details_content_div').removeClass('d-none');
                        $('#details_loading_div').addClass('d-none');

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

        //sort by class
        $(document).on('change', '#select_class', function() {

            var class_id = $('#select_class').val();
            $('nav').html('');

            $('#content_div').addClass('d-none');
            $('#loading_div').removeClass('d-none');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'GET',
                url: `{{ route('users.students.sort') }}` + '?class_id=' + class_id,

                success: function(res) {

                    $('#content_div').removeClass('d-none');
                    $('#loading_div').addClass('d-none');
                    $('.table').html(res);

                    if (res.status == 404) {
                        Command: toastr["warning"](
                            "No Students Found in the selected class."
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
                        $('.table').html("No Students Found in the selected class.");
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

        //search
        $(document).on('keyup', function(e) {
            e.preventDefault();

            let query = $('#search').val();
            $('#nav_links').addClass('d-none');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('users.students.search') }}",
                method: 'POST',
                data: {
                    query: query
                },

                success: function(res) {
                    $('.table').html(res);
                    if (res.status == 404) {
                        $('.table-data').html(
                            '<p class="text-danger text-center">No Record Matched</p>'
                        );
                    }
                }
            });

        });

        //dynanic row
        $(document).ready(function() {
            var counter = 0;
            $(document).on("click", ".addeventmore", function() {
                var whole_extra_item_add = $("#whole_extra_item_add").html();
                $(this).closest(".add_item").append(whole_extra_item_add);
                counter++
            });
            $(document).on("click", ".removeeventmore", function(event) {
                $(this).closest(".delete_whole_extra_item_add").remove();
                counter -= 1;
            });
        });


        //on click edit students
        $(document).on('click', '.edit_student', function(e) {
            e.preventDefault();

            let student_id = $(this).data('student_id');
            let student_name = $(this).data('student_name');
            $('#edit_student_id').val(student_id);

            $('#edit_loading_div').removeClass('d-none');
            $('#edit_content_div').addClass('d-none');
            $('#edit_student_form')[0].reset();
            $('#edit_parent option:selected').removeAttr('selected');
            $('#edit_gender option:selected').removeAttr('selected');
            $("#edit_student_picture").attr("src", "/uploads/default.png");
            $('#edit_student_modal_title').html('Edit ' + student_name + 's Profile');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('get-student_details') }}',
                data: {
                    'student_id': student_id,
                },
                success: function(res) {

                    if (res.student.image != 'default.png') {
                        $("#edit_student_picture").attr("src", "/uploads/" + res
                            .school_username.username + '/' + res.student.image);
                    }

                    $('#edit_loading_div').addClass('d-none');
                    $('#edit_content_div').removeClass('d-none');
                    $('#edit_first_name').val(res.student.first_name);
                    $('#edit_middle_name').val(res.student.middle_name);
                    $('#edit_last_name').val(res.student.last_name);
                    $('#edit_dob').val(res.student.dob);
                    $('#edit_roll_number').val(res.student.login);
                    $(`#edit_parent option[value="${res.student.parent_id}"]`).attr(
                        "selected", "selected");
                    $(`#edit_gender option[value="${res.student.gender}"]`).attr("selected",
                        "selected");



                }
            });


        });

        //edit students form
        $(document).on('submit', '#edit_student_form', function(e) {
            e.preventDefault();

            let formData = new FormData($('#edit_student_form')[0]);

            spinner =
                '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div>&nbsp; Saving . . .'
            $('#edit_student_btn').html(spinner);
            $('#edit_student_btn').attr("disabled", true);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('users.students.edit') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.status == 400) {
                        $('#error_list').html("");
                        $('#error_list').addClass('alert alert-danger');
                        $.each(response.errors, function(key, err) {
                            $('#error_list').append('<li>' + err + '</li>');
                        });
                        $('#edit_student_btn').text("Save Changes");
                        $('#edit_student_btn').attr("disabled", false);
                        Command: toastr["error"](
                            "Some Fields are required. Please check your input and try again."
                            )

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
                    }

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

                        $('#edit_student_btn').text("Save Changes");
                        $('#edit_student_btn').attr("disabled", false);
                        $('#editModal').modal('hide');
                        $('.table').load(location.href + ' .table');
                        // $('.table').html(response);
                    }
                }
            })

        });


        //change profile picture
        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.profile-pic').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        $(".file-upload").on('change', function() {
            readURL(this);
        });

        $(".upload-button").on('click', function() {
            $(".file-upload").click();
        });


    });
</script>

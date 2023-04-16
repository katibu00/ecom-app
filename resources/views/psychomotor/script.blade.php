<script>
    $(document).ready(function() {

        //store socio-emotional
        $(document).on('submit', '#add_new_form', function(e) {
            e.preventDefault();

            let formData = new FormData($('#add_new_form')[0]);

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
                url: "{{ route('psychomotor.store') }}",
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
                        $('#data_form')[0].reset();
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

       

        //fetch students 
        $(document).on('submit', '#search_form', function(e) {
            e.preventDefault();


            var class_id = $('#class_id').val();
            var type = $('#type').val();
            $('#send_class_id').val(class_id);
            $('#send_type').val(type);

            if (class_id == '' || type == '') {
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


            if (type == 1) {

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
                    type: 'POST',
                    url: '{{ route('psychomotor.get') }}',
                    data: {
                        'class_id': class_id,
                        'type': 1,
                    },
                    success: function(res) {


                        if (res.status == 200) {
                            $('#marks-generate').removeClass('d-none');

                            var head = '';
                            head += '<tr>'
                            head += '<th>Name</th>'
                            head += '<th>Pos</th>'
                            head += '<th>Marks</th>'

                            $.each(res.grades, function(key, grade) {
                                head += '<th>' + grade.name + '</th>'
                            });
                            head += '</tr>';
                            head = $('#table-head').html(head);

                            var html = '';
                            var middle_name = '';

                            $.each(res.students, function(key, v) {

                                if (v.student.middle_name !== null) {
                                    middle_name = v.student.middle_name;
                                }

                                html += '<tr>';

                                html += '<td>' + v.student.first_name + ' ' +
                                    middle_name + ' ' + v.student.last_name +
                                    '</td>';
                                html += '<td>' + (key + 1) + '</td>';
                                html += '<td>' + v.total + '</td>';

                                $.each(res.grades, function(key, grade) {

                                    html +=
                                        '<td> <select name="score[]" class="form-select form-select-sm bg-white" required>';
                                    html +=
                                        '<option value=""></option> <option value="5">5</option>';
                                    html += '<option value="4">4</option>';
                                    html += '<option value="3">3</option>';
                                    html += '<option value="2">2</option>';
                                    html +=
                                        '<option value="1">1</option></select></td>';
                                    html +=
                                        '<input type="hidden" name="grade_id[]" value="' +
                                        grade.id + '" />'
                                    html +=
                                        '<input type="hidden" name="student_id[]" value="' +
                                        v.student.id + '" />'
                                });


                                html += '</tr>';
                            });
                            html = $('#marks-generate-tr').html(html);
                        }

                        if (res.status == 404) {
                            Command: toastr["error"](res.message)
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
                        }
                        $('#search_btn').html("Fetch Record");
                        $('#search_btn').attr("disabled", false);

                    }
                });


            } else if (type == 2) {

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
                    type: 'POST',
                    url: '{{ route('psychomotor.get') }}',
                    data: {
                        'class_id': class_id,
                        'type': 2,
                    },
                    success: function(res) {


                        if (res.status == 200) {
                            $('#marks-generate').removeClass('d-none');

                            var head = '';
                            head += '<tr>'
                            head += '<th>Name</th>'
                            head += '<th>Pos</th>'
                            head += '<th>Marks</th>'

                            $.each(res.grades, function(key, grade) {
                                head += '<th>' + grade.name + '</th>'
                            });
                            head += '</tr>';
                            head = $('#table-head').html(head);

                            var html = '';
                            var middle_name = '';

                            $.each(res.students, function(key, v) {

                                if (v.student.middle_name !== null) {
                                    middle_name = v.student.middle_name;
                                }
                                html += '<tr>';

                                html += '<td>' + v.student.first_name + ' ' +
                                    middle_name + ' ' + v.student.last_name +
                                    '</td>';
                                html += '<td>' + (key + 1) + '</td>';
                                html += '<td>' + v.total + '</td>';

                                $.each(res.grades, function(key, grade) {

                                    html +=
                                        '<td> <select name="score[]" class="form-select form-select-sm bg-white" required>';
                                    html +=
                                        '<option value=""></option> <option value="5">5</option>';
                                    html += '<option value="4">4</option>';
                                    html += '<option value="3">3</option>';
                                    html += '<option value="2">2</option>';
                                    html +=
                                        '<option value="1">1</option></select></td>';
                                    html +=
                                        '<input type="hidden" name="grade_id[]" value="' +
                                        grade.id + '" />'
                                    html +=
                                        '<input type="hidden" name="student_id[]" value="' +
                                        v.student.id + '" />'
                                });


                                html += '</tr>';
                            });
                            html = $('#marks-generate-tr').html(html);
                        }

                        if (res.status == 404) {
                            Command: toastr["error"](res.message)
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
                        }

                        $('#search_btn').html("Fetch Record");
                        $('#search_btn').attr("disabled", false);

                    }
                });

            };


        });



    });
</script>

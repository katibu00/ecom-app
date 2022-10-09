<script>
    $(document).ready(function() {

        //create
        $(document).on('submit', '#create_data_form', function(e) {
            e.preventDefault();

            let formData = new FormData($('#create_data_form')[0]);

            spinner =
                '<div class="spinner-border" style="height: 20px; width: 20px;" role="status"><span class="sr-only">Loading...</span></div> Submitting . . .'
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
        $(document).on('click', '#student_details', function() {

            $('#content_div').addClass('d-none');
            $('#std_loading_div').removeClass('d-none');

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
                            $("#picture").attr("src", "/uploads/" + res.school_name + '/' + res
                                .student.image);
                        }

                        $('#first_name').html(res.student.first_name);
                        $('#middle_name').html(res.student.middle_name);
                        $('#last_name').html(res.student.last_name);
                        $('#roll_number').html(res.student.login);
                        $('#class').html(res.student.class.name);
                      
                        $('#registered').html(res.registered);
                        $('.modal-title').html('Details for ' + student_name);
                        $('#content_div').removeClass('d-none');
                        $('#std_loading_div').addClass('d-none');

                        $('#parent_name').html(res.student.parent.title +' '+res.student.parent.first_name+' '+res.student.parent.last_name);
                        $('#parent_email').html(res.student.parent.email);
                        $('#parent_phone').html(res.student.parent.phone);
                        $('#parent_address').html(res.student.parent.name);
                    
                       

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
    });
</script>

<script type="text/javascript">
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
</script>


<script type="text/javascript">
    $(document).on('change', '#select_class', function() {


        var class_id = $('#select_class').val();
        $('#loading_div').removeClass('d-none')
        $('#example5').addClass('d-none');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '{{ route('users.students.sort') }}',
            data: {
                'class_id': class_id
            },
            success: function(res) {

                $('#loading_div').addClass('d-none');
                $('#example5').html(res);
                $('#example5').removeClass('d-none');

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
</script>

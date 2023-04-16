<script type="text/javascript">
    $(function() {

        //onchange class
        $(document).on('change', '#class_id', function() {

            const class_id = $('#class_id').val();
            $('#subjects').html('<option value="">Loading...</option>');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('get-subjects_offering') }}',
                data: {
                    'class_id': class_id,
                },
                success: function(res) {

                    if (res.subjects.length == 0) {
                        Command: toastr["error"](
                            "No Subjects Assigned for the selected Class."
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
                        $('#subjects').html('<option value=""></option>');
                        return
                    }
                    var html = '<option value="">Select Student</option>';
                    $.each(res.subjects, function(key, subject) {

                        html += '<option value="' + subject.subject.id + '">' +
                            subject.subject.name + '</option>';
                    });
                    html = $('#subjects').html(html);
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
                        $(".card").LoadingOverlay("hide")
                    }
                }
            });

        });

        $(document).on('click', '.form-check-input.subject', function() {
            var subject_id = $(this).data('subject_id');
            var student_id = $(this).data('student_id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if ($(this).prop('checked')) {
                $.ajax({
                    url: '{{ route('save-subjects_offering') }}',
                    method: 'POST',
                    data: {
                        subject_id: subject_id,
                        student_id: student_id,
                        action: 'checked'
                    },
                    success: function(res) {
                        Command: toastr["success"](res.message);
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
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else {
                $.ajax({
                    url: '{{ route('save-subjects_offering') }}',
                    method: 'POST',
                    data: {
                        subject_id: subject_id,
                        student_id: student_id,
                        action: 'unchecked'
                    },
                    success: function(res) {
                        Command: toastr["success"](res.message);
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
            }
        });

    });
</script>

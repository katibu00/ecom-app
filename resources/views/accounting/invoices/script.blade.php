<script>
    $(document).ready(function() {

        //search records
        $(document).on('submit', '#search_form', function(e) {
            e.preventDefault();

            var class_id = $('#class_id').val();
           

            $('#send_class_id').val(class_id);
          
            if (class_id == '') {
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
                url: "{{ route('invoices.get.students') }}",
                data: {
                    'class_id': class_id
                },
                success: function(res) {

                    if (res.students.length == 0) {
                        Command: toastr["error"](
                            "No Students Found the Selected Class")
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
                    $.each(res.students, function(key, student) {

                        html +=
                            '<tr>' +
                            '<td>' + student.login +
                            '<input type="hidden" name="student_id[]" value="' + student.id + '"></td>' +
                            '<td>' + student.first_name + ' ' + student.middle_name + ' ' + student.last_name + '</td>' +
                            '<td> <select name="student_type[]" class="default-select form-control wide " >' +
                            '<option value=""></option> <option value="r" selected>Regular</option>' +
                            '<option value="t">Transfer</option>' +
                            '<option value="s">Scholarship</option></td>' +
                            '<td><input type="number" class="form-control" name="pre_balance[]" placeholder="Balance Carried Forward" ></td>' +
                            '<td><input type="number" class="form-control" name="discount[]" placeholder="Discount" ></td>' +
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
        $(document).on('submit', '#invoices_form', function(e) {
            e.preventDefault();

            let formData = new FormData($('#invoices_form')[0]);

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
                url: "{{ route('invoices.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.status == 200) {
                        // $('.table').load(location.href + ' .table');
                        $('#addModal').modal('hide');
                        $('#invoices_form')[0].reset();
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
                        $('#invoices_form')[0].reset();
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
           $('.viewTitle').html('Fetch Comments for Class '+class_name);
           $('#view_class_id').val(class_id);
           $('#loading_div').addClass('d-none');
                        $('#content_div').addClass('d-none');
                        html = $('#comments-generate-tr').html(null);

       });

        //view comments change select
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
                data: {'class_id':class_id, 'officer':officer},
                beforeSend: function(){
                    $('#loading_div').removeClass('d-none');
                    $('#content_div').addClass('d-none');
                    html = $('#comments-generate-tr').html(null);
                },
                success: function(data){

                    if(!$.trim(data)){
                       
                        
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
                    $.each( data, function(key, v){

                        html +=
                        '<tr>'+
                        '<td>'+(key+1)+'</td>'+
                        '<td>'+v.student.login+'</td>'+
                        '<td>'+v.student.first_name+' '+v.student.middle_name+' '+v.student.last_name+'</td>'+
                        '<td>'+v.comment+' '+v.additional+'</td>'+
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

    });
</script>

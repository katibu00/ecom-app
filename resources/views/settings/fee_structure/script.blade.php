<script>
    $(document).ready(function() {

        //create
        $(document).on('submit', '#create_data_form', function(e) {
            e.preventDefault();

            let formData = new FormData($('#create_data_form')[0]);

            spinner =
                '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div> &nbsp; Submitting . . .'
            $('#submit_btn').html(spinner);
            $('#submit_btn').attr("disabled", true);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('settings.fee_structure.index') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.status == 201) {
                        $('.table').load(location.href + ' .table');
                        $('#addModal').modal('hide');
                        $('#create_data_form')[0].reset();
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
                    if (response.status == 400) {
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
                }
            });

        });

        //delete item
        $(document).on('click', '.deleteItem', function(e) {
            e.preventDefault();
            let id = $(this).data('row_id');
            let name = $(this).data('name');
            swal({
                    title: "Unassign " + name + "?",
                    text: "You may instead make the fee inactive to restore it later!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: "{{ route('settings.fee_structure.delete') }}",
                            method: 'POST',
                            data: {
                                id: id,
                            },
                            success: function(res) {
                                if (res.status == 200) {
                                    swal('Unassigned', res.message, "success");
                                    $('.table').load(location.href + ' .table');
                                }
                            }
                        });
                    }
                });
        });

        //fee daetails item
        $(document).on('click', '.feeDetails', function() {
            let name = $(this).data('name');
            let class_id = $(this).data('class_id');
            let std_type = $(this).data('std_type');

            var html = '';
            $("#fee_list").html(html);

            $("#loading_div").removeClass("d-none");
            $("#content_div").addClass("d-none");

            $('.modal-title').html('Fee Details For  ' + name + ' - ' + std_type);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "POST",
                url: "{{ route('settings.fee_structure.details') }}",
                data: {
                    'class_id': class_id,
                    'std_type': std_type,
                },
                dataType: "json",
                success: function(res) {

                    if (res.status == 400) {
                        $("#update_error_list").html("");
                        $("#update_error_list").addClass("alert alert-danger");
                        $.each(res.errors, function(key, err) {
                            $("#update_error_list").append("<li>" + err + "</li>");
                        });
                        Command: toastr["error"](
                            "Check your input and try again."
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
                        $("#update_btn").text("Update");
                        $("#update_btn").attr("disabled", false);
                    }

                    if (res.status == 200) {

                        $("#loading_div").addClass("d-none");
                        $("#content_div").removeClass("d-none");

                        var html = '';
                        $.each(res.fees, function(key, fee) {

                            html +=
                                '<tr>' +
                                '<td>' + fee.fee_category.name + '</td>' +
                                '<td>' + fee.fee_category.priority.toUpperCase() +
                                '</td>' +
                                '<td>' + fee.amount + '</td>' +
                                '</tr>';

                        });
                        html +=
                            '<tr>' +
                            '<td><strong>Total Amount</strong></td>' +
                            '<td rowspan="2"><strong>' + '&#8358;' + res.amount +
                            '<strong></td>' +
                            '</tr>';
                        $("#fee_list").html(html);
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


        //edit item
        $(document).on('click', '.editItem', function() {

            let amount = $(this).data('amount');
            let id = $(this).data('row_id');
            let status = $(this).data('status');
            if (status == 1) {
                $("#status").prop("checked", true)
            }

           
            $('#edit_amount').val(amount);
            $('#update_row_id').val(id);
        });

        //update data
        $(document).on('click', '#update_btn', function(e) {
            e.preventDefault();
            amount = $('#edit_amount').val()
            id = $('#update_row_id').val()
        
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            spinner =
                '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div> &nbsp; Updating. . .';
            $("#update_btn").html(spinner);
            $("#update_btn").attr("disabled", true);

            $.ajax({
                type: "POST",
                url: "{{ route('settings.fee_structure.update') }}",
                data: {
                    'amount': amount,
                    'id': id,
                    status: $("#status").prop("checked") == true ? 1 : 0,
                },
                dataType: "json",
                success: function(res) {

                    if (res.status == 400) {
                        $("#update_error_list").html("");
                        $("#update_error_list").addClass("alert alert-danger");
                        $.each(res.errors, function(key, err) {
                            $("#update_error_list").append("<li>" + err + "</li>");
                        });
                        Command: toastr["error"](
                            "Check your input and try again."
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
                        $("#update_btn").text("Update");
                        $("#update_btn").attr("disabled", false);
                    }

                    if (res.status == 200) {

                        $('#update_error_list').html("");
                        $('#update_error_list').removeClass('alert alert-danger');
                        $('#editModal').modal('hide');
                        $('#update_btn').text("Update");
                        $('#update_btn').attr("disabled", false);
                        $('.table').load(location.href + ' .table');

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
                        $("#update_btn").text("Update");
                        $("#update_btn").attr("disabled", false);


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

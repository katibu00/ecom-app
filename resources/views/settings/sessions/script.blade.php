<script>
    $(document).ready(function() {
       
        //create data
        $(document).on('click', '#submit_btn', function(e) {
            e.preventDefault();
            name = $('#name').val()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            spinner = '<div class="spinner-border" style="height: 20px; width: 20px;" role="status"><span class="sr-only"></span></div> &nbsp; Submitting...';          
            $("#submit_btn").html(spinner);
            $("#submit_btn").attr("disabled", true);

            $.ajax({
                type: "POST",
                url: "{{ route('settings.sessions.index') }}",
                data: {
                    'name': name
                },
                dataType: "json",
                success: function(res) {

                    if (res.status == 400) {
                        $("#error_list").html("");
                        $("#error_list").addClass("alert alert-danger");
                        $.each(res.errors, function (key, err) {
                            $("#error_list").append("<li>" + err + "</li>");
                        });
                        Command: toastr["error"](
                            "Check your input and try again."
                        );
                       
                        $("#submit_btn").text("Submit");
                        $("#submit_btn").attr("disabled", false);
                    }

                    if (res.status == 201) {

                        $('#error_list').html("");
                        $('#error_list').removeClass('alert alert-danger');
                        $('#addNewModal').modal('hide');
                        $('#submit_btn').text("Submit");
                        $('#submit_btn').attr("disabled", false);
                        $('#name').val("");
                        $('.table').load(location.href+' .table');
                        
                        Command: toastr["success"](res.message);
                       
                        $("#submit_btn").text("Submit");
                        $("#submit_btn").attr("disabled", false);
                        if (res.count == 1) {
                            location.reload(); 
                        }

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

         //delete item
         $(document).on('click', '.deleteItem', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let name = $(this).data('name');

            swal({
                    title: "Delete " + name + "?",
                    text: "Once deleted, you will not be able to recover it!",
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
                            url: "{{ route('settings.session.delete') }}",
                            method: 'POST',
                            data: {
                                id: id,
                            },

                            success: function(res) {

                                if (res.status == 200) {
                                    swal('Deleted', res.message, "success");
                                    $('.table').load(location.href + ' .table');
                                }
                                if (res.status == 400) {
                                    swal('Cannot Delete', res.message, "error");
                                }

                            }
                        });

                    }
                });

        });

         //edit item
         $(document).on('click', '.editItem', function() {
           
            let name = $(this).data('name');
            let id = $(this).data('id');
         
            $('.modal-title').html('Update '+name);
            $('#edit_name').val(name);
            $('#update_id').val(id);
        });

        //update data
        $(document).on('click', '#update_btn', function(e) {
            e.preventDefault();

            name = $('#edit_name').val()
            id = $('#update_id').val()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            spinner = '<div class="spinner-border" style="height: 20px; width: 20px;" role="status"><span class="sr-only"></span></div> &nbsp; Updating...';
                        $("#update_btn").html(spinner);
            $("#update_btn").attr("disabled", true);

            $.ajax({
                type: "POST",
                url: "{{ route('settings.session.update') }}",
                data: {
                    'name': name, 'id':id
                },
                dataType: "json",
                success: function(res) {

                    if (res.status == 400) {
                        $("#update_error_list").html("");
                        $("#update_error_list").addClass("alert alert-danger");
                        $.each(res.errors, function (key, err) {
                            $("#update_error_list").append("<li>" + err + "</li>");
                        });
                        Command: toastr["error"](
                            "Check your input and try again."
                        );
                       
                        $("#update_btn").text("Update");
                        $("#update_btn").attr("disabled", false);
                    }

                    if (res.status == 200) {

                        $('#update_error_list').html("");
                        $('#update_error_list').removeClass('alert alert-danger');
                        $('#editModal').modal('hide');
                        $('#update_btn').text("Update");
                        $('#update_btn').attr("disabled", false);
                        $('.table').load(location.href+' .table');
                        
                        Command: toastr["success"](res.message);
                       
                        $("#update_btn").text("Update");
                        $("#update_btn").attr("disabled", false);


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
        
    });
</script>
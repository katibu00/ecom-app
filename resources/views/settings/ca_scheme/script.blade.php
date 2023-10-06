<script>
    $(document).ready(function() {
       
        //create
        $(document).on('submit', '#create_data_form', function(e){
            e.preventDefault();
            
            let formData = new FormData($('#create_data_form')[0]);
    
            spinner = '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div>&nbsp; Submitting . . .'
                     $('#submit_btn').html(spinner);
                     $('#submit_btn').attr("disabled", true);
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $.ajax({
                type: "POST",
                url: "{{ route('settings.ca_scheme.index') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
    
                        if(response.status == 200){
                            $('.table').load(location.href+' .table');
                            $('#addModal').modal('hide');
                            $('#create_data_form')[0].reset();
                            Command: toastr["success"](response.message)
                            if (response.count < 1) {
                                location.reload(); 
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
                            url: "{{ route('settings.ca_scheme.delete') }}",
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
           
            let code = $(this).data('code');
            let desc = $(this).data('desc');
            let marks = $(this).data('marks');
            let id = $(this).data('id');
            let status = $(this).data('status');
            if(status == 1)
            {
                $("#status").prop("checked", true)
            }
         
            $('.modal-title').html('Update '+name);
            $('#code').val(code);
            $('#desc').val(desc);
            $('#marks').val(marks);
            $('#update_id').val(id);
        });

        //update data
        $(document).on('click', '#update_btn', function(e) {
            e.preventDefault();

            code = $('#code').val()
            desc = $('#desc').val()
            marks = $('#marks').val()
            id = $('#update_id').val()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            spinner = '<div class="spinner-border" style="height: 20px; width: 20px;" role="status"><span class="sr-only">Loading...</span></div> Updating. . .';
            $("#update_btn").html(spinner);
            $("#update_btn").attr("disabled", true);

            $.ajax({
                type: "POST",
                url: "{{ route('settings.ca_scheme.update') }}",
                data: {
                    'code': code, 'desc': desc, 'marks': marks, 'id':id,  status: $("#status").prop("checked") == true ? 1 : 0,
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
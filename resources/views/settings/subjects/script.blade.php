<script>
    $(document).ready(function() {
       
        //create
        $(document).on('submit', '#addNewForm', function(e){
            e.preventDefault();
            
            let formData = new FormData($('#addNewForm')[0]);
    
            spinner = '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div> &nbsp; Submitting . . .'
                     $('#submit_btn').html(spinner);
                     $('#submit_btn').attr("disabled", true);
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $.ajax({
                type: "POST",
                url: "{{ route('settings.subjects.index') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
    
                        if(response.status == 200){
                            $('.table').load(location.href+' .table');
                            $('#addNewModal').modal('hide');
                            $('#addNewForm')[0].reset();
                            Command: toastr["success"](response.message)
                            if (response.count == 0) {
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
                            url: "{{ route('settings.subject.delete') }}",
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
            let status = $(this).data('status');
           
         
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

            spinner = '<div class="spinner-border" style="height: 20px; width: 20px;" role="status"><span class="sr-only">Loading...</span></div> Updating. . .';
            $("#update_btn").html(spinner);
            $("#update_btn").attr("disabled", true);

            $.ajax({
                type: "POST",
                url: "{{ route('settings.subject.update') }}",
                data: {
                    'name': name, 'id':id,
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
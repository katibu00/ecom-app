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
                url: "{{ route('settings.assign_subjects.index') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.status == 200) {
                        $('.table').load(location.href + ' .table');
                        $('#addModal').modal('hide');
                        $('#create_data_form')[0].reset();
                        Command: toastr["success"](response.message)
                        if (response.count == 0) {
                            location.reload();
                        }

                        $('#submit_btn').text("Submit");
                        $('#submit_btn').attr("disabled", false);
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
                    title: "Unassign " + name + "?",
                    text: "Once Unassigned, All Exams record for the selected Subject will also be deleted!",
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
                            url: "{{ route('settings.assign_subjects.delete') }}",
                            method: 'POST',
                            data: {
                                id: id,
                            },
                            success: function(res) {

                                if (res.status == 200) {
                                    swal('Unassigned', res.message, "success");
                                    $('.table').load(location.href + ' .table');
                                }
                                if (res.status == 400) {
                                    swal('Cannot Unassign', res.message, "error");
                                }

                            }
                        });
                    }
                });
        });

        //edit item
        $(document).on('click', '.editItem', function() {
            let class_name = $(this).data('class_name');
            let subject_name = $(this).data('subject_name');
            let row_id = $(this).data('row_id');
            let teacher_id = $(this).data('teacher_id');
            let designation = $(this).data('designation');

            $('.modal-title').html('Update ' + subject_name + ' teacher for ' + class_name + '?');
            $('#update_id').val(row_id);
            $('#update_teacher_id').val(teacher_id);

            $('#update_designation').val(designation ? 1 : 0);
            $('#update_teacher_id').trigger('change');
            $('#update_designation').trigger('change');
        });

        //update data
        $(document).on('click', '#update_btn', function(e) {
            e.preventDefault();

            teacher_id = $('#update_teacher_id').val();
            designation = $('#update_designation').val();
            id = $('#update_id').val()

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
                url: "{{ route('settings.assign_subjects.update') }}",
                data: {
                    'teacher_id': teacher_id,
                    'id': id,
                    'designation': designation,
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

                        $("#update_btn").text("Update");
                        $("#update_btn").attr("disabled", false);
                        $("#update_form")[0].reset();
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

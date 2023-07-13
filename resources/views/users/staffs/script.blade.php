<script>
    $(document).ready(function() {

        ///staff details
        $(document).on('click', '.staff_details', function() {

            $('#details_content_div').addClass('d-none');
            $('#details_loading_div').removeClass('d-none');

            let staff_name = $(this).data('staff_name');
            let staff_id = $(this).data('staff_id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "POST",
                url: "{{ route('users.staff.details') }}",
                data: {
                    'staff_id': staff_id
                },
                dataType: "json",
                success: function(res) {

                    if (res.status == 200) {

                        if (res.staff.image != 'default.png') {
                            $("#picture").attr("src", "/uploads/" + res.school_name + '/' +
                                res.staff.image);
                        }

                        $('#full_name').html(res.staff.first_name+' '+res.staff.last_name);
                        $('#phone').html(res.staff.phone);
                        $('#email').html(res.staff.email);
                        $('#password').html(res.staff.middle_name);

                        $('#registered').html(res.registered);
                       
                        $('.modal-title').html('Details for ' + staff_name);
                        $('#details_content_div').removeClass('d-none');
                        $('#details_loading_div').addClass('d-none');

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

        //sort by class
        $(document).on('change', '#sort_staffs', function() {

            var sort_staffs = $('#sort_staffs').val();
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
                url: `{{ route('users.staffs.sort') }}` + '?sort_staffs=' + sort_staffs,

                success: function(res) {

                    $('#content_div').removeClass('d-none');
                    $('#loading_div').addClass('d-none');
                    $('.table').html(res);

                    if (res.status == 404) {
                        Command: toastr["warning"](
                            "No Staffs Found in the Selected Category."
                        );
                        
                        $('.table').html("No Staffs Found in the Selected Category.");
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
                url: "{{ route('users.staffs.search') }}",
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
            var counter = 2;
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


        //on click edit staffs
        $(document).on('click', '.edit_staff', function(e) {
            e.preventDefault();

            let staff_id = $(this).data('staff_id');
            let staff_name = $(this).data('staff_name');
            $('#edit_staff_id').val(staff_id);

            $('#edit_loading_div').removeClass('d-none');
            $('#edit_content_div').addClass('d-none');
            $('#edit_staff_form')[0].reset();
            $('#edit_usertype option:selected').removeAttr('selected');
            $('#edit_staff_modal_title').html('Edit ' + staff_name + 's Profile');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('get-staff_details') }}',
                data: {
                    'staff_id': staff_id,
                },
                success: function(res) {

                    if (res.staff.image != null) {
                        $("#edit_staff_picture").attr("src", "/uploads/" + res
                            .school_username.username + '/' + res.staff.image);
                    }

                    $('#edit_loading_div').addClass('d-none');
                    $('#edit_content_div').removeClass('d-none');
                    $('#edit_first_name').val(res.staff.first_name);
                    $('#edit_last_name').val(res.staff.last_name);
                    $('#edit_email').val(res.staff.email);
                    $('#edit_phone_number').val(res.staff.phone);
                    $(`#edit_usertype option[value="${res.staff.usertype}"]`).attr(
                        "selected", "selected");
                   



                }
            });


        });

        //edit staffs form
        $(document).on('submit', '#edit_staff_form', function(e) {
            e.preventDefault();

            let formData = new FormData($('#edit_staff_form')[0]);

            spinner =
                '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div>&nbsp; Saving . . .'
            $('#edit_staff_btn').html(spinner);
            $('#edit_staff_btn').attr("disabled", true);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('users.staffs.edit') }}",
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
                        $('#edit_staff_btn').text("Save Changes");
                        $('#edit_staff_btn').attr("disabled", false);
                        Command: toastr["error"]("some Required Fields are not Filled")
                    }

                    if (response.status == 200) {
                        Command: toastr["success"](response.message)

                        $('#edit_staff_btn').text("Save Changes");
                        $('#edit_staff_btn').attr("disabled", false);
                        $('#editModal').modal('hide');
                        $('.table').load(location.href + ' .table');
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

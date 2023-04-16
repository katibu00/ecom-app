<script>
    $(document).ready(function() {

        ///parent details
        $(document).on('click', '.parent_details', function() {

            $('#details_content_div').addClass('d-none');
            $('#details_loading_div').removeClass('d-none');

            let parent_name = $(this).data('parent_name');
            let parent_id = $(this).data('parent_id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "POST",
                url: "{{ route('users.parents.details') }}",
                data: {
                    'parent_id': parent_id
                },
                dataType: "json",
                success: function(res) {

                    if (res.status == 200) {

                        if (res.parent.image != 'default.png') {
                            $("#picture").attr("src", "/uploads/" + res.school_name + '/' +
                                res.parent.image);
                        }

                        $('#first_name').html(res.parent.first_name);
                        $('#middle_name').html(res.parent.middle_name);
                        $('#last_name').html(res.parent.last_name);

                        $('#registered').html(res.registered);
                       

                        $('.modal-title').html('Details for ' + parent_name);
                        $('#details_content_div').removeClass('d-none');
                        $('#details_loading_div').addClass('d-none');

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

        //sort by class
        $(document).on('change', '#sort_parents', function() {

            var sort_parents = $('#sort_parents').val();
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
                url: `{{ route('users.parents.sort') }}` + '?sort_parents=' + sort_parents,

                success: function(res) {

                    $('#content_div').removeClass('d-none');
                    $('#loading_div').addClass('d-none');
                    $('.table').html(res);

                    if (res.status == 404) {
                        Command: toastr["warning"](
                            "No Parents Found in the Selected Category."
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
                        $('.table').html("No Parents Found in the Selected Category.");
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
                url: "{{ route('users.parents.search') }}",
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


        //on click edit parents
        $(document).on('click', '.edit_parent', function(e) {
            e.preventDefault();

            let parent_id = $(this).data('parent_id');
            let parent_name = $(this).data('parent_name');
            $('#edit_parent_id').val(parent_id);

            $('#edit_loading_div').removeClass('d-none');
            $('#edit_content_div').addClass('d-none');
            $('#edit_parent_form')[0].reset();
            $('#edit_parent option:selected').removeAttr('selected');
            $('#edit_gender option:selected').removeAttr('selected');
            $("#edit_parent_picture").attr("src", "/uploads/default.png");
            $('#edit_parent_modal_title').html('Edit ' + parent_name + 's Profile');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('get-parent_details') }}',
                data: {
                    'parent_id': parent_id,
                },
                success: function(res) {

                    if (res.parent.image != 'default.png') {
                        $("#edit_parent_picture").attr("src", "/uploads/" + res
                            .school_username.username + '/' + res.parent.image);
                    }

                    $('#edit_loading_div').addClass('d-none');
                    $('#edit_content_div').removeClass('d-none');
                    $('#edit_first_name').val(res.parent.first_name);
                    $('#edit_last_name').val(res.parent.last_name);
                    $('#edit_roll_number').val(res.parent.login);
                    $(`#edit_parent option[value="${res.parent.parent_id}"]`).attr(
                        "selected", "selected");
                    $(`#edit_gender option[value="${res.parent.gender}"]`).attr("selected",
                        "selected");



                }
            });


        });

        //edit parents form
        $(document).on('submit', '#edit_parent_form', function(e) {
            e.preventDefault();

            let formData = new FormData($('#edit_parent_form')[0]);

            spinner =
                '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div>&nbsp; Saving . . .'
            $('#edit_parent_btn').html(spinner);
            $('#edit_parent_btn').attr("disabled", true);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('users.parents.edit') }}",
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
                        $('#edit_parent_btn').text("Save Changes");
                        $('#edit_parent_btn').attr("disabled", false);
                        Command: toastr["error"](
                            "Some Fields are required. Please check your input and try again."
                            )

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
                    }

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

                        $('#edit_parent_btn').text("Save Changes");
                        $('#edit_parent_btn').attr("disabled", false);
                        $('#editModal').modal('hide');
                        $('.table').load(location.href + ' .table');
                        // $('.table').html(response);
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

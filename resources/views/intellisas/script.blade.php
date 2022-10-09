<script>
    $(document).ready(function() {

        $(document).on('click', '#school_details', function() {

            $('#content_div').addClass('d-none');
            $('#loading_div').removeClass('d-none');

            let username = $(this).data('username');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "POST",
                url: "{{ route('get-school-details') }}",
                data: {
                    'username': username
                },
                dataType: "json",
                success: function(res) {

                    if (res.status == 200) {

                        if (res.school.logo != 'default.png') {
                            $("#logo").attr("src", "/uploads/" + res.school.user+'/'+res.school.logo);
                        } 

                        $('#name').html(res.school.name);
                        $('#registered').html(res.registered);
                        $('.modal-title').html('Details for '+ res.school.name);
                        $('#username').html(res.school.username);
                        $('#motto').html(res.school.motto);
                        $('#phone').html(res.school.phone_second);
                        $('#phone2').html(res.school.phone_first);
                        $('#email').html(res.school.email);
                        $('#website').html(res.school.website);
                        $('#state').html(res.school.state);
                        $('#lga').html(res.school.lga);
                        $('#address').html(res.school.address);
                        $('#service_fee').html(res.school.service_fee);
                        $('#students').html(res.students);
                        $('#parents').html(res.parents);
                        $('#staffs').html(res.staffs);
                        $('#fee_term').html(res.school.service_fee*res.students);
                    
                        $('#admin_name').html(res.school.admin.first_name+' '+res.school.admin.last_name);
                        $('#admin_email').html(res.school.admin.email);
                        $('#admin_phone').html(res.school.admin.phone);
                        $('#registrar').html(res.school.registrar.first_name+' '+res.school.registrar.last_name);

                        $('#content_div').removeClass('d-none');
                        $('#loading_div').addClass('d-none');

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
        $(document).on('click', '#edit_school', function() {

            $('#content_div').addClass('d-none');
            $('#loading_div').removeClass('d-none');

            let name = $(this).data('name');
            let username = $(this).data('username');
            let heading = $(this).data('heading');
            let service_fee = $(this).data('service_fee');

            $('#edit_name').val(name);
            $('#edit_username').val(username);
            $("select[name=edit_heading] option[value=h1]").attr("selected", "selected");
            $('#edit_service').val(service_fee);

            
        });
    });
</script>

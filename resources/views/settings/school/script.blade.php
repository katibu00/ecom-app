<script>
    $(document).ready(function() {
    
        
        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
    
                reader.onload = function (e) {
                    $('.profile-pic').attr('src', e.target.result);
                }
        
                reader.readAsDataURL(input.files[0]);
            }
        }
        
    
        $(".file-upload").on('change', function(){
            readURL(this);
        });
        
        $(".upload-button").on('click', function() {
           $(".file-upload").click();
        });
    
    
        $(document).on('submit', '#edit_school_form', function(e){
            e.preventDefault();
            
            let formData = new FormData($('#edit_school_form')[0]);
    
            spinner = '<div class="spinner-border" style="height: 20px; width: 20px;" role="status"><span class="sr-only">Loading...</span></div> Saving . . .'
                     $('#submit_btn').html(spinner);
                     $('#submit_btn').attr("disabled", true);
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $.ajax({
                type: "POST",
                url: "{{ route('settings.basic.index') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                  
                    if(response.status == 400){
                            $('#error_list').html("");
                            $('#error_list').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err){
                                $('#error_list').append('<li>'+err+'</li>');
                            });
                            $('#submit_btn').text("Save Changes");
                            $('#submit_btn').attr("disabled", false);
                            Command: toastr["error"]("Some Fields are required. Please check your input and try again.")
    
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
    
                        if(response.status == 200){
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

                            $('#submit_btn').text("Save Changes");
                            $('#submit_btn').attr("disabled", false);
                        }
                }
            })
    
        })
    
    
    });
    </script>
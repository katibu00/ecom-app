<script>
    $(document).ready(function() {

        $(document).on('submit', '#monnify_form', function(e) {
    e.preventDefault();
    var $form = $(this);
    var $submitButton = $form.find('#submit_btn');
    var $errorList = $form.find('#error_list');

    $submitButton.html('<div class="spinner-border" role="status"></div> &nbsp; Saving . . .');
    $submitButton.attr('disabled', true);
    $errorList.html('').removeClass('alert alert-danger');

    var formData = new FormData(this);
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    $.ajax({
        type: 'POST',
        url: $form.attr('action'),
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.status === 'error') {
                $errorList.addClass('alert alert-danger');
                $.each(response.errors, function(key, err) {
                    $errorList.append('<li>' + err + '</li>');
                });
                toastr.error('All fields are required. Please check your input and try again.');
            } else if (response.status === 'success') {
                toastr.success(response.message);
            }
        },
        error: function(xhr, status, error) {
            toastr.error('An error occurred. Please try again.');
        },
        complete: function() {
            $submitButton.html('Save Changes');
            $submitButton.attr('disabled', false);
        }
    });
});



        $(document).ready(function() {
            // Handle enable Monnify switch change
            $('#enableMonnifySwitch').on('change', function() {
                var isChecked = $(this).prop('checked');
                if (isChecked) {
                    $('#monnifyFields').show();
                } else {
                    $('#monnifyFields').hide();
                }
            });
        });


    });
</script>

<script type="text/javascript">
    $(function() {

        $(document).on('click', '.optional', function() {
           
            var fee_id = $(this).data('fee_id');
            var student_id = $(this).data('student_id');
            var amount = $(this).data('amount');
            var invoice_id = $(this).data('invoice_id');
          
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if ($(this).prop('checked')) 
            {
                $.ajax({
                    url: '{{ route('mark_optional') }}',
                    method: 'POST',
                    data: {
                        fee_id: fee_id,
                        student_id: student_id,
                        amount: amount,
                        action: 'checked'
                    },
                    success: function(res) {
                    
                        toastr.success(res.message);
                        $('.total_mandatory').html(res.total_due.toLocaleString());
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else 
            {
                $.ajax({
                    url: '{{ route('mark_optional') }}',
                    method: 'POST',
                    data: {
                        fee_id: fee_id,
                        student_id: student_id,
                        amount: amount,
                        action: 'unchecked'
                    },
                    success: function(res) {
                        toastr.info(res.message);
                        $('.total_mandatory').html(res.total_due.toLocaleString());
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });

    });
</script>

<script>
    $(document).ready(function() {
        //on click edit students
        $(document).on('click', '.overview', function(e) {
            e.preventDefault();

            let class_id = $(this).data('class_id');
            let class_name = $(this).data('name');

            $('#title').html('Loading...');
            $('#details_content_div').addClass('d-none');
            $('#details_loading_div').removeClass('d-none');

            

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('attendance.get-details')}}',
                data: {
                    'class_id': class_id,
                },
                success: function(res) {

                    if(res.status === 200)
                    {
                        var html = '';
                        $.each(res.attendances, function(key, value) {

                            html +=
                                '<tr>' +
                                    '<td>' + value.student.first_name+' '+value.student.middle_name+' '+value.student.last_name +'</td>' +
                                    '<td>' + value.status +'</td>' +
                                '</tr>';
                        });
                        html = $('#tbody').html(html);

                        $('#details_content_div').removeClass('d-none');
                        $('#details_loading_div').addClass('d-none');
                        $('#title').html('Attendance Details for '+class_name);
                    }
                   


                }
            });


        });

    });
</script>

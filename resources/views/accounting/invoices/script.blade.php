<script>
    $(document).ready(function() {

        //search records
        $(document).on('submit', '#search_form', function(e) {
            e.preventDefault();

            var class_id = $('#class_id').val();
            var class_section_id = $('#class_section_id').val();
           

            $('#send_class_id').val(class_id);
            $('#send_class_section_id').val(class_section_id);
          
            if (class_id == '' || class_section_id == '') {
                Command: toastr["error"]("All fields are required")
               
                return;
            }

            spinner =
                '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div>&nbsp; Fetching data . . .'
            $('#search_btn').html(spinner);
            $('#search_btn').attr("disabled", true);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('invoices.get.students') }}",
                data: {
                    'class_id': class_id, 'class_section_id': class_section_id
                },
                success: function(res) {

                    if (res.students.length == 0) {
                        Command: toastr["error"](
                            "No Students Found the Selected Class")
                       
                        $('#marks-generate').addClass('d-none');
                        $('#marks-generate-tr').html('');
                        $('#search_btn').html("Search Records");
                        $('#search_btn').attr("disabled", false);
                        return;
                    }

                    $('#marks-generate').removeClass('d-none');

                    var options = '';
                    $.each(res.student_types, function(key2, student_type) {
                        options += '<option value="'+student_type.id+'">'+student_type.name+'</option>';
                    });
                  
                    var select = '<select name="student_type[]" class="form-select form-select-sm" required>' +
                                        '<option value=""></option> <option value="r">Regular</option>' +
                                        '<option value="t">Transfer</option>' +
                                        '<option value="s">Scholarship</option>'+
                                        options
                                '</select>';

                    var html = '';
                    $.each(res.students, function(key, student) {

                        html +=
                            '<tr>' +
                            '<td>' + student.login +
                            '<input type="hidden" name="student_id[]" value="' + student.id + '"></td>' +
                            '<td>' + student.first_name + ' ' + student.middle_name + ' ' + student.last_name + '</td>' +
                            '<td>'+select+'</td>' +
                            '<td><input type="number" class="form-control form-control-sm" name="pre_balance[]" placeholder="Balance Carried Forward"></td>' +
                            '<td><input type="number" class="form-control form-control-sm" name="discount[]" placeholder="Discount"></td>' +
                            '</tr>';
                    });
                    html = $('#marks-generate-tr').html(html);
                    $('#search_btn').html("Search Records");
                    $('#search_btn').attr("disabled", false);
                    $('#submit_btn').removeClass('d-none');
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


        //store invoices
        $(document).on('submit', '#invoices_form', function(e) {
            e.preventDefault();

            let formData = new FormData($('#invoices_form')[0]);

            spinner =
                '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div>&nbsp; Submitting . . .'
            $('#submit_btn').html(spinner);
            $('#submit_btn').attr("disabled", true);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('invoices.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.status == 200) {
                        $('#addModal').modal('hide');
                        $('#invoices_form')[0].reset();
                        Command: toastr["success"](response.message)
                        $('.invoices_table').load(location.href+' .invoices_table');
                        $('#submit_btn').text("Submit");
                        $('#submit_btn').attr("disabled", false);
                    }
                    if (response.status == 404) {
                        $('#invoices_form')[0].reset();
                        Command: toastr["error"](response.message)
                        
                        $('#submit_btn').text("Submit");
                        $('#submit_btn').attr("disabled", false);
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

        //edit items
        $(document).on('click', '.editItem', function() {
           
           let id = $(this).data('id');
           let name = $(this).data('name');
           let pre_balance = $(this).data('pre_balance');
           let discount = $(this).data('discount');
           let student_type = $(this).data('student_type');

           $('.editTitle').html('Edit Invoice for '+name);
           $('#discount').val(discount);
           $('#pre_balance').val(pre_balance);
           $('#update_id').val(id);

           $(`#student_type option[value="${student_type}"]`).attr('selected','selected');

       });

       //update invoice
       $(document).on('click', '#update_btn', function(e) {
            e.preventDefault();

           
            id = $('#update_id').val();
            discount = $('#discount').val();
            student_type = $('#student_type').val();
            pre_balance = $('#pre_balance').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            spinner = '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div> &nbsp; Updating. . .';
            $("#update_btn").html(spinner);
            $("#update_btn").attr("disabled", true);

            $.ajax({
                type: "POST",
                url: "{{ route('invoices.update') }}",
                data: {
                    'discount': discount, 'id':id,'student_type':student_type,'pre_balance':pre_balance,
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
                        $('.invoices_table').load(location.href+' .invoices_table');
                        
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

<script>

$(document).ready(function() {
    $('#sortStudentType').change(function() {
        var selectedValue = $(this).val();
        $.LoadingOverlay("show")

        if (selectedValue === 'regular') {
            fetchData(selectedValue);
        } else if (selectedValue === 'transfer') {
            fetchData(selectedValue);
        } else if (selectedValue.startsWith('type_')) {
            var studentTypeId = selectedValue.substr(5);
            fetchData('type_' + studentTypeId);
        } else if (selectedValue.startsWith('class_')) {
            var classId = selectedValue.substr(6);
            fetchData('class_' + classId);
        }
    });
    
    function fetchData(value) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '{{ route('invoices.sort') }}',
            data: {
                value: value
            },
            success: function(response) {
               $('.invoices_table').html(response.data);
               $('.pagination').html(response.pagination);
               $.LoadingOverlay("hide")

            },
            error: function(xhr, status, error) {
                // Handle the error if any
                console.error(error);
            }
        });
    }
});



</script>



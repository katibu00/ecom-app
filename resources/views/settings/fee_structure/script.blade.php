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
                url: "{{ route('settings.fee_structure.index') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.status == 201) {
                        $('.table').load(location.href + ' .table');
                        $('#addModal').modal('hide');
                        $('#create_data_form')[0].reset();
                        Command: toastr["success"](response.message)


                        $('#submit_btn').text("Submit");
                        $('#submit_btn').attr("disabled", false);
                    }
                    if (response.status == 400) {
                        Command: toastr["error"](response.message)

                        $('#submit_btn').text("Submit");
                        $('#submit_btn').attr("disabled", false);
                    }
                }
            });

        });

        //delete item
        $(document).on('click', '.deleteItem', function(e) {
            e.preventDefault();
            let id = $(this).data('row_id');
            let name = $(this).data('name');
            swal({
                    title: "Unassign " + name + "?",
                    text: "You may instead make the fee inactive to restore it later!",
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
                            url: "{{ route('settings.fee_structure.delete') }}",
                            method: 'POST',
                            data: {
                                id: id,
                            },
                            success: function(res) {
                                if (res.status == 200) {
                                    swal('Unassigned', res.message, "success");
                                    $('.table').load(location.href + ' .table');
                                }
                            }
                        });
                    }
                });
        });
        // Fee details item
        $(document).on('click', '.feeDetails', function() {
            let name = $(this).data('name');
            let class_id = $(this).data('class_id');
            let std_type = $(this).data('std_type');
            let term = $(this).data('term');
            

            $("#modalTitle").html('Fee Details: ' + name + ' - ' + std_type + ' (' + term +
                ' Term)');


            var html = '';
            $("#feeList").html(html);

            $("#loadingDiv").removeClass("d-none");
            $("#contentDiv").addClass("d-none");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('settings.fee_structure.details') }}",
                data: {
                    'class_id': class_id,
                    'std_type': std_type,
                    'term': term
                },
                dataType: "json",
                success: function(res) {
                    if (res.status == 400) {
                        Command: toastr["error"]("Check your input and try again.");
                        return;
                    }

                    $("#loadingDiv").addClass("d-none");
                    $("#contentDiv").removeClass("d-none");

                    var html = '';
                    var totalAmount = 0;
                    $.each(res.fees, function(key, fee) {
                        var priorityText = '';
                        if (fee.priority === 'm') {
                            priorityText = 'Mandatory';
                        } else if (fee.priority === 'o') {
                            priorityText = 'Optional';
                        } else if (fee.priority === 'r') {
                            priorityText = 'Recommended';
                        }

                        html +=
                            '<tr>' +
                            '<td>' + fee.fee_category.name + '</td>' +
                            '<td>' + fee.amount.toLocaleString('en-US') + '</td>' +
                            '<td>' + priorityText + '</td>' +
                            '</tr>';
                        totalAmount += fee.amount;
                    });

                    html +=
                        '<tr class="text-center">' +
                        '<td colspan="2"><strong>Total Amount</strong></td>' +
                        '<td><strong>' + '&#8358;' + totalAmount.toLocaleString('en-US') +
                        '<strong></td>' +
                        '</tr>';

                    $("#feeList").html(html);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    if (xhr.status === 419) {
                        Command: toastr["error"]("Session expired. Please login again.");
                        setTimeout(function() {
                            window.location.replace('{{ route('login') }}');
                        }, 2000);
                    }
                },
            });
        });

        //edit item
        $(document).on('click', '.editItem', function() {
            let amount = $(this).data('amount');
            let id = $(this).data('row_id');
            let status = $(this).data('status');
            let priority = $(this).data('priority');
            if (status == 1) {
                $("#status").prop("checked", true);
            }
            $('#edit_amount').val(amount);
            $('#edit_priority').val(priority);
            $('#update_row_id').val(id);
            $('#edit_priority').trigger('change');
        });


        //update data
        $(document).on('click', '#update_btn', function(e) {
            e.preventDefault();
            amount = $('#edit_amount').val();
            id = $('#update_row_id').val();
            priority = $('#edit_priority').val();

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
                url: "{{ route('settings.fee_structure.update') }}",
                data: {
                    'amount': amount,
                    'priority': priority,
                    'id': id,
                    status: $("#status").prop("checked") == true ? 1 : 0,
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
        // Add Row
        $(document).on('click', '.addeventmore', function() {
            var html = `
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <select class="form-select form-select-sm" name="fee_category_id[]" required>
                            <option value=""></option>
                            @foreach ($fees as $fee)
                                <option value="{{ $fee->id }}">{{ $fee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="number" class="form-control form-control-sm" name="amount[]" placeholder="Amount" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select class="form-select form-select-sm" name="priority[]" required>
                            <option value=""></option>
                            <option value="m">Mandatory</option>
                            <option value="r">Recommended</option>
                            <option value="o">Optional</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="button" class="btn btn-success btn-sm addeventmore"><i class="ti ti-plus"></i></button>
                        <button type="button" class="btn btn-danger btn-sm removeeventmore"><i class="ti ti-minus"></i></button>
                    </div>
                </div>
            `;
            $('.whole_extra_item_add').append(html);
        });

        // Remove Row
        $(document).on('click', '.removeeventmore', function() {
            $(this).closest('.row').remove();
        });
    });
</script>



<script>
    $(document).ready(function() {


        // Handle term change event
        $('#termSelect').on('change', function() {
            var term = $(this).val();
            var url = "{{ route('settings.fee_structure.change_term') }}";
            $.LoadingOverlay("show");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    term: term
                },
                success: function(response) {
                    $('#feeTable').html(response);
                    $.LoadingOverlay("hide");
                },
                error: function(xhr, status, error) {

                }
            });
        });




        $(document).on('click', '.copyItem', function() {
            var classId = $(this).data('class_id');
            var className = $(this).data('name');
            var term = $(this).data('term');
            var studentType = $(this).data('std_type');

            // Set the data attributes on the modal
            $('#copyModal').data('class_id', classId);
            $('#copyModal').data('name', className);
            $('#copyModal').data('term', term);
            $('#copyModal').data('std_type', studentType);

            // Set the modal title dynamically
            $('#copyModalLabel').text('Copy Fee Structure for ' + className);

            // Show the copy modal
            $('#copyModal').modal('show');
        });

        $(document).on('click', '#confirmCopy', function() {

            var classId = $('#copyModal').data('class_id');
            var className = $('#copyModal').data('name');
            var term = $('#copyModal').data('term');
            var studentType = $('#copyModal').data('std_type');

            $(this).addClass('spinner spinner-white spinner-right').prop('disabled', true);

            // Get the selected values from the form
            var copyToClass = $('#copyToClass').val();
            var copyStudentType = $('#copyStudentType').val();
            var copyTerm = $('#copyTerm').val();

            // Prepare the data to send to the backend
            var data = {
                class_id: classId,
                class_name: className,
                term: term,
                student_type: studentType,
                copy_to_class: copyToClass,
                copy_student_type: copyStudentType,
                copy_term: copyTerm
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ route('settings.fee_structure.copy') }}',
                type: 'POST',
                data: data,
                success: function(response) {
                   
                    $('#copyModal').modal('hide');
                    toastr.success(response.message);
                    location.reload();
                   
                },
                complete: function() {
                    $('#confirmCopy').removeClass('disabled').prop('disabled', false).html('Copy');
                },
                error: function(xhr, status, error) {
                    
                },
            });
        });



    });
</script>

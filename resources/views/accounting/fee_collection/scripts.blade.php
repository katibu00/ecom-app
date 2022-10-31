<script type="text/javascript">
    $(function() {

        //onchange class
        $(document).on('change', '#class_id', function() {

            const class_id = $('#class_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('get-invoices') }}',
                data: {
                    'class_id': class_id,
                },
                success: function(res) {
                    var html = '<option value="">Select Student</option>';
                    $.each(res.invoices, function(key, invoice) {
                        html += '<option value="' + invoice.id + '">' + invoice.student.first_name + ' ' + invoice.student.middle_name + ' ' + invoice.student.last_name + ' - #'+invoice.number +' '+invoice.discount+ '</option>';
                    });
                    html = $('#invoice_id').html(html);
                }
            });

        });

        //on change invoice
        $(document).on('change', '#invoice_id', function() {

            var class_id = $('#class_id').val();
            var invoice_id = $('#invoice_id').val();
           
            $('#sidebar').removeClass('d-none');
            $('#bottom_bar').removeClass('d-none'); 

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('get-fees') }}',
                data: {
                    'class_id': class_id,
                    'invoice_id': invoice_id,
                },
                success: function(res) {
                    var html = '';
                    $.each(res.mandatories, function(key, mandatory) {
                        html += '<div class="form-check custom-checkbox mb-0">' +
                                    '<input type="checkbox" class="form-check-input" checked disabled>'+
                                    '<label class="form-check-label" for="same-address">'+ mandatory.fee_category.name+' - Mandatory - '+ mandatory.amount +'</label>'+
                                '</div>';
                                            
                    });
                    $.each(res.recommededs, function(key, recommeded) {
                        html += '<div class="form-check custom-checkbox mb-0">' +
                                    '<input type="checkbox" class="form-check-input optional_fee" name="additional_fee" value="'+recommeded.id+'" data-amount="'+recommeded.amount+'">'+
                                    '<label class="form-check-label" for="same-address">'+ recommeded.fee_category.name+' - Recommeded - '+ recommeded.amount +'</label>'+
                                '</div>';
                                            
                    });
                    $.each(res.optionals, function(key, optional) {
                        html += '<div class="form-check custom-checkbox mb-0">' +
                                    '<input type="checkbox" class="form-check-input optional_fee" name="additional_fee" value="'+optional.id+'" data-amount="'+optional.amount+'" >'+
                                    '<label class="form-check-label" for="same-address">'+ optional.fee_category.name+' - Optional - '+ optional.amount +'</label>'+
                                '</div>';
                     });
                     if(res.additionals.length > 1)
                     {
                        $.each(res.additionals, function(key, additional) {
                        html += '<div class="form-check custom-checkbox mb-0">' +
                                    '<input type="checkbox" class="form-check-input optional_fee" checked disabled name="additional_fee" value="'+additional.id+'" data-amount="'+additional.amount+'" >'+
                                    '<label class="form-check-label" for="same-address">'+ additional.fee_category.name+' - Optional - '+ additional.amount +'</label>'+
                                '</div>';
                                            
                         });
                     }
                    
                    html = $('#mandatory_fees').html(html);
                    $('.payable').html(res.mandatory_sum);
                    $('#total_invoice').html(res.total_invoice);
                    $('#hidden_payable').val(res.mandatory_sum);
                    $('.discount').html(res.invoice_discount);
                    $('#hidden_discount').val(res.invoice_discount);
                    $('.modal-title').html('New Record For '+res.student.first_name+' '+res.student.middle_name+' '+res.student.last_name);
                    if(res.initial == 'yes'){
                        $('#btn_div').removeClass('d-none');
                        $('#table_div').addClass('d-none');
                        $('#add_record_div').addClass('d-none');
                        $('#initialize_btn').html('Initialize Record');  
                        $('#initialize_btn').attr('disabled', false); 
                    }
                    if(res.initial == 'no'){
                        $('#btn_div').addClass('d-none');
                        $('#add_record_div').removeClass('d-none');

                        if(res.all_payments.length > 0)
                        {
                            var table = '';
                            $.each(res.all_payments, function(key, payment) {
                                var url = '{{ route("admin.generate.receipt", ":id")}}';
                                url = url.replace(':id',payment.id);
                                table += '<tr>'+
                                        '<td>'+(key+1)+'</td>'+
                                        '<td>'+payment.paid_amount+'</td>'+
                                        '<td>'+payment.description+'</td>'+
                                        '<td><a href="'+url+'" class="btn btn-success" target="__blank">Receipt</a></td>'+
                                        '</tr>'
                            });
                             $('#recent_payments_tbl').html(table);
                             $('#table_div').removeClass('d-none');
                        }else
                        {
                            $('#recent_payments_tbl').html("No Records");
                             $('#table_div').removeClass('d-none');
                        }
                    }
                }
            });

        });

        //on click optional fees
        $(document).on('click', '.optional_fee', function(e) {

            let amount = $(this).data('amount');
            total_amount =  $('#hidden_payable').val();
            balance =  $('#hidden_balance').val();
            var discount =  $('#hidden_discount').val();
            if(discount === ''){
                discount = 0;
            }

            if ($(this).is(':checked')) {

               
                $('.payable').html(parseInt(amount) + parseInt(total_amount));
                $('#hidden_payable').val(parseInt(amount) + parseInt(total_amount));
                $('#hidden_balance').val(parseInt(amount) + parseInt(total_amount) - parseInt(balance));
                $('.balance').html(parseInt(amount) + parseInt(total_amount) - parseInt(discount));
              

            }else{
                
                $('.payable').html(parseInt(total_amount) - parseInt(amount));
                $('#hidden_payable').val(parseInt(total_amount) - parseInt(amount));
                $('#hidden_balance').val(parseInt(amount) - parseInt(total_amount));
                $('.balance').html((parseInt(total_amount) - parseInt(amount)) - parseInt(discount))
               
            }

        });

          //initialize payments
        $(document).on('submit', '#payment_form', function(e) {
            e.preventDefault();

            spinner =
                '<div class="spinner-border" style="height: 20px; width: 20px;" role="status"><span class="sr-only">Loading...</span></div> Initializing Payment . . .'
            $('#initialize_btn').html(spinner);
            $('#initialize_btn').attr("disabled", true);
           

            var additional = []
            $("input:checkbox[name=additional_fee]:checked").each(function(){
                additional.push($(this).val());
            });

            
            data = {
                'class_id': $('#class_id').val(),
                'invoice_id': $('#invoice_id').val(),
                'total_amount': $('#hidden_payable').val(),
                'discount': $('#hidden_discount').val(),
                'additional':additional,
            }
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('initialize-payment') }}",
                data: data,
               
                success: function(res) {

                   if(res.status === 200){

                    Command: toastr["success"](res.message);
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
                        $('#btn_div').addClass('d-none');
                        $('#add_record_div').removeClass('d-none');
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

        //add payments records
        $(document).on('submit', '#add_payment_form', function(e) {
            e.preventDefault();

            paid_amount = $('#add_payment_amount').val();
            description = $('#description').val();

            if(paid_amount == '' || description == '' ){
                Command: toastr["error"]('All input fields are required');
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
                return;
            }

            spinner =
                '<div class="spinner-border" style="height: 20px; width: 20px;" role="status"><span class="sr-only">Loading...</span></div> Initializing Payment . . .'
            $('#add_record_btn').html(spinner);
            $('#add_record_btn').attr("disabled", true);
            
            data = {
                'invoice_id': $('#invoice_id').val(),
                'paid_amount': paid_amount,
                'description': description,   
            }
          
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('record-payment') }}",
                data: data,
                success: function(res) {
                   if(res.status === 200){
                    Command: toastr["success"](res.message);
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
                        $('#add_record_btn').html('Add Record');
                        $('#add_record_btn').attr("disabled", false);
                        $('#add_payment_amount').val("");
                        $('#description').val("");
                        $('.add_record_modal').modal('hide');
                        // $('.table').load(location.href+' .table');
                        updateTable();
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

        //type amount paid
        $("#add_payment_amount").keyup(function () {

            payment_amount = $('#add_payment_amount').val();

            total_amount =  $('#hidden_payable').val();
            balance =  $('#hidden_balance').val();
            var discount =  $('#hidden_discount').val();
            if(discount === ''){
                discount = 0;
            }

            $('.balance').html(parseInt(total_amount) - parseInt(payment_amount) - parseInt(discount));

        });

        //update table
        function updateTable()
        {
            
            data = {
                'invoice_id':$('#invoice_id').val(),
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('refresh-table') }}",
                data: data,
                success: function(res) {
                  
                    var table = '';
                    $.each(res.all_payments, function(key, payment) {
                        table += '<tr>'+
                                '<td>'+(key+1)+'</td>'+
                                '<td>'+payment.paid_amount+'</td>'+
                                '<td>'+payment.description+'</td>'+
                                '</tr>'
                    });
                        $('#recent_payments_tbl').html(table);
                        $('#table_div').removeClass('d-none');
                        
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
        }

    });
</script>
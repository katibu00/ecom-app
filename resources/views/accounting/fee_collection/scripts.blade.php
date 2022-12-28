<script type="text/javascript">
    $(function() {

        //onchange class
        $(document).on('change', '#class_id', function() {

            const class_id = $('#class_id').val();
            $('#invoice_id').html('<option value="">Loading...</option>');

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
                        var middle =  invoice.student.middle_name;
                        if(middle === null){
                            middle = '';
                        }
                        html += '<option value="' + invoice.id + '">' + '#'+invoice.number+' - '+invoice.student.first_name + ' ' + middle + ' ' + invoice.student.last_name+ '</option>';
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
            $('#total_paid_li').addClass('d-none');
            $('#discounted_amount_li').addClass('d-none');
            $('.balance').html('');
            $('.discount').html('')
            $('#hidden_modal_balance').val(0);
            $('#add_payment_amount').val('');
            $('#bbf').html('');
            $('#hidden_discount').val(0);

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
                                    '<label class="form-check-label" for="same-address">'+ mandatory.fee_category.name+' - Mandatory - '+ mandatory.amount.toLocaleString() +'</label>'+
                                '</div>';
                                            
                    });
                    $.each(res.recommededs, function(key, recommeded) {
                        html += '<div class="form-check custom-checkbox mb-0">' +
                                    '<input type="checkbox" class="form-check-input optional_fee" name="additional_fee" value="'+recommeded.id+'" data-amount="'+recommeded.amount+'">'+
                                    '<label class="form-check-label" for="same-address">'+ recommeded.fee_category.name+' - Recommeded - '+ recommeded.amount.toLocaleString() +'</label>'+
                                '</div>';
                                            
                    });
                    $.each(res.optionals, function(key, optional) {
                        html += '<div class="form-check custom-checkbox mb-0">' +
                                    '<input type="checkbox" class="form-check-input optional_fee" name="additional_fee" value="'+optional.id+'" data-amount="'+optional.amount+'" >'+
                                    '<label class="form-check-label" for="same-address">'+ optional.fee_category.name+' - Optional - '+ optional.amount.toLocaleString() +'</label>'+
                                '</div>';
                     });
                     if(res.additionals.length >= 1)
                     {
                        $.each(res.additionals, function(key, additional) {
                        html += '<div class="form-check custom-checkbox mb-0">' +
                                    '<input type="checkbox" class="form-check-input optional_fee" checked disabled name="additional_fee" value="'+additional.id+'" data-amount="'+additional.amount+'" >'+
                                    '<label class="form-check-label" for="same-address">'+ additional.fee_category.name+' - Optional - '+ additional.amount.toLocaleString() +'</label>'+
                                '</div>';
                                            
                         });
                     }
                    
                    html = $('#mandatory_fees').html(html);
                    $('.payable').html('&#8358;'+res.mandatory_sum.toLocaleString());
                    $('#total_invoice').html('&#8358;'+res.total_invoice.toLocaleString());
                    if(res.bbf !== null)
                    {
                        $('#bbf').html('&#8358;'+res.bbf.toLocaleString());
                    }else{
                        $('#bbf').html('');
                    }
                    $('#hidden_payable').val(res.mandatory_sum);
                    if(res.invoice_discount > 0)
                    {
                        $('.discount').html('&#8358;'+res.invoice_discount.toLocaleString());
                    }else
                    {
                        $('.discount').html('')
                    }

                    if(res.balance > 0)
                    {
                        $('.balance').html('&#8358;'+res.balance.toLocaleString());
                        $('.modal_balance').html('&#8358;'+res.balance.toLocaleString());
                    }else
                    {
                        $('.balance').html('');
                        $('.modal_balance').html('');
                    }
                   
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
                        $('#total_paid_li').removeClass('d-none');
                        $('#discounted_amount_li').removeClass('d-none');
                        $('.total_paid').html('&#8358;'+res.total_paid.toLocaleString());
                        $('.discounted_amount').html('&#8358;'+res.discounted_amount.toLocaleString());
                        $('#hidden_modal_balance').val(res.balance);
                        $('.payable').html('&#8358;'+res.total_payable.toLocaleString());
                        if(res.all_payments.length > 0)
                        {
                            var table = '';
                            $.each(res.all_payments, function(key, payment) {
                                var url = '{{ route("admin.generate.receipt", ":id")}}';
                                url = url.replace(':id',payment.id);
                                table += '<tr>'+
                                        '<td>'+(key+1)+'</td>'+
                                        '<td>&#8358;'+payment.paid_amount.toLocaleString()+'</td>'+
                                        '<td>'+payment.description+'</td>'+
                                        '<td><a href="'+url+'" class="btn btn-success" target="__blank"><i class="ti ti-printer me-2"></i></a></td>'+
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

               
                $('.payable').html('&#8358;'+(parseInt(amount) + parseInt(total_amount)).toLocaleString());
                $('#hidden_payable').val(parseInt(amount) + parseInt(total_amount));
                $('#hidden_balance').val(parseInt(amount) + parseInt(total_amount) - parseInt(balance));
                $('.balance').html('&#8358;'+(parseInt(amount) + parseInt(total_amount) - parseInt(discount)).toLocaleString());
              

            }else{
                
                $('.payable').html('&#8358;'+(parseInt(total_amount) - parseInt(amount)).toLocaleString());
                $('#hidden_payable').val(parseInt(total_amount) - parseInt(amount));
                $('#hidden_balance').val(parseInt(amount) - parseInt(total_amount));
                $('.balance').html('&#8358;'+((parseInt(total_amount) - parseInt(amount)) - parseInt(discount)).toLocaleString())
               
            }

        });

          //initialize payments
        $(document).on('submit', '#payment_form', function(e) {
            e.preventDefault();

            spinner =
                '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div>&nbsp; Initializing Payment . . .'
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
                        window.location.replace('{{ route('fee_collection.index') }}');
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
            method = $(".method:checked").val();

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
                '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div>&nbsp; Recording Payment . . .'
            $('#add_record_btn').html(spinner);
            $('#add_record_btn').attr("disabled", true);
            
            data = {
                'invoice_id': $('#invoice_id').val(),
                'paid_amount': paid_amount,
                'description': description,   
                'method': method,   
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

           const balance = $('#hidden_modal_balance').val();
           var payment_amount = $('#add_payment_amount').val();
            if(payment_amount === '')
            {
                payment_amount = 0;
            }

            $('.modal_balance').html('&#8358;'+(parseInt(balance) - parseInt(payment_amount)).toLocaleString());

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
                        var url = '{{ route("admin.generate.receipt", ":id")}}';
                        url = url.replace(':id',payment.id);
                        table += '<tr>'+
                                '<td>'+(key+1)+'</td>'+
                                '<td>&#8358;'+payment.paid_amount.toLocaleString()+'</td>'+
                                '<td>'+payment.description+'</td>'+
                                '<td><a href="'+url+'" class="btn btn-success" target="__blank"><i class="ti ti-printer me-2"></i></a></td>'+
                                '</tr>'
                         });
                        $('#recent_payments_tbl').html(table);
                        $('#table_div').removeClass('d-none');
                        $('.total_paid').html('&#8358;'+res.total_paid.toLocaleString());
                        $('.balance').html('&#8358;'+res.balance.toLocaleString());
                        $('.modal_balance').html('&#8358;'+res.balance.toLocaleString());
                        $('#hidden_modal_balance').val(res.balance);
                        
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
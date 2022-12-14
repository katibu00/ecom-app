<script>
    $(document).ready(function() {

       

        //store comments
        $(document).on('submit', '#data_form', function(e) {
            e.preventDefault();

            let formData = new FormData($('#data_form')[0]);

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
                url: "{{ route('psychomotor.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.status == 200) {
                        $('.table').load(location.href + ' .table');
                        $('#addModal').modal('hide');
                        $('#comments_form')[0].reset();
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

                        $('#submit_btn').text("Submit");
                        $('#submit_btn').attr("disabled", false);
                    }
                    if (response.status == 404) {
                        $('#data_form')[0].reset();
                        Command: toastr["error"](response.message)
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
                        $('#submit_btn').text("Submit");
                        $('#submit_btn').attr("disabled", false);
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

        //view comments click modal
        $(document).on('click', '.viewDetails', function() {
           
           let class_id = $(this).data('class_id');
           let class_name = $(this).data('class_name');
           $('.viewTitle').html('Fetch Comments for Class '+class_name);
           $('#view_class_id').val(class_id);
           $('#loading_div').addClass('d-none');
                        $('#content_div').addClass('d-none');
                        html = $('#comments-generate-tr').html(null);

       });

        //view comments change select
        $(document).on('change', '#view_officer', function() {
           
           let class_id = $('#view_class_id').val();
           let officer = $('#view_officer').val();
           

           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('comments.view') }}",
                data: {'class_id':class_id, 'officer':officer},
                beforeSend: function(){
                    $('#loading_div').removeClass('d-none');
                    $('#content_div').addClass('d-none');
                    html = $('#comments-generate-tr').html(null);
                },
                success: function(data){

                    if(!$.trim(data)){
                       
                        
                        Command: toastr["error"](
                            "No Comment has been Entered for the Selected Class/officer."
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
                        $('#loading_div').addClass('d-none');
                        $('#content_div').addClass('d-none');
                        html = $('#comments-generate-tr').html(null);
                        
                        return;
                    }

                
                    var html = '';
                    $.each( data, function(key, v){

                        html +=
                        '<tr>'+
                        '<td>'+(key+1)+'</td>'+
                        '<td>'+v.student.login+'</td>'+
                        '<td>'+v.student.first_name+' '+v.student.middle_name+' '+v.student.last_name+'</td>'+
                        '<td>'+v.comment+' '+v.additional+'</td>'+
                        '</tr>';
                    });
                    html = $('#comments-generate-tr').html(html);
                    $('#loading_div').addClass('d-none');
                    $('#content_div').removeClass('d-none');
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



    });
</script>


<script type="text/javascript">
    $(function() {
        $(document).on('submit', '#search_form', function(e) {
            e.preventDefault();


            var class_id = $('#class_id').val();
            var type = $('#type').val();
            $('#send_class_id').val(class_id);
            $('#send_type').val(type);

            if (class_id == '' || type == '') {
                Command: toastr["error"]("All fields are required")
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
                return;
            }


            if (type == 'psychomotor') {

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
                    type: 'POST',
                    url: '{{ route('psychomotor.get') }}',
                    data: {
                        'class_id': class_id
                    },
                    success: function(res) {


                        $('#marks-generate').removeClass('d-none');

                        var head = '';
                        head +=  '<tr>' 
                        head +=   '<th>Name</th>' 
                        head +=  '<th>Pos</th>'
                        head +=  '<th>Marks</th>'  
                        
                        $.each(res.grades, function(key, grade) {
                            head +=  '<th>' + grade.name + '</th>'    
                        });
                        head += '</tr>';
                        head = $('#table-head').html(head);

                        var html = '';

                        $.each(res.students, function(key, v) {

                       
                            html += '<tr>';

                            html += '<td>' + v.student.first_name + ' ' + v.student  .middle_name + ' ' + v.student.last_name +'</td>';
                            html += '<td>' + (key + 1) + '</td>';
                            html += '<td>' + v.total + '</td>';

                                $.each(res.grades, function(key, grade) {
                                   
                                    html +=  '<td> <select name="score[]" class="form-control form-control-sm bg-whit" >';
                                        html += '<option value=""></option> <option value="5">5</option>';
                                        html += '<option value="4">4</option>';
                                        html +=  '<option value="3">3</option>';
                                        html +='<option value="2">2</option>';
                                        html += '<option value="1">1</option></select></td>';
                                        html += '<input type="hidden" name="grade_id[]" value="'+grade.id+'" />'
                                        html += '<input type="hidden" name="student_id[]" value="'+v.student.id+'" />'
                                });
                               

                                html +='</tr>';
                        });
                        html = $('#marks-generate-tr').html(html);

                        $('#search_btn').html("Fetch Record");
                        $('#search_btn').attr("disabled", false);

                    }
                });


            } else if (type == 'affective') {

                $.ajax({
                    type: 'GET',
                    url: '{{ route('psychomotor.get') }}',
                    data: {
                        'class_id': class_id,
                        'class_section_id': class_section_id
                    },
                    success: function(data) {

                        if (!$.trim(data)) {
                            alert(
                                "Generate End of Term Report First for the Selected Class"
                            );
                            return;
                        }

                        $('#marks-generate').removeClass('d-none');

                        var html = '';
                        var head = '';

                        head += '<tr>' +
                            '<th>Name</th>' +
                            '<th>Pos</th>' +
                            '<th>Marks</th>' +
                            '<th>Puntuality</th>' +
                            '<th>Neatness</th>' +
                            '<th>Politeness</th>' +
                            '<th>Honesty</th>' +
                            '<th>Cooperation</th>' +
                            '<th>Leadership</th>' +
                            '<th>Emotional Stability</th>' +
                            '<th>Health</th>' +
                            '<th>attitude to <br/>school work</th>' +
                            '<th>Attentiveness</th>' +
                            '<th>Perseverance</th>' +
                            '<th>Speaking/Handwriting</th>' +
                            '<th></th>' +

                            '</tr>';
                        head = $('#table-head').html(head);

                        $.each(data, function(key, v) {

                            html +=
                                '<tr>' +


                                '<td>' + v.user.first_name + ' ' + v.user
                                .middle_name + ' ' + v.user.last_name +
                                '<input type="hidden" name="user_id[]" value="' + v
                                .user.id +
                                '"><input type="hidden" name="classss_id[]" value="' +
                                v.user.class_id +
                                '"><input type="hidden" name="classss_section_id[]" value="' +
                                v.user.class_section_id + '"></td>' +
                                '<td>' + (key + 1) + '</td>' +
                                '<td>' + v.total + '</td>' +
                                '<td> <select name="puntuality[]" class="form-control form-control-sm bg-whit" required>' +
                                '<option value=""></option> <option value="5">5</option>' +
                                '<option value="4">4</option>' +
                                '<option value="3">3</option>' +
                                '<option value="2">2</option>' +
                                '<option value="1">1</option></select></td>' +
                                '<td> <select name="neatness[]" class="form-control form-control-sm bg-whit" required>' +
                                '<option value=""></option> <option value="5">5</option>' +
                                '<option value="4">4</option>' +
                                '<option value="3">3</option>' +
                                '<option value="2">2</option>' +
                                '<option value="1">1</option></select></td>' +
                                '<td> <select name="politeness[]" class="form-control form-control-sm bg-whit" required>' +
                                '<option value=""></option> <option value="5">5</option>' +
                                '<option value="4">4</option>' +
                                '<option value="3">3</option>' +
                                '<option value="2">2</option>' +
                                '<option value="1">1</option></select></td>' +
                                '<td> <select name="honesty[]" class="form-control form-control-sm bg-whit" required>' +
                                '<option value=""></option> <option value="5">5</option>' +
                                '<option value="4">4</option>' +
                                '<option value="3">3</option>' +
                                '<option value="2">2</option>' +
                                '<option value="1">1</option></select></td>' +
                                '<td> <select name="cooperation[]" class="form-control form-control-sm bg-whit" required>' +
                                '<option value=""></option> <option value="5">5</option>' +
                                '<option value="4">4</option>' +
                                '<option value="3">3</option>' +
                                '<option value="2">2</option>' +
                                '<option value="1">1</option></select></td>' +
                                '<td> <select name="leadership[]" class="form-control form-control-sm bg-whit" required>' +
                                '<option value=""></option> <option value="5">5</option>' +
                                '<option value="4">4</option>' +
                                '<option value="3">3</option>' +
                                '<option value="2">2</option>' +
                                '<option value="1">1</option></select></td>' +
                                '<td> <select name="emotional[]" class="form-control form-control-sm bg-whit" required>' +
                                '<option value=""></option> <option value="5">5</option>' +
                                '<option value="4">4</option>' +
                                '<option value="3">3</option>' +
                                '<option value="2">2</option>' +
                                '<option value="1">1</option></select></td>' +
                                '<td> <select name="health[]" class="form-control form-control-sm bg-whit" required>' +
                                '<option value=""></option> <option value="5">5</option>' +
                                '<option value="4">4</option>' +
                                '<option value="3">3</option>' +
                                '<option value="2">2</option>' +
                                '<option value="1">1</option></select></td>' +
                                '<td> <select name="attitude[]" class="form-control form-control-sm bg-whit" required>' +
                                '<option value=""></option> <option value="5">5</option>' +
                                '<option value="4">4</option>' +
                                '<option value="3">3</option>' +
                                '<option value="2">2</option>' +
                                '<option value="1">1</option></select></td>' +
                                '<td> <select name="attentiveness[]" class="form-control form-control-sm bg-whit" required>' +
                                '<option value=""></option> <option value="5">5</option>' +
                                '<option value="4">4</option>' +
                                '<option value="3">3</option>' +
                                '<option value="2">2</option>' +
                                '<option value="1">1</option></select></td>' +
                                '<td> <select name="perseverance[]" class="form-control form-control-sm bg-whit" required>' +
                                '<option value=""></option> <option value="5">5</option>' +
                                '<option value="4">4</option>' +
                                '<option value="3">3</option>' +
                                '<option value="2">2</option>' +
                                '<option value="1">1</option></select></td>' +
                                '<td> <select name="speaking[]" class="form-control form-control-sm bg-whit" required>' +
                                '<option value=""></option> <option value="5">5</option>' +
                                '<option value="4">4</option>' +
                                '<option value="3">3</option>' +
                                '<option value="2">2</option>' +
                                '<option value="1">1</option></select></td>' +


                                '</tr>';
                        });
                        html = $('#marks-generate-tr').html(html);


                    }
                });

            };


        });
    });
</script>

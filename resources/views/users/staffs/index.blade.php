@extends('layouts.app')

@section('PageTitle', 'Staffs')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex flex-wrap mb-2 mb-md-0">
                                <a href="#" class="btn btn-primary me-2 mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#addStaffModal">Add New Staff(s)</a>
                                <a href="#" class="btn btn-secondary me-2 mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#importExcelModal">Import from Excel</a>
                                <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#shareLinkModal">Share Signup Links</a>
                            </div>
                            <div class="d-flex align-items-center">
                                <select class="form-select me-2 mb-2 mb-md-0" id="bulk-actions">
                                    <option selected>Bulk Action</option>
                                    <option>Delete Users</option>
                                    <option>Deactivate Users</option>
                                    <option>Activate Users</option>
                                </select>
                                {{-- <select class="form-select me-2" id="sort">
                                    <option selected>Sort by</option>
                                    <option value="Admin">Admins</option>
                                    <option value="Teacher">Teachers</option>
                                    <option value="Accountant">Accountants</option>
                                    <option value="Proprietor">Proprietors</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select> --}}
                                <input type="text" id="searchInput" class="form-control" placeholder="Search">
                            </div>
                        </div>
                        <div class="table-responsive">
                          @include('users.staffs.table')
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Excel Modal -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importExcelModalLabel">Import from Excel</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Do you want to download a sample template or upload your own?</p>
                    <a href="#" class="btn btn-info">Download Sample Template</a>
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="excelFile" class="form-label">Upload Excel File</label>
                            <input type="file" class="form-control" id="excelFile" name="excelFile">
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Share Link Modal -->
    <div class="modal fade" id="shareLinkModal" tabindex="-1" aria-labelledby="shareLinkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareLinkModalLabel">Share Signup Links</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Share this signup link with teachers and other staff members:</p>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" value="http://example.com/signup" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="copyButton">Copy</button>
                    </div>
                    <p>Instructions: To sign up, simply click on the link or copy and paste it in your browser's address bar. Follow the on-screen instructions to complete the signup process.</p>
                </div>
            </div>
        </div>
    </div>

     <!-- Add Staff Modal -->
     <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="addStaffForm" method="post" action="{{ route('users.staffs.store') }}">
                    @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addStaffModalLabel">Add New Staff(s)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="errorContainer" class="alert alert-danger" style="display: none;"></div>

                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email/Phone</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="staffTableBody">
                            <tr>
                                <td>
                                    <select class="form-select" name="staff_title[]">
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Mall.">Mall.</option>
                                        <option value="Alh.">Alh.</option>
                                        <option value="Pastor">Pastor</option>
                                        <option value="Rev.">Rev.</option>
                                        <option value="Prof.">Prof.</option>
                                        <option value="Dr.">Dr.</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="staff_first_name[]"></td>
                                <td><input type="text" class="form-control" name="staff_last_name[]"></td>
                                <td><input type="text" class="form-control" name="staff_email_phone[]"></td>
                                <td>
                                    <select class="form-select" name="staff_role[]">
                                        <option value="teacher">Teacher</option>
                                        <option value="proprietor">Proprietor</option>
                                        <option value="non-teaching">Non Teaching Staff</option>
                                        <option value="accountant">Accountant</option>
                                        <option value="admin">Administrator</option>
                                        <option value="director">Director</option>
                                        <!-- Add other role options here -->
                                    </select>
                                </td>
                                <td><button class="btn btn-danger btn-sm" onclick="removeStaffRow(this)">Remove</button></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <button type="button" class="btn btn-success mt-3" onclick="addStaffRow()">Add Row</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submitBtn" class="btn btn-primary">Save Staff(s)</button>
                </div>
            </form>
            </div>
        </div>
    </div>


<!-- Edit Profile Modal -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_staff_modal_title">Loading . . .</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form id="edit_staff_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="" id="edit_loading_div">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="spinner-border" style="height: 40px; width: 40px; margin: 0 auto;" role="status"></div>
                        </div>
                    </div>
                    <input type="hidden" id="edit_staff_id" name="edit_staff_id" />
                
                    <div class="profile-personal-info d-none" id="edit_content_div">
        

                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <div class="profile-img-edit">
                                    <img class="profile-pic" id="edit_staff_picture" width="150" height="150" src="/uploads/default.png" alt="staff picture">
                                    <div class="p-image">
                                    <i class="fa fa-pencil  upload-button"></i>
                                    <input class="file-upload" type="file" accept="image/*" name="image" />
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_first_name">First Name</label>
                                <input type="text" class="form-control" id="edit_first_name" value="" name="first_name" placeholder="First Name">
                            </div>
                            <div class="col-md-6 mt-2 mt-sm-0">
                                <label for="edit_last_name">Other Names</label>
                                <input type="text" class="form-control" id="edit_last_name" name="last_name" placeholder="Other Names">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_email">Email</label>
                                <input type="text" class="form-control" id="edit_email" name="email" placeholder="Email">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_roll_number">Phone Number</label>
                                <input type="text" class="form-control" id="edit_phone_number" name="phone" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 mt-2 mt-sm-0">
                                <label for="edit_usertype">Role</label>
                                <select class="form-select" name="usertype" id="edit_usertype" required>
                                    <option value=""></option>
                                    <option value="teacher">Teacher</option>
                                    <option value="admin">Administrator</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="proprietor">Proprietor</option>
                                    <option value="director">Director</option>
                                    <option value="staff">Non-teaching Staff</option>
                                </select>  
                            </div>
                            
                        </div>
                        
                    
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Dismiss</button>
                    <button type="submit" id="edit_staff_btn" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>




  
@endsection

@section('js')


<script>

$(document).on('click', '.edit_staff', function(e) {
            e.preventDefault();

            let staff_id = $(this).data('user-id');
            let staff_name = $(this).data('user-name');
            $('#edit_staff_id').val(staff_id);

            $('#edit_loading_div').removeClass('d-none');
            $('#edit_content_div').addClass('d-none');
            $('#edit_staff_form')[0].reset();
            $('#edit_usertype option:selected').removeAttr('selected');
            $('#edit_staff_modal_title').html('Edit ' + staff_name + 's Profile');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('get-staff_details') }}',
                data: {
                    'staff_id': staff_id,
                },
                success: function(res) {

                    if (res.staff.image != null) {
                        $("#edit_staff_picture").attr("src", "/uploads/" + res
                            .school_username.username + '/' + res.staff.image);
                    }

                    $('#edit_loading_div').addClass('d-none');
                    $('#edit_content_div').removeClass('d-none');
                    $('#edit_first_name').val(res.staff.first_name);
                    $('#edit_last_name').val(res.staff.last_name);
                    $('#edit_email').val(res.staff.email);
                    $('#edit_phone_number').val(res.staff.phone);
                    $(`#edit_usertype option[value="${res.staff.usertype}"]`).attr(
                        "selected", "selected");
                   



                }
            });


        });

        //edit staffs form
        $(document).on('submit', '#edit_staff_form', function(e) {
            e.preventDefault();

            let formData = new FormData($('#edit_staff_form')[0]);

            spinner =
                '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div>&nbsp; Saving . . .'
            $('#edit_staff_btn').html(spinner);
            $('#edit_staff_btn').attr("disabled", true);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "https://app.intelps.cloud/users/staffs/edit",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.status == 400) {
                        $('#error_list').html("");
                        $('#error_list').addClass('alert alert-danger');
                        $.each(response.errors, function(key, err) {
                            $('#error_list').append('<li>' + err + '</li>');
                        });
                        $('#edit_staff_btn').text("Save Changes");
                        $('#edit_staff_btn').attr("disabled", false);
                        Command: toastr["error"]("some Required Fields are not Filled")
                    }

                    if (response.status == 200) {
                        Command: toastr["success"](response.message)

                        $('#edit_staff_btn').text("Save Changes");
                        $('#edit_staff_btn').attr("disabled", false);
                        $('#editModal').modal('hide');
                        $('.table').load(location.href + ' .table');
                    }
                }
            })

        });


</script>















    <script>
        document.getElementById('copyButton').addEventListener('click', function () {
            var copyText = document.querySelector('.form-control');
            copyText.select();
            document.execCommand('copy');
            alert('Link copied to clipboard!');
        });
    </script>


<script>
    function addStaffRow() {
        var newRow = '<tr>' +
                        '<td>' +
                            '<select class="form-select" name="staff_title[]">' +
                                '<option value="Mr">Mr</option>' +
                                '<option value="Mrs">Mrs</option>' +
                                '<option value="Ms">Ms</option>' +
                                '<option value="Mall.">Mall.</option>' +
                                '<option value="Alh.">Alh.</option>' +
                                '<option value="Pastor">Pastor</option>' +
                                '<option value="Rev.">Rev.</option>' +
                                '<option value="Prof.">Prof.</option>' +
                                '<option value="Dr.">Dr.</option>' +
                            '</select>' +
                        '</td>' +
                        '<td><input type="text" class="form-control" name="staff_first_name[]"></td>' +
                        '<td><input type="text" class="form-control" name="staff_last_name[]"></td>' +
                        '<td><input type="text" class="form-control" name="staff_email_phone[]"></td>' +
                        '<td>' +
                            '<select class="form-select" name="staff_role[]">' +
                                '<option value="teacher">Teacher</option>' +
                                '<option value="proprietor">Proprietor</option>' +
                                '<option value="non-teaching">Non Teaching Staff</option>' +
                                '<option value="accountant">Accountant</option>' +
                                '<option value="admin">Administrator</option>' +
                                '<option value="director">Director</option>' +
                                <!-- Add other role options here -->
                            '</select>' +
                        '</td>' +
                        '<td><button class="btn btn-danger btn-sm" onclick="removeStaffRow(this)">Remove</button></td>' +
                     '</tr>';
        $('#staffTableBody').append(newRow);
    }

    function removeStaffRow(button) {
        $(button).closest('tr').remove();
    }


    $('#addStaffForm').submit(function(e) {
    e.preventDefault();

    // Disable the submit button
    $('#submitBtn').attr('disabled', true);
    $('#submitBtn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        success: function(response) {
            if (response.success) {
                // Clear previous errors
                $('#errorContainer').empty();

                // Refresh the table content
                $('.mainStaffTable').load(location.href + ' .mainStaffTable');
                toastr.success('Staff(s) registered successfully.');
                // Hide the modal
                $('#addStaffModal').modal('hide');
            } else {
                // Handle validation errors
                var errorList = '<ul>';
                $.each(response.errors, function (fieldName, errorMessages) {
                    if (Array.isArray(errorMessages)) {
                        $.each(errorMessages, function (index, errorMessage) {
                            errorList += '<li>' + errorMessage + '</li>';
                        });
                    } else {
                        errorList += '<li>' + errorMessages + '</li>';
                    }
                });
                errorList += '</ul>';

                // Display the error messages in the error container
                $('#errorContainer').html(errorList).show();
            }

            // Re-enable the submit button
            $('#submitBtn').attr('disabled', false);
            $('#submitBtn').html('Save Staff(s)');
        },

        error: function(xhr, status, error) {
            // Handle AJAX errors
            var errorContainer = $('#errorContainer');
            errorContainer.empty(); // Clear previous errors
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                var errors = xhr.responseJSON.errors;
                var errorList = '<ul>';
                $.each(errors, function(field, errorMessages) {
                    if (Array.isArray(errorMessages)) {
                        $.each(errorMessages, function(index, message) {
                            errorList += '<li>' + message + '</li>';
                        });
                    } else {
                        errorList += '<li>' + errorMessages + '</li>';
                    }
                });
                errorList += '</ul>';
                errorContainer.html(errorList);
                errorContainer.show(); // Show the error container
            }

            // Re-enable the submit button
            $('#submitBtn').attr('disabled', false);
            $('#submitBtn').html('Save Staff(s)');
        }
    });
});



$('.select-all-checkbox').change(function() {
        var isChecked = $(this).is(':checked');
        $('tbody input[type="checkbox"]').prop('checked', isChecked);
    });

</script>



<script>
    window.onload = function () {
        // Function to update serial numbers
        function updateSerialNumbers() {
            $('.mainStaffTable tbody tr:visible').each(function (index) {
                $(this).find('td:nth-child(2)').text(index + 1);
            });
        }

        // Function to perform search
        function performSearch() {
            var searchText = $('#searchInput').val().toLowerCase();
            var found = false;

            $('.mainStaffTable tbody tr').each(function () {
                var staffName = $(this).find('td:nth-child(3)').text().toLowerCase();
                var staffEmailPhone = $(this).find('td:nth-child(4)').text().toLowerCase();
                var staffRole = $(this).find('td:nth-child(5)').text().toLowerCase();

                if (
                    staffName.includes(searchText) ||
                    staffEmailPhone.includes(searchText) ||
                    staffRole.includes(searchText)
                ) {
                    $(this).show();
                    found = true;
                } else {
                    $(this).hide();
                }
            });

            // Toggle visibility of "No result found" row
            $('.no-results-row').toggle(!found);

            // Update serial numbers after search
            updateSerialNumbers();
        }

        // Attach input event listener
        $('#searchInput').on('input', performSearch);

        // Initial setup: update serial numbers and hide the "No result found" row
        updateSerialNumbers();
        $('.no-results-row').hide();
    };
</script>





















@endsection







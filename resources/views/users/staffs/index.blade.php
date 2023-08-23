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
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Loading...</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container"><ul id="edit_error_list"></ul></div>
            <form id="editProfileForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="loading-section" id="loadingSection">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="spinner-border" role="status"></div>
                        </div>
                    </div>
                    <input type="hidden" id="userId" name="userId" />
                    <div class="profile-section d-none" id="contentSection">
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <div class="profile-img-edit">
                                    <img class="profile-pic mb-2" id="profileImage" width="150" height="150" src="/uploads/default.png" alt="Staff Picture">
                                    <div class="p-image">
                                        <i class="fa fa-pencil upload-button"></i>
                                        <input class="file-upload" type="file" accept="image/*" name="image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name">
                            </div>
                            <div class="col-md-6 mt-2 mt-sm-0">
                                <label for="lastName">Other Names</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Other Names">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                            <div class="col-md-6">
                                <label for="phoneNumber">Phone Number</label>
                                <input type="text" class="form-control" id="phoneNumber" name="phone" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 mt-2 mt-sm-0">
                                <label for="userType">Role</label>
                                <select class="form-select" name="usertype" id="userType" required>
                                    <option value=""></option>
                                    <option value="teacher">Teacher</option>
                                    <option value="admin">Administrator</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="proprietor">Proprietor</option>
                                    <option value="director">Director</option>
                                    <option value="staff">Non-teaching Staff</option>
                                </select>  
                            </div>
                            <!-- Add other input fields here -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Dismiss</button>
                    <button type="submit" id="saveProfileBtn" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailsModalLabel">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="loading-section" id="userLoadingSection">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="spinner-border" role="status"></div>
                    </div>
                </div>
                <div class="user-details-section d-none" id="userDetailsSection">
                    <!-- Display user details here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>





  
@endsection

@section('js')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
<script>

$(document).ready(function() {
   
    $(document).on('click', '.edit-profile-btn', function(e) {
        e.preventDefault();

        let userId = $(this).data('user-id');
        let userName = $(this).data('user-name');
        $('#userId').val(userId);

        $('#edit_error_list').html("").removeClass('alert alert-danger');

        $('#loadingSection').removeClass('d-none');
        $('#contentSection').addClass('d-none');
        $('#editProfileForm')[0].reset();
        $('#userType option:selected').removeAttr('selected');
        $('#editProfileModalLabel').html(`Edit ${userName}'s Profile`);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '{{ route('get-staff_details') }}',
            data: {
                'staff_id': userId,
            },
            success: function(res) {
                if (res.staff.image != null) {
                    $("#profileImage").attr("src", "/uploads/" + res.school_username.username + '/' + res.staff.image);
                }else{
                    $("#profileImage").attr("src", "/uploads/default.png");
                }
            

                $('#loadingSection').addClass('d-none');
                $('#contentSection').removeClass('d-none');
                $('#firstName').val(res.staff.first_name);
                $('#lastName').val(res.staff.last_name);
                $('#email').val(res.staff.email);
                $('#phoneNumber').val(res.staff.phone);
                $('#userType').val(res.staff.usertype); // Assuming this is the ID of the selected option in your dropdown
                // Other fields...
            }

        });
    });

    $(document).on('submit', '#editProfileForm', function(e) {
        e.preventDefault();

        let formData = new FormData($('#editProfileForm')[0]);

        let spinner = '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div>&nbsp; Saving...';
        $('#saveProfileBtn').html(spinner);
        $('#saveProfileBtn').attr("disabled", true);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('users.staffs.edit') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 400) {
                    $('#edit_error_list').html("").addClass('alert alert-danger');
                    $.each(response.errors, function(key, err) {
                        $('#edit_error_list').append('<li>' + err + '</li>');
                    });
                    $('#saveProfileBtn').text("Save Changes").attr("disabled", false);
                    toastr["error"]("Some Required Fields are not Filled");
                } else if (response.status == 200) {
                    toastr["success"](response.message);
                    $('#saveProfileBtn').text("Save Changes").attr("disabled", false);
                    $('#editProfileModal').modal('hide');
                    $('.mainStaffTable').load(location.href + ' .mainStaffTable');
                }
            }
        });
    });

    $(document).on('click', '.view-details', function(e) {
        e.preventDefault();

        let userId = $(this).data('user-id');
        let userName = $(this).data('user-name');

        $('#userDetailsModalLabel').text('Details for ' + userName);
        $('#userLoadingSection').removeClass('d-none');
        $('#userDetailsSection').addClass('d-none');
        $('#userDetailsSection').html(''); // Clear previous user details

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '{{ route('get-staff_details') }}', 
            data: {
                'staff_id': userId,
            },
            success: function(res) {

                let userDetailsHtml = '';
                let role = res.staff.usertype || '';
                role = role.charAt(0).toUpperCase() + role.slice(1);
                userDetailsHtml += '<p><strong>First Name:</strong> ' + (res.staff.first_name || '') + '</p>';
                userDetailsHtml += '<p><strong>Last Name:</strong> ' + (res.staff.last_name || '') + '</p>';
                userDetailsHtml += '<p><strong>Email:</strong> ' + (res.staff.email || '') + '</p>';
                userDetailsHtml += '<p><strong>Phone Number:</strong> ' + (res.staff.phone || '') + '</p>';
                userDetailsHtml += '<p><strong>Role:</strong> ' + role + '</p>';

                $('#userLoadingSection').addClass('d-none');
                $('#userDetailsSection').removeClass('d-none');
                $('#userDetailsSection').html(userDetailsHtml);
            }
        });
    });



    $(document).on('click', '.delete-user', function(e) {
        e.preventDefault();

        let userId = $(this).data('user-id');
        let userName = $(this).data('user-name');

        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete ${userName}'s profile. This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ route('staffs.delete') }}', // Replace with your actual delete route
                    data: {
                        'user_id': userId,
                    },
                    success: function(response) {
                        // Handle success here, show a success message or update the UI
                        Swal.fire({
                            title: 'Deleted!',
                            text: `${userName}'s profile has been deleted.`,
                            icon: 'success'
                        });
                        $('.mainStaffTable').load(location.href + ' .mainStaffTable');
                    },
                    error: function(xhr, status, error) {
                        // Handle error here, show an error message or alert the user
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while deleting the user.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });


     //change profile picture
     var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.profile-pic').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        $(".file-upload").on('change', function() {
            readURL(this);
        });

        $(".upload-button").on('click', function() {
            $(".file-upload").click();
        });

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







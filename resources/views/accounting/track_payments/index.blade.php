@extends('layouts.app')
@section('PageTitle', 'Track Payments')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header bg-info text-white">
            <div class="row align-items-center">
                <div class="col-md-2 col-sm-12 text-center text-md-start">
                    <h5 class="card-title text-white mb-0">Track Payments</h5>
                </div>
                <div class="col-md-10 col-sm-12 mt-3 mt-md-0 text-md-end">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-sm-6">
                            <label for="userType" class="form-label text-white mb-0">Sort by User Type:</label>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <select class="form-select form-select-sm" id="userType" name="userType">
                                {{-- <option value="parents">Parents</option> --}}
                                <option value="students">Students</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label for="paymentStatus" class="form-label text-white mb-0">Sort by Payment Status:</label>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <select class="form-select form-select-sm" id="paymentStatus" name="paymentStatus">
                                <option value="all">All</option>
                                <option value="completed">Completed</option>
                                <option value="partial">Partial Payments</option>
                                <option value="no_payment">No Payment Slip</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            @include('accounting.track_payments.table')
        </div>
    </div>
</div>


<!-- Invoice Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Invoice Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tbody id="invoiceContent">
                        <!-- Invoice details will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentHistoryModal" tabindex="-1" role="dialog" aria-labelledby="paymentHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentHistoryModalLabel">Payment History for <span id="studentName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>Date Paid</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody id="paymentHistoryTable">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script>
    $(document).ready(function() {
        $('#paymentStatus').change(function() {
            var selectedStatus = $('#paymentStatus').val();
            var selectedUserType = $('#userType').val();
            $.LoadingOverlay("show")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('track_payments.sort') }}",
                type: "POST",
                data: { status: selectedStatus, userType: selectedUserType },
                success: function(data) {
                    $('.invoices_table').html(data);
                    if ($.trim(data) === '') {
                        toastr.error('No data found.');
                    }
                    $.LoadingOverlay("hide");

                },
                error: function() {
                    alert('An error occurred while fetching data.');
                }
            });
        });
    });


    $(document).ready(function() {
        function formatAmount(amount) {
        if (amount !== null) {
            return numberWithCommas(amount.toFixed(0));
        } else {
            return '';
        }
    }

    function numberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $('.invoice_details').click(function() {
        var studentName = $(this).data('student_name');
        var invoiceId = $(this).data('invoice_id');
        
        // Set the modal title with the student name
        $('#invoiceModalLabel').text(studentName + ' - Invoice Details');
        $('#invoiceModal').modal('show');

        // Display loading spinner
        $('#invoiceContent').html('<tr><td colspan="2" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Send AJAX request to fetch invoice details
        $.ajax({
            url: "{{ route('track_payments.invoice_details') }}",
            type: "POST",
            data: { invoiceId: invoiceId },
            success: function(response) {
                    if (response.invoiceDetails) {
                        var invoiceDetails = response.invoiceDetails;

                        // Populate the table with invoice details
                        var html = '<tr><td>Invoice Number</td><td>' + (invoiceDetails.invoiceNumber || '') + '</td></tr>';
                        html += '<tr><td>Total Amount</td><td>' + formatAmount(invoiceDetails.totalAmount) + '</td></tr>';
                        html += '<tr><td>Previous Balance</td><td>' + formatAmount(invoiceDetails.previousBalance) + '</td></tr>';
                        html += '<tr><td>Discount</td><td>' + formatAmount(invoiceDetails.discount) + '</td></tr>';
                        // Add more fields as required

                        // Update the modal content
                        $('#invoiceContent').html(html);
                    } else {
                        // Error handling if invoice details not found
                        $('#invoiceContent').html('<tr><td colspan="2" class="text-center">Invoice details not found.</td></tr>');
                    }
                },
            error: function() {
                $('#invoiceContent').html('<tr><td colspan="2" class="text-center">An error occurred while fetching invoice details.</td></tr>');
            }
        });
    });




});




$(document).ready(function() {
    $('.payment_details').click(function() {
        var studentName = $(this).data('student_name');
        var studentId = $(this).data('student_id');
        var invoiceId = $(this).data('invoice_id');

        // Update the modal title with the student name
        $('#paymentModalTitle').text(studentName + ' - Payment History');

        // Show the loading spinner
        $('#paymentHistoryTable tbody').html('<tr><td colspan="2" class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading Payment History...</td></tr>');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Fetch the payment history data via AJAX
        $.ajax({
            url: "{{ route('track_payments.payment_history') }}",
            type: "POST",
            data: { studentId: studentId, invoiceId: invoiceId },
            success: function(response) {
                if (response.paymentHistory && response.paymentHistory.length > 0) {
                    var paymentHistory = response.paymentHistory;

                    // Populate the table with payment history data
                    var html = '';
                    for (var i = 0; i < paymentHistory.length; i++) {
                        html += '<tr>';
                        html += '<td>' + paymentHistory[i].created_at + '</td>';
                        html += '<td>' + paymentHistory[i].paid_amount + '</td>';
                        html += '</tr>';
                    }

                    // Update the modal content with the payment history table
                    $('#paymentHistoryTable').html(html);
                } else {
                    // Error handling if no payment history found
                    $('#paymentHistoryTable').html('<tr><td colspan="2" class="text-center">No Payment History Found.</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText); // Debugging: Log the error response
                alert('An error occurred while fetching payment history.'); // Show an error message
            }
        });
    });
});






</script>








@endsection


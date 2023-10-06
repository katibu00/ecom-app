@extends('layouts.app')
@section('PageTitle', 'Payment Records')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Learning Domains</h5>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDomainModal">Add Domain</a>
        </div>
        
        <div class="card-body">
            
            @if (count($learningDomains) > 0)

            <table class="table">
                <thead>
                    <tr>
                        <th>Domain</th>
                        <th>Learning Outcomes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($learningDomains as $domain)
                    <tr>
                        <td>{{ $domain->name }}</td>
                        <td>
                            <ul>
                                @foreach ($domain->learningOutcomes as $outcome)
                                <li>{{ $outcome->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-danger deleteDomainBtn" data-domain-id="{{ $domain->id }}">Delete</button>
                            <a href="{{ route('learning_domains.edit', $domain->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="container">
                <div class="alert alert-primary text-center">
                    <h5 class="mb-4 text-danger">No Learning Domain Created!</h5>
                    {{-- <p class="mb-4">Note: Before creating CA Scheme make sure you have added Classes.</p> --}}
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addDomainModal" class="btn btn-sm btn-primary">
                        Add Learning Domain
                    </button>
                </div>  
            </div>

            @endif
        </div>
    </div>
</div>

<!-- Add Domain Modal -->
<div class="modal fade" id="addDomainModal" tabindex="-1" role="dialog" aria-labelledby="addDomainModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDomainModalLabel">Add Learning Domain</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('learning_domains.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="domain"><strong>Learning Domain</strong></label>
                        <input type="text" class="form-control" id="domain" name="domain">
                    </div>
                    <div id="learningOutcomesContainer" class="mb-2">
                        <div class="form-group">
                            <label for="outcome">Learning Outcome</label>
                            <input type="text" class="form-control" name="outcomes[]">
                        </div>
                    </div>
                    <button type="button" class="btn btn-success" id="addOutcomeBtn">+ Add Outcome</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#addOutcomeBtn').click(function() {
            var newOutcome = '<div class="form-group mb-2">' +
                '<label for="outcome">Learning Outcome</label>' +
                '<input type="text" class="form-control mb-2" name="outcomes[]">' +
                '<button type="button" class="btn btn-danger removeOutcomeBtn mb-2">Remove</button>' +
                '</div>';

            $('#learningOutcomesContainer').append(newOutcome);
        });

        $(document).on('click', '.removeOutcomeBtn', function() {
            $(this).parent('.form-group').remove();
        });
    });
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>

<script>
    $(document).ready(function() {
        // Delete Domain button click event
        $(document).on('click', '.deleteDomainBtn', function() {
            var domainId = $(this).data('domain-id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete this learning domain and associated outcomes. This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send an AJAX request to delete the domain and its outcomes
                    $.ajax({
                        url: '{{ route('learning_domains.destroy', '') }}/' + domainId,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', 'The learning domain has been deleted.', 'success');
                           
                            window.location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Oops!', 'An error occurred while deleting the learning domain.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>


@endsection

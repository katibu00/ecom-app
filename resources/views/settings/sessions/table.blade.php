@if (count($sessions) > 0)
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($sessions as $key => $value)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <strong>{{ $value->name }}</strong>
                        </td>
                        <td>
                            <div>
                                <button type="button" data-id="{{ $value->id }}" data-name="{{ $value->name }}" data-status="{{ $value->status }}" class="btn btn-icon btn-outline-primary editItem"
                                    data-bs-toggle="modal" data-bs-target="#editModal">
                                    <span class="ti ti-pencil me-1"></span>
                                </button>
                                <button type="button" data-id="{{ $value->id }}" data-name="{{ $value->name }}" class="btn btn-icon btn-outline-danger deleteItem">
                                    <span class="ti ti-trash me-1"></span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
<div class="container">
    <div class="alert alert-primary text-center">
        <h5 class="mb-4 text-danger">No Sessions Created!</h5>
        <p class="mb-4">A session represents a specific academic period or school year. It is used to organize and manage various aspects of your school's activities, such as student enrollment, fee collection, attendance tracking, and result management.</p>
        <button type="button" data-bs-toggle="modal" data-bs-target="#addNewModal" class="btn btn-sm btn-primary">
            Create New Session
        </button>
    </div>
</div>

@endif

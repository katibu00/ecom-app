@if (count($classes) > 0)

<div class="table-responsive text-nowrap">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Form Master</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($classes as $key => $value)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <strong>{{ $value->name }}</strong>
                    </td>
                    <td>
                        <strong>{{ @$value->formMaster->first_name.' '. @$value->formMaster->last_name }}</strong>
                    </td>
                    <td>
                        {!! $value->status == 1 ? '  <span class="badge bg-label-primary me-1">Active</span>': '  <span class="badge bg-label-danger me-1">Not Active</span>' !!}
                    </td>
                    <td>
                        <div>
                            <button type="button" data-id="{{ $value->id }}" data-name="{{ $value->name }}" data-form_master_id="{{ $value->form_master_id }}" data-status="{{ $value->status }}" class="btn btn-icon btn-outline-primary editItem"
                                data-bs-toggle="modal" data-bs-target="#editModal">
                                <span class="ti ti-pencil me-1"></span>
                            </button>
                            <button type="button"  data-id="{{ $value->id }}" data-name="{{ $value->name }}" class="btn btn-icon btn-outline-danger deleteItem">
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
        <h5 class="mb-4 text-danger">No Classes Created!</h5>
        <p class="mb-4">Input all the classes in your school.</p>
        <p class="mb-4">Note: Before creating classes, make sure you have added school sections and preferably registered teachers. Alternatively, you can assign yourself as the form master for all classes and later edit the form master after registering the teachers.</p>
        <button type="button" data-bs-toggle="modal" data-bs-target="#addNewModal" class="btn btn-sm btn-primary">
            Create New Class
        </button>
    </div>  
</div>

@endif


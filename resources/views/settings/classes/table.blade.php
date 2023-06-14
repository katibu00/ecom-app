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
                        <strong>{{ @$value->form_master->first_name.' '. @$value->form_master->last_name }}</strong>
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
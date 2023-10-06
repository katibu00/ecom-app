@if (count($affectives) > 0)

<div class="table-responsive text-nowrap">
<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th class="text-center">S/N</th>
            <th>Affective Trait</th>
            <th class="text-center">Status</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($affectives as $key => $value)
        <tr>
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{{ @$value->name }}</td>
            <td>
                {!! $value->status == 1 ? '  <span class="badge bg-label-primary me-1">Active</span>': '  <span class="badge bg-label-danger me-1">Not Active</span>' !!}
            </td>
            <td class="text-center">
                <div>
                    <button type="button" data-id="{{ $value->id }}" data-name="{{ $value->name }}" data-status="{{ $value->status }}" class="btn btn-icon btn-outline-primary editItem"
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
        <h5 class="mb-4 text-danger">No Affective Trait Created!</h5>
        <p class="mb-4">Input all the Psychomotor Skills graded in your school.</p>
        {{-- <p class="mb-4">Note: Before creating classes, make sure you have added school sections and preferably registered teachers. Alternatively, you can assign yourself as the form master for all classes and later edit the form master after registering the teachers.</p> --}}
        <button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-primary">
            Add Affective Trait
        </button>
    </div>  
</div>

@endif
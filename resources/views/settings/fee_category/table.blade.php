<div class="table-responsive text-nowrap">
<table class="table">
    <thead>
        <tr>
            <th class="text-center">S/N</th>
            <th>Fee Category</th>
            <th>Priority</th>
            <th class="text-center">Status</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fee_categories as $key => $value)
        <tr>
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{{ @$value->name }}</td>
            <td>@if(@$value->priority == 'o') Optional @elseif(@$value->priority == 'r') Recommended @elseif(@$value->priority == 'm') Mandatory @endif</td>
            <td class="text-center">
                {!! $value->status == 1 ? '  <span class="badge bg-label-primary me-1">Active</span>': '  <span class="badge bg-label-danger me-1">Not Active</span>' !!}
            </td>
            <td>
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
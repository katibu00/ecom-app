<table class="table table-responsive-sm">
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
            <td class="text-center">{!! $value->status == 1 ? '  <span class="badge light badge-success">Active</span>': '  <span class="badge light badge-danger">Not Active</span>' !!}</td>
            <td class="text-center">
                <div>
                    <a href="#" data-id="{{ $value->id }}" data-name="{{ $value->name }}" data-status="{{ $value->status }}" data-priority="{{ $value->priority }}" data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-primary shadow btn-xs sharp me-1 editItem"><i class="fa fa-pencil"></i></a>
                    <a href="#" data-id="{{ $value->id }}" data-name="{{ $value->name }}" class="btn btn-danger shadow btn-xs sharp deleteItem"><i class="fa fa-trash"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th class="text-center">S/N</th>
            <th>Code</th>
            <th>Description</th>
            <th>Marks</th>
            <th class="text-center">Status</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cas as $key => $value)
        <tr>
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{{ @$value->code }}</td>
            <td>{{ @$value->desc }}</td>
            <td>{{ @$value->marks }}%</td>
            <td class="text-center">{!! $value->status == 1 ? '  <span class="badge light badge-success">Active</span>': '  <span class="badge light badge-danger">Not Active</span>' !!}</td>
            <td class="text-center">
                <div>
                    <a href="#" data-id="{{ $value->id }}" data-code="{{ $value->code }}" data-desc="{{ $value->desc }}" data-marks="{{ $value->marks }}" data-status="{{ $value->status }}" data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-primary shadow btn-xs sharp me-1 editItem"><i class="fa fa-pencil"></i></a>
                    <a href="#" data-id="{{ $value->id }}" data-name="{{ $value->code.' '.'('.$value->desc.')' }}" class="btn btn-danger shadow btn-xs sharp deleteItem"><i class="fa fa-trash"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
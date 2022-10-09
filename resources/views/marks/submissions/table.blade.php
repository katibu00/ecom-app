<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th class="text-center">S/N</th>
            <th>Subject</th>
            <th>Class</th>
            <th>Category</th>
            <th class="text-center">Status</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($submissions as $key => $value)
        <tr>
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{{ @$value->subject->name }}</td>
            <td>{{ @$value->class->name }}</td>
            <td>{{ @$value->marks_category }}</td>
            <td class="text-center">{!! $value->status == 1 ? '  <span class="badge light badge-success">Approved</span>': '  <span class="badge light badge-danger">Rejected</span>' !!}</td>
            <td class="text-center">
                <div class="dropdown">
                    <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown">
                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Analysis</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Approve</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Reject</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Send Query</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Email Teacher</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Teacher Details</a>
                        
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
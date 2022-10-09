<table class="table" id="example4" class="display" style="min-width: 845px">
    <thead>
        <tr>
            <th class="text-center">S/N</th>
            <th class="text-center">Name</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sessions as $key => $session)
        <tr>
            <td class="text-center">{{ $key + 1 }}</td>
            <td class="text-center">{{ $session->name }}</td>
            <td class="text-center">
                <div>
                    <a href="#" data-id="{{ $session->id }}" data-name="{{ $session->name }}" data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-primary shadow btn-xs sharp me-1 editItem"><i class="fa fa-pencil"></i></a>
                    <a href="#" data-id="{{ $session->id }}" data-name="{{ $session->name }}" class="btn btn-danger shadow btn-xs sharp deleteItem"><i class="fa fa-trash"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
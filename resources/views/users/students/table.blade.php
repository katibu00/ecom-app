<table id="example5" class="display" style="min-width: 845px">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Roll Number</th>
            <th>Name</th>
            <th>Class</th>
            <th>Parent </th>
            <th>Contact </th>
            <th>Last Login </th>
            <th>Registered</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if($students->count() > 0)
        @foreach ($students as $key => $student)
        <tr>
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{{ strtoupper($student->login) }}</td>
            <td>{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</td>
            @php
                $class = App\Models\Classes::select('name')->where('id', $student->class_id)->first();
                $parent = App\Models\User::select('title','first_name','last_name')->where('id', $student->parent_id)->first();
            @endphp
            <td class="text-center">{{ @$class->name }}</td>
            <td>{{ @$parent->title }} {{ @$parent->first_name }} {{ @$parent->last_name }}</td>
            <td>{{ @$student->parent->phone }}</td>
            <td class="text-center"></td>
           
            <td></td>
            <td>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown">
                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#detailsModal" id="student_details" data-student_id={{ $student->id }} data-student_name="{{ $student->first_name .' '.$student->middle_name.' '.$student->last_name }}"><i class="fa fa-user-circle text-primary me-2"></i>User Details</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>View Invoice</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Suspend</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Transfer</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Discounts</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Change Password</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Edit Profile</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Disciplinary Action</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Email Parent</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>SMS Parent</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Remind Fee</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Payment Records</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Attendance Records</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Print Profile</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Delete</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

<div class="d-flex justify-content-center d-none" id="loading_div">
    <div class="spinner-border" style="margin: 80px; height: 40px; width: 40px;" role="status"><span class="sr-only">Loading...</span></div>
 </div>
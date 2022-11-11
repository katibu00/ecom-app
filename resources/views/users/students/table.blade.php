<table class="table table-sm mb-0">
    <thead>
        <tr>
            <th class=" pe-3">
                <div class="form-check custom-checkbox mx-2">
                    <input type="checkbox" class="form-check-input" id="checkAll">
                    <label class="form-check-label" for="checkAll"></label>
                </div>
            </th>
            <th>Student</th>
            <th class=" ps-5" style="min-width: 200px;">Roll Number</th>
            <th>Class</th>
            <th>Parent </th>
            <th>Contact </th>
            <th></th>
        </tr>
    </thead>
    <tbody id="customers">
        @if($students->count() > 0)
             @foreach ($students as $key => $student)
                <tr class="btn-reveal-trigger">
                    <td class="py-2">
                        <div class="form-check custom-checkbox mx-2">
                            <input type="checkbox" class="form-check-input" id="checkbox1">
                            <label class="form-check-label" for="checkbox1"></label>
                        </div>
                    </td>
                    <td class="py-3">
                        <a href="#">
                            <div class="media d-flex align-items-center">
                                <div class="avatar avatar-xl me-2">
                                    <div class=""><img class="rounded-circle img-fluid"
                                            src="/uploads/default.png" width="30" alt="" />
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h5 class="mb-0 fs--1">{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</h5>
                                </div>
                            </div>
                        </a>
                    </td>
                    <td class="py-2"><a href="mailto:ricky@example.com">{{ strtoupper($student->login) }}</a></td>
                    @php
                        $class = App\Models\Classes::select('name')->where('id', $student->class_id)->first();
                        $parent = App\Models\User::select('title','first_name','last_name')->where('id', $student->parent_id)->first();
                    @endphp
                    <td class="py-2"> <a href="tel:2012001851">{{ @$class->name }}</a></td>
                    <td class="py-2">{{ @$parent->title }} {{ @$parent->first_name }} {{ @$parent->last_name }}</td>
                    <td class="py-2">{{ @$student->parent->phone }}</td>
                    <td class="py-2 text-end">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown">
                                <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item student_details" href="#" data-bs-toggle="modal" data-bs-target="#detailsModal" data-student_id={{ $student->id }} data-student_name="{{ $student->first_name .' '.$student->middle_name.' '.$student->last_name }}"><i class="fa fa-user-circle text-primary me-2"></i>User Details</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>View Invoice</a>
                                <a class="dropdown-item sno" href="#" data-bs-toggle="modal" data-bs-target="#sno_modal" data-student_id={{ $student->id }} data-student_name="{{ $student->first_name .' '.$student->middle_name.' '.$student->last_name }}"><i class="fa fa-user-circle text-primary me-2"></i>Sub. Not Offering</a>
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
<nav>
    <ul class="pagination pagination-gutter mt-3">
        {{ $students->links() }}
    </ul>
</nav>


<div class="d-flex justify-content-center d-none" id="loading_div">
    <div class="spinner-border" style="margin: 80px; height: 40px; width: 40px;" role="status"><span class="sr-only">Loading...</span></div>
 </div>
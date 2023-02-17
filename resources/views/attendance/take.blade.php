@extends('layouts.app')
@section('PageTitle', 'Take Attendance')
@section('css')
    <style type="text/css">
        .switch-toggle {
            width: auto;
        }

        .switch-toggle label:not(.disabled) {
            cursor: pointer;
        }

        .switch-candy a {
            border: 1px solid #333;
            border-radius: 3px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2), inset 0 1px 1px rgba(255, 255, 255, 0.45);
            background-color: white;
            background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 02), transparent);
            background-image: linear-gradient(to bottom, rgba(255, 255, 255, 02), transparent);
        }

        .switch-toggle.switch-candy,
        .switch-light.switch-candy>span {
            background-color: #b6b8ba;
            border-radius: 3px;
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.3), 0 1px 0 rgba(255, 255, 255, 0.2);

        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-title header-elements  d-flex fle4x-row">
                            <h5 class="m-0 me-2 d-none d-md-block">Take Attendance</h5>
                        </div>



                        <form action="{{ route('attendance.take.search') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4 mb-1">
                                    <select class="form-select" id="class_id" name="class_id">
                                        <option value="">--select class--</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ @$class_id == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-4">
                                    <label class="form-label" for=""></label>
                                    <button type="submit" class="btn btn-primary">Search Students</button>
                                </div>
                            </div>
                        </form>

                        @if (isset($students))
                            <form method="POST" action="{{ route('attendance.take.store') }}">
                                @csrf

                                <input type="hidden" value="{{ @$class_id }}" name="class_id">

                                <div class="form-row">
                                    <div class="form-group col-md-3 mt-2">
                                        <label class="control-label">Attendance Date</label>
                                        <input type="date" name="date" id="date"
                                            class="checkdate form-control form-control-sm singledatepicker"
                                            autocomplete="off" required>
                                    </div>
                                </div>


                                <div class="table-responsive text-nowrap col-md-9">
                                    <table class="table-sm table-bordered table-striped table-responsive-sm"
                                        style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="text-center" style="vertical-align:middle;" style="width: 5%;">S/N</th>
                                                <th rowspan="2" class="text-center" style="vertical-align:middle;">Name</th>
                                                <th colspan="3" class="text-center" style="vertical-align:middle; width: 35%;">Status
                                                    <tr>
                                                        <th class="text-center btn present_all" style="display: table-cell; background-color: #114190;color: white;">Present</th>
                                                        <th class="text-center btn leave_all" style="display: table-cell; background-color: #114190; color: white;">Leave</th>
                                                        <th class="text-center btn absent_all" style="display: table-cell; background-color: #114190;color: white;">Absent</th>
                                                    </tr>
                                                </th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @if (isset($students))
                                                @foreach ($students as $key => $student)
                                                    <tr id="div{{ $student->id }}" >
                                                        <input type="hidden" name="student_id[]"
                                                            value="{{ $student->id }}" class="student_id">
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td>{{ $student->first_name }} {{ $student->middle_name }}
                                                            {{ $student->last_name }} </td>
                                                        <td colspan="3">
                                                            <div class="switch-toggle switch-light switch-candy">
                                                                <input class="present" id="present{{ $key }}"
                                                                    name="attend_status{{ $key }}" value="present"
                                                                    type="radio" checked="checked" />
                                                                <label for="present{{ $key }}">Present</label>

                                                                <input class="leave" id="leave{{ $key }}"
                                                                    name="attend_status{{ $key }}" value="leave"
                                                                    type="radio" />
                                                                <label for="leave{{ $key }}">Leave</label>

                                                                <input class="absent" id="absent{{ $key }}"
                                                                    name="attend_status{{ $key }}" value="absent"
                                                                    type="radio" />
                                                                <label for="absent{{ $key }}">Absent</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        <tbody><br>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit"
                                        class="btn btn-info btn-block mt-2">Record</button>
                                </div>
                            </form>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script type="text/javascript">
        $(document).on('click', '.present', function() {
            $(this).parents('tr').find('.datetime').css('pointer-events', 'none').css('background-color', '#dee2e6')
                .css('color', '#495057');
        })

        $(document).on('click', '.leave', function() {
            $(this).parents('tr').find('.datetime').css('pointer-events', 'none').css('background-color', '#dee2e6')
                .css('color', '#495057');
        })

        $(document).on('click', '.absent', function() {
            $(this).parents('tr').find('.datetime').css('pointer-events', 'none').css('background-color', '#dee2e6')
                .css('color', '#495057');
        });
    </script>

    <script type="text/javascript">
        $(document).on('click', '.present_all', function() {
            $("input[value=present]").prop('checked', true);
            $('.datetime').css('pointer-events', 'none').css('background-color', '#dee2e6').css('color', '#495057');
        });

        $(document).on('click', '.leave_all', function() {
            $("input[value=leave]").prop('checked', true);
            $('.datetime').css('pointer-events', 'none').css('background-color', '#dee2e6').css('color', '#495057');
        });

        $(document).on('click', '.absent_all', function() {
            $("input[value=absent]").prop('checked', true);
            $('.datetime').css('pointer-events', 'none').css('background-color', '#dee2e6').css('color', '#495057');
        });
    </script>

@endsection

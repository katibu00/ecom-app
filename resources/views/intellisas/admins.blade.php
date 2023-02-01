@extends('layouts.app')
@section('PageTitle', 'Schhol Admins')


@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements">
                <span class="me-2">Admin</span>

                <div class="card-header-elements ms-auto">
                    
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Schhol</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($admins as $key => $value)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <strong>{{ $value->first_name.' '.$value->middle_name.' '.$value->last_name }}</strong>
                                </td>
                                @php
                                    $school = App\Models\School::where('id',$value->school_id)->select('name')->first();
                                @endphp
                                <td>
                                    <strong>{{ @$school->name }}</strong>
                                </td>
                                <td>
                                    <strong>{{ @$value->phone }}</strong>
                                </td>
                                
                                <td>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- content @e -->
@endsection
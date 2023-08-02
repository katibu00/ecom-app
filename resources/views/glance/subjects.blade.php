@extends('layout.master')
@section('PageTitle', 'Subjects Assignment')
@section('content')


    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h6><strong>Class Name: </strong>{{ $subjects['0']['class']['name']}} {{$subjects['0']['class_section']['name']}}</h6>
                            </div>

                            <a class="btn btn-success float-right btn-sm" href="{{ route('assign.subjects.index') }}"><i
                                    class="fa fa-list"></i> Subjects Assignment List</a>
                        </div>
                        <hr>
                        <div class="iq-card-body">
                            <div class="table-responsive">
                                <table class="table  mb-1 mt-2 table-borderless table-test">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Subjects</th>
                                            <th>Teacher</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                       @foreach ($subjects as $key => $value)

                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value['subject']['name'] }}</td>
                                            <td>{{ $value['user']['first_name'] }} {{ $value['user']['middle_name'] }}  {{ $value['user']['last_name'] }}</td>
                                        </tr>
                                      
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection

@extends('layout.master')
@section('PageTitle', 'Fee Assignment Details')
@section('content')
    <?php
    $sum = 0;
    foreach ($allData as $key => $value) {
        $sum += $value->amount;
    }
    ?>

    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h5><strong>Class Name: </strong>{{ $allData['0']['class']['name'] }} |
                                    <strong>Total:</strong> &#x20A6;{{ number_format($sum, 0) }} | <strong>Student
                                        Type:</strong> {{ $allData['0']->student_type }}</h5>
                            </div>

                            <a class="btn btn-success float-right btn-sm" href="{{ route('fee.assign.index') }}"><i
                                    class="fa fa-list"></i> Fee Assignment List</a>
                        </div>
                        <hr>
                        <div class="iq-card-body">
                            <div class="table-responsive">
                                <table class="table  mt-2 table-borderless table-test">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Fee Type</th>
                                            <th>Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allData as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>

                                                <td>{{ $value['fee_type']['name'] }}</td>
                                                <td>{{ $value->amount }}</td>
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
@endsection

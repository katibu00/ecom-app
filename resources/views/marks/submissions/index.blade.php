@extends('layouts.app')
@section('PageTitle', 'Marks Submission')


@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row mb-5">

            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-title header-elements  d-flex flex-row">
                            <h5 class="m-0 me-2 d-none d-md-block">Marks Submission</h5>
                        </div>


                        <form class="form" action="{{ route('marks.submissions.search')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4 mb-1">
                                    <select class="form-select form-select-sm mb-3" id="class_id" name="class_id">
                                        <option value="">--select Class--</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}" {{$class->id == @$class_id? 'selected':''}}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('assign_id')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-sm-4">
                                    <label class="form-label" for=""></label>
                                    <button type="submit" class="btn btn-sm btn-primary">Search Students</button>
                                </div>
                            </div>
                        </form>
        
                        @if(isset($submissions))
                        <div class="table-responsive">
                            @include('marks.submissions.table')
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('js')
    @include('marks.scripts')
@endsection

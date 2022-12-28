@extends('layouts.app')
@section('PageTitle', 'End of Term Report')


@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-title header-elements  d-flex fle4x-row">
                            <h5 class="m-0 me-2 d-none d-md-block">End of Term Report</h5>
                        </div>

                        <form class="form" action="{{ route('result.termly.index')}}" method="POST" target="_blank">
                            @csrf
                            <div class="row">
                                <div class="col-sm-3 mb-1">
                                    <select class="form-select mb-2" name="session_id">
                                        <option value="">--select Session--</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}" {{ $session->id == @$school->session_id ? 'selected':''}}>{{ $session->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('session_id')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3 mb-1">
                                    <select class="form-select mb-2" name="class_id">
                                        <option value="">--Select Class--</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3 mb-1">
                                    <select class="form-select mb-2" name="term">
                                        <option value="">--Select Term--</option>
                                        <option value="first" {{ $school->term == 'first' ? 'selected':''}}>First</option>
                                        <option value="second" {{ $school->term == 'second' ? 'selected':''}}>Second</option>
                                        <option value="third" {{ $school->term == 'third' ? 'selected':''}}>Thirs</option>
                                    </select>
                                    @error('term')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label" for=""></label>
                                    <button type="submit" class="btn btn-primary">Search Records</button>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="comments">Comments
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input"  name="psychomotor">Psychomotor
                                    </label>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('marks.scripts')
    <script src="/js/sweetalert.min.js"></script>
    {!! Toastr::message() !!}
@endsection

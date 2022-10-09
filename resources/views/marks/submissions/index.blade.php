@extends('layouts.app')
@section('PageTitle', 'Marks Submission')
@section('content')

<div class="content-body">
<!-- row -->
    <div class="container-fluid">
       {{-- content --}}

       <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Marks Submission</h4>
            </div>
            <div class="card-body my-1 py-50">

                <form class="form" action="{{ route('marks.submissions.index')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-4 mb-1">
                            <select class="default-select form-control wide mb-3" id="class_id" name="class_id">
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
                            <button type="submit" class="btn btn-primary">Search Students</button>
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
        
        {{-- @include('settings.classes.addModal')
        @include('settings.classes.editModal') --}}
    </div>
</div>
@endsection

@section('js')
<script src="/js/sweetalert.min.js"></script>
{{-- @include('settings.classes.script') --}}
{!! Toastr::message() !!}
@endsection
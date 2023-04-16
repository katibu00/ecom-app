@extends('layouts.app')
@section('PageTitle', 'Psychomotor Grade')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-header header-elements">
                            <span class="me-2">{{ ($type == 1) ? 'Psychomotor Skills' : (($type == 2) ? 'Affective Trait' : '') }} for {{ $class->name }}</span>

                            <div class="card-header-elements ms-auto">
                                <a href="{{ route('psychomotor.index') }}" class="btn btn-danger">Back to List</a>
                            </div>
                        </div>

                        @include('psychomotor.viewTable')

                    </div>
                </div>
                {{-- @include('psychomotor.addModal')
                @include('psychomotor.viewModal') --}}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/js/sweetalert.min.js"></script>
    {{-- @include('psychomotor.script') --}}
@endsection

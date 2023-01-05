@extends('layouts.app')
@section('PageTitle', 'Print Invoices')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">

            <!-- Select Election -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex4 align-items-center he4ader-elements">
                            <form action="{{ route('invoices.print.generate') }}" method="post"  target="_blank">
                                @csrf
                                <div class="row">
                                   
                                    <div class="col-md-3 mb-2" id="class">
                                        <label for="">Class</label>
                                        <select class="form-select form-select-sm mb-2" name="class_id" required>
                                            <option value=""></option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">
                                                    {{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('class')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-2" id="class">
                                        <label for="">Accountant Name</label>
                                        <input type="text" class="form-control form-control-sm" name="name" required>
                                        </select>
                                        @error('name')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-2" id="class">
                                        <label for="">Accountant Phone</label>
                                        <input type="tel" class="form-control form-control-sm" name="phone" required>
                                        </select>
                                        @error('phone')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    

                                    <div class="col-md-2 mt-md-3">
                                        <button type="submit" class="btn btn-sm btn-primary">Print Invoices</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

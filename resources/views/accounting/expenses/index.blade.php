@extends('layouts.app')
@section('PageTitle', 'Expenses')


@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
	

	<div class="row mb-5">
	 
	  <div class="col-md">
		<div class="card mb-4">
		  <div class="card-body">
			
			<div class="card-title header-elements  d-flex flex-row">
			  <h5 class="m-0 me-2 d-none d-md-block">Expenses</h5>
			  
			  <div class="col-md-3 d-none d-md-block mb-1">
				<input type="text" class="form-control form-control-sm" id="search" placeholder="Search..."/>
			</div>
			  

			  <div class="card-title-elements ms-auto">
				<select class="form-select form-select-sm w-auto" id="select_class">
                    <option value="All" value="all">All</option>
                    <option value="All" value="approved">Approved</option>
                    <option value="All" value="unapproved">Rejected</option>
                    <option value="All" value="unapproved">Awaiting Approval</option>
				</select>
				
				<button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-xs btn-primary">
					<span class="tf-icon ti ti-plus ti-xs me-1"></span>Record New Expense(s)
                </button>
			  </div>
			</div>
			
                @include('accounting.expenses.table')
           
		  </div>
		</div>
	  </div>
	</div>
	<!--/ Header elements -->


    @include('accounting.expenses.add_modal')

	
  </div>

@endsection

@section('js')
@include('accounting.expenses.script')
@endsection
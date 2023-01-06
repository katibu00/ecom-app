<div class="table-responsive text-nowrap">
    <table class="table table-hover">    <thead>
        <tr>
            <th>S/N</th>
            <th>Date</th>
            <th>Payer</th>
            <th>Payee</th>
            <th>Description </th>
            <th>Category </th>
            <th>Amount </th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($expenses as $key => $expense)
        <tr>
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{{ $expense->date }}</td>
            <td>{{ @$expense->payer->title }} {{ $expense->payer->first_name }} {{ $expense->payer->last_name }}</td>
           
            <td class="text-center">{{ @$expense->payee_id }}</td>
            <td>{{ @$expense->description }}</td>
            <td>{{ @$expense->category->name }}</td>
            <td class="text-center">{{ number_format($expense->amount,0) }}</td>
            <td>
                @if( $expense->status == 0) <span class="badge light badge-warning">Awaiting Approval</span> 
                @elseif($expense->status == 1) <span class="badge light badge-success">Approved</span>
                @elseif($expense->status == 2) <span class="badge light badge-danger">Rejected</span>@endif
            </td>
            <td>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown">
                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Approve</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Reject</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-user-circle text-primary me-2"></i>Delete</a>
                    </div>
                </div>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="9">  <div class="alert alert-warning" role="alert">No Expenses Record Found - Click on the plus icon above to start.</div></td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

<div class="d-flex justify-content-center d-none" id="loading_div">
    <div class="spinner-border" style="margin: 80px; height: 40px; width: 40px;" role="status"><span class="sr-only">Loading...</span></div>
 </div>
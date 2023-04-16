<div class="table-responsive text-nowrap">
    <table class="table">
        <thead>
            <tr>
                <th class="text-center">S/N</th>
                <th>Fee Category</th>
                <th>Amount (&#8358;)</th>
                <th>Priority</th>
                <th>Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $key => $row)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td><strong>{{ @$row->fee_category->name }}</strong></td>
                <td>{{ number_format(@$row->amount,0) }}</td>
                <td>@if( @$row->priority == 'm') Mandatory @elseif( @$row->priority == 'o') Optional @elseif( @$row->priority == 'r') Recommended @endif</td>
                <td>
                    {!! @$row->status == 1 ? '  <span class="badge bg-label-primary me-1">Active</span>': '  <span class="badge bg-label-danger me-1">Not Active</span>' !!}
                </td>
                <td class="text-center">
                    <div>
                        <button type="button" data-row_id="{{ @$row->id }}" data-amount="{{ @$row->amount }}" data-status="{{ @$row->status }}" data-priority="{{ @$row->priority }}" class="btn btn-icon btn-outline-primary editItem"
                            data-bs-toggle="modal" data-bs-target="#editModal">
                            <span class="ti ti-pencil me-1"></span>
                        </button>
                        <button type="button"  data-row_id="{{ @$row->id }}" data-name="{{ @$row->fee_category->name }}" class="btn btn-icon btn-outline-danger deleteItem">
                            <span class="ti ti-trash me-1"></span>
                        </button>
                    </div>
                </td>
             
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
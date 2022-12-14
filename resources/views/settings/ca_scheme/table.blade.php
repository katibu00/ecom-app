<div class="table-responsive text-nowrap">
<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th class="text-center">S/N</th>
            <th>Code</th>
            <th>Description</th>
            <th>Marks</th>
            <th>Classes</th>
            <th class="text-center">Status</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cas as $key => $value)
        <tr>
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{{ @$value->code }}</td>
            <td>{{ @$value->desc }}</td>
            <td>{{ @$value->marks }}%</td>
            @php
                @$classes = explode(',', @$value->class_id); 
            @endphp
            <td>
                @foreach ($classes as $class)
                    @php
                        $name = App\Models\Classes::select('name')->where('id',$class)->first();
                    @endphp
                {{ @$name->name }} @if(!$loop->last),@endif
                @endforeach
            </td>
            <td class="text-center">
                {!! $value->status == 1 ? '  <span class="badge bg-label-primary me-1">Active</span>': '  <span class="badge bg-label-danger me-1">Not Active</span>' !!}
            </td>
            <td class="text-center">
                <div>
                    
                    <button type="button"  data-id="{{ $value->id }}" data-name="{{ $value->code }}" class="btn btn-icon btn-outline-danger deleteItem">
                        <span class="ti ti-trash me-1"></span>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
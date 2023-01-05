<!DOCTYPE html>
@php
  $students = App\Models\User::select('id','first_name','parent_id','middle_name','last_name','class_id')->with('parent','class')->where('class_id',$class_id)->where('status',1)->get();
  $accounts = App\Models\BankAccount::select('bank','number','name')->where('school_id',auth()->user()->school_id)->where('status',1)->get();
@endphp
<html
  lang="en"
  class="light-style"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/assets/"
  data-template="vertical-menu-template"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{ $class_name.' Invoices - '.$school->name }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/uploads/{{ $school->username }}/{{ $school->logo }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>
    <script src="/assets/vendor/js/template-customizer.js"></script>
    <script src="/assets/js/config.js"></script>
  </head>

  <body>

    @foreach ($students as $key => $student )
    @php
      $invoice = App\Models\Invoice::where('school_id',$school->id)
                                    ->where('student_id',$student->id)
                                    ->where('session_id',$school->session_id)
                                    ->where('term',$school->term)
                                    ->first();
      $fees = App\Models\FeeStructure::with('fee_category')->select('student_type','fee_category_id','amount')->where('school_id',$school->id)
                                    ->where('class_id',$class_id)
                                    ->where('student_type',$invoice->student_type)
                                    ->whereHas('fee_category', function ($query)
                                    {
                                      $query->orderBy('priority', 'asc');
                                    })
                                    ->get();
      $total_invoice = App\Models\FeeStructure::with('fee_category')->select('student_type','fee_category_id','amount')->where('school_id',$school->id)
                                    ->where('class_id',$class_id)
                                    ->where('student_type',$invoice->student_type)
                                    ->sum('amount');
      $total_amount = 0;
      $total_mandatory = 0;
    @endphp 
    <!-- Content -->
    <div class="invoice-print p-5">
      <div class="d-flex justify-content-between flex-row">
        <div class="mb-4">
          <div class="d-flex svg-illustration mb-3 gap-2">
            <img src="/uploads/{{ $school->username }}/{{ $school->logo }}" width="40" height="40" />
            <span class="app-brand-text fw-bold"> {{ $school->name }} </span>
          </div>
          <p class="mb-1">{{ $school->address }}</p>
          <p class="mb-1">{{ $school->email }}</p>
          <p class="mb-0">{{ $school->phone_first }} {{ $school->phone_second }}</p>
        </div>
        <div>
          <h4 class="fw-bold">INVOICE #{{ $invoice->number }}</h4>
          <div class="mb-2">
            <span class="text-muted">Date Issued:</span>
            <span class="fw-bold">{{ $invoice->created_at->format('F d, Y') }}</span>
          </div>
          <div>
            <span class="text-muted">Date Due:</span>
            <span class="fw-bold">{{ $invoice->created_at->format('F d, Y') }}</span>
          </div>
        </div>
      </div>

      <hr />

      <div class="row d-flex justify-content-between mb-4">
        <div class="col-sm-6 w-50">
          <h6>Invoice To:</h6>
          <p class="mb-1"><strong>Student: </strong>{{ @$student->first_name.' '.@$student->middle_name.' '.@$student->last_name }}</p>
          <p class="mb-1"><strong>Parent: </strong>{{ @$student->parent->title.' '.@$student->parent->first_name.' '.@$student->parent->last_name }}</p>
          <p class="mb-1"><strong>Class: </strong>{{ @$student->class->name }}</p>
          <p class="mb-1"><strong>Session: </strong>{{ @$school->session->name }}</p>
          <p class="mb-0"><strong>Term: </strong>{{ ucfirst(@$school->term) }}</p>
          
        </div>
        <div class="col-sm-6 w-50">
          <h6>Bill To:</h6>
          <table>
            <tbody>
              <tr>
                <td class="pe-3">Total Due:</td>
                <td><strong>&#8358;{{ number_format(($total_invoice+$invoice->pre_balance)-$invoice->discount,2)}}</strong></td>
              </tr>
              <tr>
                <td class="pe-3">Bank Accounts:</td>
                <td>
                  @foreach ($accounts as $account)
                  {{ $account->name.' - '.$account->number.' '.'('.$account->bank.')' }}<br />
                  @endforeach
                </td>
                
              </tr>
             
            </tbody>
          </table>
        </div>
      </div>

      <div class="table-responsive w-100">
        <table class="table m-0">
          <thead class="table-light">
            <tr>
              <th>S/N</th>
              <th>Item</th>
              <th>Priority</th>
              <th>Cost</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($fees as $key2 => $fee )
            <tr>
              <td>{{ $key2+1 }}</td>
              <td>{{ $fee->fee_category->name}}</td>
              <td>@if(@$fee->fee_category->priority == 'o') Optional @elseif(@$fee->fee_category->priority == 'r') Recommended @elseif(@$fee->fee_category->priority == 'm') Mandatory @endif</td>
              <td>{{ number_format($fee->amount,0) }}</td>
            </tr>
              @php
                $total_amount+= $fee->amount;
                if($fee->fee_category->priority == 'm')
                {
                   $total_mandatory+= $fee->amount;
                }
              @endphp
            @endforeach
            <tr>
              <td colspan="2" class="align-top px-4 py-3">
                <p class="mb-2">
                  <span class="me-1 fw-bold">Accountant:</span>
                  <span>{{ $name.' ('.$phone.')' }}</span>
                </p>
                <span>Thanks for your business</span>
              </td>
              <td class="text-end px-4 py-3">
                <p class="mb-2">Subtotal:</p>
                <p class="mb-2">Balance Brought Forward:</p>
                @if($invoice->discount != 0)<p class="mb-2">Discount:</p>@endif
                {{-- <p class="mb-2">Tax:</p> --}}
                <p class="mb-0">Total:</p>
              </td>
              <td class="px-4 py-3">
                <p class="fw-bold mb-2">&#8358;{{ number_format($total_amount,2)}}</p>
                <p class="fw-bold mb-2">&#8358;{{ number_format($invoice->pre_balance,2)}}</p>
                @if($invoice->discount != 0)<p class="fw-bold mb-2">&#8358;{{ number_format($invoice->discount,2)}}</p>@endif
                {{-- <p class="fw-bold mb-2">$50.00</p> --}}
                <p class="fw-bold mb-2">&#8358;{{ number_format(($total_amount+$invoice->pre_balance)-$invoice->discount,2)}}</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="row">
        <div class="col-12">
          <span class="fw-bold">Note:</span>
          <span>The amount of Mandatory Fees is {{ $total_mandatory }}. You can pay by making bank transfer to any of the above bank account or in-person in the school premises.</span>
        </div>
      </div>
    </div>
    <!-- / Content -->
    <div style=" page-break-before: always;"></div>
    @endforeach
    <!-- Page JS -->
    <script src="/assets/js/app-invoice-print.js"></script>
  </body>
</html>

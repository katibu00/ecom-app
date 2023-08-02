@extends('layouts.app')
@section('PageTitle', 'Fee Collection')
@section('content')
    <?php
    $sum = 0;
    foreach ($invoice as $key => $value) {
        $sum += $value->amount;
    }
    ?>

    <div id="content-page" class="content-page">
        <div class="container-fluid">

            
           
                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                   <div class="iq-card-body">
                      <div class="row">
                         <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center mb-3 mb-lg-0">
                               <div class="rounded-circle iq-card-icon iq-bg-primary mr-3"> <i class="ri-mail-open-line"></i></div>
                               <div class="text-left">
                                  <h4>&#x20A6;{{number_format($sum,0)}}</h4>
                                  <p class="mb-0">School Fees</p>
                               </div>
                            </div>
                         </div>
                         @php
                           $receivable = $users->count()*$sum;
                         @endphp
                         <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center mb-3 mb-lg-0">
                               <div class="rounded-circle iq-card-icon iq-bg-info mr-3"> <i class="ri-message-3-line"></i></div>
                               <div class="text-left">
                                  <h4>&#x20A6;{{number_format($receivable,0)}}</h4>
                                  <p class="mb-0">Expected Revenue</p>
                               </div>
                            </div>
                         </div>
                         @php
                            $total_payment = 0;

                            $total_paid = App\Models\Payment::where('school_id',$school_id)->where('session_id',$session)->where('term',$term)->where('class_id',$class->id)->where('class_section_id',$section->id)->get();

                            foreach($total_paid as $total_paym){

                                $total_payment += $total_paym->amount;

                                }
                        @endphp
                         <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center mb-3 mb-md-0">
                               <div class="rounded-circle iq-card-icon iq-bg-danger mr-3"> <i class="ri-group-line"></i></div>
                               <div class="text-left">
                                  <h4>&#x20A6;{{number_format($total_payment,0)}}</h4>
                                  <p class="mb-0">Gross Revenue</p>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center mb-3 mb-md-0">
                               <div class="rounded-circle iq-card-icon iq-bg-warning mr-3"> <i class="ri-task-line"></i></div>
                               <div class="text-left">
                                  <h4>&#x20A6;{{number_format($receivable-$total_payment,0)}}</h4>
                                  <p class="mb-0">Outstanding</p>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
          

            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
            
                        <div class="iq-card-body">
                            <div class="table-responsive">
                                <table class="table  mt-1 table-borderless table-test">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 10%;">S/N</th>
                                            <th style="width: 45%;">Name</th>
                                            <th class="text-center" style="width: 15%;">Payable (&#x20A6;)</th>
                                            <th class="text-center" style="width: 15%;">Paid (&#x20A6;)</th>
                                            <th class="text-center" style="width: 15%;">Balance (&#x20A6;)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            @php
                                                $allPayment = App\Models\Payment::where('school_id', $school_id)
                                                    ->where('student_id', $user->id)
                                                    ->where('session_id', $session)
                                                    ->where('term', $term)
                                                    ->where('class_id', $class->id)
                                                    ->where('class_section_id', $section->id)
                                                    ->get();
                                                $total_payment = 0;
                                                $total = 0;
                                                
                                                foreach ($allPayment as $all) {
                                                    $total += $all->amount;
                                                }
                                                
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-left"> {{ $user->first_name }} {{ $user->middle_name }}
                                                    {{ $user->last_name }}</td>
                                                <td class="text-center">{{ number_format($sum, 0) }}</td>
                                                @if ($total != 0)
                                                    
                                                    <td class="text-center">{{ number_format($total, 0) }}</td>

                                                    @if ($sum - $total == 0)
                                                        <td class="text-center">Settled</td>
                                                    @else
                                                        <td class="text-center">{{ number_format($sum - $total, 2) }}</td>
                                                    @endif
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                @endif

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

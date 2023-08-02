@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="/assets/vendor/css/pages/page-profile.css" />
@endsection
@section('PageTitle', 'Parent Home')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="user-profile-header-banner">
          <img src="/uploads/banner.jpeg" alt="Banner image"  class="rounded-top" />
        </div>
        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
          <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
            <img
              src="/uploads/default.png"
              alt="user image"
            
              class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img"
            />
          </div>
          <div class="flex-grow-1 mt-3 mt-sm-5">
            <div
              class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4"
            >
              <div class="user-profile-info">
                <h4>{{ auth()->user()->first_name.' '.auth()->user()->last_name }}</h4>
                <ul
                  class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2"
                >
                <li class="list-inline-item"><i class="ti ti-wallet"></i>
                  @if(auth()->user()->wallet)
                      &#8358;{{ number_format(auth()->user()->wallet->balance, 2) }} Wallet Balance
                  @else
                      Wallet Not Available
                  @endif
              </li>
                  <li class="list-inline-item"><i class="ti ti-users"></i>  {{ $children->count() > 1 ? $children->count().' Wards': $children->count().' Ward' }}</li>
                </ul>
              </div>
              <a href="{{ route('fees_billing.index') }}" class="btn btn-primary">
                <i class="ti ti-user-dollar me-1"></i>Pay Fees
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Header -->

  <!-- User Profile Content -->
  <div class="row">
    <div class="col-xl-4 col-lg-5 col-md-5">
      <!-- Fee Overview -->
      <div class="card mb-4">
        <div class="card-body">
          <small class="card-text text-uppercase">Fees Overview (This Term)</small>
          <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3">
              <i class="ti ti-point"></i><span class="fw-bold mx-2">Total Amount Due:</span> <span>{!! $total_amount_due != 0?'&#8358;'.number_format($total_amount_due,0): ' - ' !!}</span>
            </li>
            <li class="d-flex align-items-center mb-3">
              <i class="ti ti-point"></i><span class="fw-bold mx-2">Previous Balance:</span> <span>{!! $total_pre_balance != 0?'&#8358;'.number_format($total_pre_balance,0): ' - ' !!}</span>
            </li>
            <li class="d-flex align-items-center mb-3">
              <i class="ti ti-point"></i><span class="fw-bold mx-2">Discount Allowed:</span> <span>{!! $total_discount != 0?'&#8358;'.number_format($total_discount,0): ' - ' !!}</span>
            </li>
            <li class="d-flex align-items-center mb-3">
              <i class="ti ti-point"></i><span class="fw-bold mx-2">Total Amount Paid:</span> <span>{!! $total_paid != 0?'&#8358;'.number_format($total_paid,0): ' - ' !!}</span>
            </li>
            <li class="d-flex align-items-center mb-3">
              <i class="ti ti-point"></i><span class="fw-bold mx-2">Balance:</span> <span>&#8358;{{ number_format($total_amount_due+$total_pre_balance-$total_discount-$total_paid) }}</span>
            </li>
          </ul>
       
        </div>
      </div>
      <!--/ Fee Overview -->
      <!-- School Overview -->
      <div class="card mb-4">
        <div class="card-body">
          <p class="card-text text-uppercase">School Overview</p>
          <ul class="list-unstyled mb-0">
            <li class="d-flex align-items-center mb-3">
              <i class="ti ti-point"></i><span class="fw-bold mx-2">Session:</span> <span>{{ $school->session->name }}</span>
            </li>
            <li class="d-flex align-items-center mb-3">
              <i class="ti ti-point"></i><span class="fw-bold mx-2">Term:</span><span>{{ ucfirst($school->term) }} Term</span>
            </li>
            <li class="d-flex align-items-center">
              <i class="ti ti-point"></i><span class="fw-bold mx-2">This Term Ends:</span> <span>-</span>
            </li>
          </ul>
        </div>
      </div>
      <!--/ School Overview -->
      <!-- children -->
      <div class="card card-action mb-4">
        <div class="card-header align-items-center">
          <small class="card-text text-uppercase">{{ $children->count() > 1 ? 'Wards': 'Ward' }}</small>
        </div>
        <div class="card-body">
          <ul class="list-unstyled mb-0">
            @foreach ($children as $child)
            <li class="mb-3">
              <div class="d-flex align-items-start">
                <div class="d-flex align-items-start">
                  <div class="avatar me-2">
                    <img src="/uploads/{!! $child->image == ''? 'default.png': $school->username.'/'.$child->image !!}" alt="Avatar" class="rounded-circle" />
                  </div>
                  <div class="me-2 ms-1">
                    <h6 class="mb-0">{{ @$child->first_name.' '.@$child->middle_name.' '.@$child->last_name }}</h6>
                    {{-- <small class="text-muted">45 Connections</small> --}}
                  </div>
                </div>
                <div class="ms-auto">
                  {{ @$child->class->name }}
                </div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
      <!--/ children -->
    </div>
    <div class="col-xl-8 col-lg-7 col-md-7">
      <!-- Activity Timeline -->
      <div class="card card-action mb-4">
        <div class="card-header align-items-center">
          <h5 class="card-action-title mb-0">Recent CA Scores</h5>
        </div>
        <div class="card-body pb-0">
       
              <div class="nav-align-top mb-4">
                <ul class="nav nav-tabs" role="tablist">
                 @foreach ($children as $child)
                  <li class="nav-item">
                    <button
                      type="button"
                      class="nav-link {{ $loop->first? 'active':'' }}"
                      role="tab"
                      data-bs-toggle="tab"
                      data-bs-target="#{{ $child->first_name }}"
                      aria-controls="{{ $child->first_name }}"
                      aria-selected="true"
                    >
                      {{ $child->first_name }}
                    </button>
                  </li>
                  @endforeach
                </ul>
                <div class="tab-content">
                  @foreach ($children as $child)
                  <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $child->first_name }}" role="tabpanel">
                      @php
                          $submissions = App\Models\MarkSubmit::select('subject_id', 'marks_category')
                              ->where('school_id', $school->id)
                              ->where('session_id', $school->session_id)
                              ->where('term', $school->term)
                              ->where('class_id', $child->class_id)
                              ->get();
                      @endphp
              
                      <div class="card-datatable table-responsive">
                          <table class="datatables-projects table border-top">
                              <thead>
                                  <tr>
                                      {{-- <th>S/N</th> --}}
                                      <th>Subject</th>
                                      <th class="text-center">CA Name/Desc.</th>
                                      <th class="text-center">Marks</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @forelse ($submissions as $key => $submission)
                                      @php
                                          $marks = App\Models\Mark::with('subject')
                                              ->select('subject_id', 'type', 'marks', 'absent')
                                              ->where('school_id', $school->id)
                                              ->where('session_id', $school->session_id)
                                              ->where('term', $school->term)
                                              ->where('class_id', $child->class_id)
                                              ->where('student_id', $child->id)
                                              ->where('subject_id', $submission->subject_id)
                                              ->where('type', $submission->marks_category)
                                              ->first();
                                      @endphp
              
                                      @if (!empty($marks->subject->name))
                                          <tr>
                                              {{-- <td>{{ $key +1 }}</td> --}}
                                              <td>{{ $marks->subject->name }}</td>
                                              <td class="text-center">{{ $marks->type }}</td>
                                              <td class="text-center">{{ $marks->marks }}</td>
                                          </tr>
                                      @endif
                                  @empty
                                      <tr>
                                          <td colspan="4">No Marks Submitted Yet</td>
                                      </tr>
                                  @endforelse
                              </tbody>
                          </table>
                      </div>
                      <div class="text-center mt-3">
                        <a href="javascript:;">View all marks</a>
                      </div>
                  </div>
              @endforeach
              
                </div>
              </div>
         
        </div>
      </div>
      <!--/ account numbers -->
      <div class="row">
        <div class="card card-action mb-4">
          <div class="card-header align-items-center">
            <h5 class="card-action-title mb-0">Reserved Account Numbers</h5>
            <div class="card-action-element">
              <button
                class="btn btn-secondary btn-sm"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#howtofund"
              >
                <i class="ti ti- ti-xs me-1"></i>How to Add Funds
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="added-cards">

              @if (is_array($accounts) && count($accounts) > 0)
                @foreach ($accounts as $account)
                  <div class="cardMaster border p-3 rounded mb-3">
                    <div class="d-flex justify-content-between flex-sm-row flex-column">
                      <div class="card-information">
                        @php
                          $src = '';
                          $alt = '';
                           if($account['bankName'] == 'Sterling bank')
                           {
                            $src = 'sterling.jpeg';
                            $alt = 'Sterling Bank';
                           }
                           if($account['bankName'] == 'Wema bank')
                           {
                            $src = 'wema.jpeg';
                            $alt = 'Wema Bank';
                           }
                        @endphp
                        <img
                          class="mb- img-fluid"
                          src="/{{ $src }}"
                          alt="{{ $alt }}" width="100">
                        <h6 class="mb-2 pt-1">{{ $account['accountNumber'] }}</h6>
                        <span class="card-number"> {{ $account['accountName'] }}</span>
                      </div>
                      <div class="d-flex flex-column text-start text-lg-end">
                        <div class="d-flex order-sm-0 order-1 mt-3">
                          <button
                            class="btn btn-label-primary me-3"
                            data-bs-toggle="modal"
                            data-bs-target="#editCCModal"
                          >
                            Copy
                          </button>
                        </div>
                        <small class="mt-sm-auto mt-2 order-sm-1 order-0">Charges N50 for all Transactions</small>
                      </div>
                    </div>
                  </div>
                @endforeach
              @endif
             
            </div>
          </div>
        </div>
      </div>
     
    </div>
  </div>
</div>


   <!-- how to add funds instruction -->
   <div class="modal fade" id="howtofund" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="text-center mb-4">
            <h3 class="mb-2">How to fund your wallet via your Reserved Accounts</h3>
            <p class="text-muted">Follow the instructions below</p>
          </div>
         <ol>
          <li>Copy and of the account numbers</li>
          <li>Make a transfer of the desired amount via your Bank App to the selected account number</li>
          <li>Refresh this page and you will see the balance on your wallet reflected</li>
          <li>If it didnt drop immediately, wait few more minutes it will drop</li>
          <li>After successful transaction, you may continue to pay your school fees</li>
         </ol>
         <div class="col-12 text-center">
          <button
            type="reset"
            class="btn btn-label-secondary btn-reset"
            data-bs-dismiss="modal"
            aria-label="Close"
          >
            Okay
          </button>
        </div>

        </div>
      </div>
    </div>
  </div>
@endsection
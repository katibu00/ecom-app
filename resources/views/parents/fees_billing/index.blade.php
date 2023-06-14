@extends('layouts.app')
@section('PageTitle', 'Fees & Billing')

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
                            <div class="mb-xl-0 mb-4">
                                <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                                    {{-- <svg width="32" height="22" viewBox="0 0 32 22" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                                            fill="#7367F0" />
                                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                            d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                                            fill="#161616" />
                                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                                            fill="#161616" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                                            fill="#7367F0" />
                                    </svg> --}}

                                    <span class="app-branld-text fw-bold fs-4"> {{ $school->name }} </span>
                                </div>
                                <p class="mb-2">{{ $school->address }}</p>
                                <p class="mb-2">{{ $school->website . ' || ' . $school->email }}</p>
                                <p class="mb-0">
                                    {{ $school->phone_first . ' ' . $school->phone_second ? ' ,' . $school->phone_second : '' }}
                                </p>
                            </div>
                            {{-- <div>
                                <h4 class="fw-semibold mb-2">INVOICE #86423</h4>
                                <div class="mb-2 pt-1">
                                    <span>Date Issues:</span>
                                    <span class="fw-semibold">April 25, 2021</span>
                                </div>
                                <div class="pt-1">
                                    <span>Date Due:</span>
                                    <span class="fw-semibold">May 25, 2021</span>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row p-sm-3 p-0">
                            @php
                                $user = auth()->user();
                                $total_mandatory = 0;
                                $total_optional = 0;
                                $total_pre_balance = 0;
                                $total_discount = 0;
                                $total_invoices = 0;
                                $total_paid = 0;
                                $total_amount_due = 0;
                            @endphp
                            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                <h6 class="mb-3">Invoice To:</h6>
                                <p class="mb-1">{{ $user->first_name . ' ' . $user->last_name }}</p>
                                <p class="mb-1">{{ $user->address }}</p>
                                <p class="mb-1">{{ $user->phone }}</p>
                                <p class="mb-1">{{ $user->email }}</p>
                            </div>
                            <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                {{-- <h6 class="mb-4">Bill To:</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-4">Total Due:</td>
                                            <td><strong>$12,110.55</strong></td>
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
                                </table> --}}
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive border-top">
                        @foreach ($children as $child)
                            @php
                                $invoice = App\Models\Invoice::select('id', 'student_type', 'discount', 'pre_balance')
                                    ->where('school_id', $school->id)
                                    ->where('session_id', $school->session_id)
                                    ->where('term', $school->term)
                                    ->where('class_id', $child->class_id)
                                    ->where('student_id', $child->id)
                                    ->first();
                                $fees = App\Models\FeeStructure::with('fee_category')
                                    ->select('fee_category_id', 'amount', 'priority')
                                    ->where('school_id', $school->id)
                                    ->where('class_id', $child->class_id)
                                    ->where('student_type', @$invoice->student_type)
                                    ->get();
                                $total_paid += App\Models\PaymentRecord::select('paid_amount')
                                    ->where('student_id', $child->id)
                                    ->where('school_id', $school->id)
                                    ->where('session_id', $school->session_id)
                                    ->where('term',  $school->term)
                                    ->sum('paid_amount');
                                $paymentSlip = App\Models\PaymentSlip::select('payable')
                                    ->where('student_id', $child->id)
                                    ->where('school_id', $school->id)
                                    ->where('session_id', $school->session_id)
                                    ->where('term',  $school->term)
                                    ->first();
                                $sub_total = 0;
                                $discount = 0;
                                $pre_balance = 0;
                                $total_amount_due += @$paymentSlip->payable;
                            @endphp
                            <table class="table m-0">
                                <caption class="fs-bold mx-3">
                                    <strong>{{ $child->first_name . ' ' . $child->middle_name . ' ' . $child->last_name }}</strong>
                                </caption>
                                <thead>
                                    <tr class="bg-info text-white">
                                        <th></th>
                                        <th>S/N</th>
                                        <th>Item</th>
                                        <th>Priority</th>
                                        <th>Cost (&#8358;)</th>
                                    </tr>
                                </thead>
                               
                                <tbody>
                                    @forelse ($fees as $key2 => $fee)
                                        <tr>
                                            <td></td>
                                            <td>{{ $key2 + 1 }}</td>
                                            <td class="text-nowrap">{{ @$fee->fee_category->name }}</td>
                                            <td>
                                                @if (@$fee->priority == 'm')
                                                    Mandatory
                                                @elseif(@$fee->priority == 'o')
                                                    Optional
                                                @elseif(@$fee->priority == 'r')
                                                    Recommended
                                                @endif
                                            </td>
                                            <td>{{ number_format($fee->amount, 0) }}</td>
                                            @php
                                                $sub_total += $fee->amount;
                                               
                                                if(@$fee->priority == 'm')
                                                {
                                                    $total_mandatory += $fee->amount;
                                                }
                                               else
                                                {
                                                    $total_optional += $fee->amount;
                                                }
                                            @endphp
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No Fee Structure For the student Class</td>
                                        </tr>
                                    @endforelse


                                    <tr>
                                        <td colspan="3" class="align-top px-4 py-4">
                                        </td>
                                        <td class="text-end pe-3 py-4">
                                            <p class="mb-2 pt-3">Subtotal:</p>
                                            <p class="mb-2">Discount:</p>
                                            <p class="mb-2">Previous Balance:</p>
                                            <p class="mb-0 pb-3">Total:</p>
                                        </td>
                                        <td class="ps-2 py-4">
                                            <p class="fw-semibold mb-2 pt-3">&#8358;{{ number_format($sub_total, 0) }}</p>
                                            <p class="fw-semibold mb-2">&#8358;{{ number_format(@$invoice->discount, 0) }}
                                            </p>
                                            <p class="fw-semibold mb-2">
                                                &#8358;{{ number_format(@$invoice->pre_balance, 0) }}</p>
                                            <p class="fw-semibold mb-0 pb-3">
                                                &#8358;{{ number_format($sub_total + @$invoice->pre_balance - @$invoice->discount, 0) }}
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @php
                                $total_invoices += $sub_total;
                                $total_discount += $invoice->discount;
                                $total_pre_balance += $invoice->pre_balance;
                            @endphp
                        @endforeach
                    </div>

                    <div class="card-body mx-3">
                        <div class="row">
                            <div class="col-12">
                                <span class="fw-semibold">Note:</span>
                                <span>Late Payment may attract Late Fees Charges. Thank You!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Invoice Actions -->
            <div class="col-xl-3 col-md-4 col-12 invoice-actions">
                <div class="card">
                    <div class="card-body">

                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-2 text-success">
                                    <span class="fw-semibold me-1">Wallet Balance:</span>
                                    <span> &#8358;{{ number_format(auth()->user()->wallet->balance,2) }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="fw-semibold me-1">Total Invoice(s):</span>
                                    <span>&#8358;{{ number_format(@$total_invoices, 0) }}</span>
                                </li>
                                <li class="mb-2 pt-1">
                                    <span class="fw-semibold me-1">Total Mandatory: </span>
                                    <span> {{ number_format(@$total_mandatory, 0) }}</span>
                                </li>
                                <li class="mb-2 pt-1">
                                    <span class="fw-semibold me-1">Total Due: </span>
                                    <span> {{ number_format(@$total_amount_due, 0) }}</span>
                                </li>
                                <li class="mb-2 pt-1">
                                    <span class="fw-semibold me-1">Discount:</span>
                                    <span>{!! $total_discount != 0?'&#8358;'.number_format(@$total_discount,0): ' - ' !!}</span>
                                </li>
                                <li class="mb-2 pt-1">
                                    <span class="fw-semibold me-1">Previous Balance:</span>
                                    {!! $total_pre_balance != 0?'&#8358;'.number_format(@$total_pre_balance,0): ' - ' !!}
                                </li>
                                <li class="mb-2 pt-1">
                                    <span class="fw-semibold me-1">Total Amount Paid:</span>
                                    <span>{!! @$total_paid != 0?'&#8358;'.number_format(@$total_paid,0): ' - ' !!}</span>
                                </li>
                                {{-- <li class="mb-2 pt-1">
                                    <span class="fw-semibold me-1">Balance:</span>
                                    <span>&#8358;{{ number_format($total_invoices+$total_pre_balance-$total_discount-$total_paid) }}</span>
                                </li> --}}
                            </ul>
                        </div>

                        <button class="btn btn-primary d-grid w-100" data-bs-toggle="modal" data-bs-target="#largeModal">
                            <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                    class="ti ti-currency-dollar ti-xs me-1"></i>Proceed to Payment</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHoose optional Modal -->
        <div class="modal fade" id="largeModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Choose Optional Fees</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        @foreach ($children as $child)
                        @php
                           
                            $optionals = App\Models\FeeStructure::with('fee_category')
                                ->select('id','fee_category_id', 'amount', 'priority')
                                ->where('school_id', $school->id)
                                ->where('class_id', $child->class_id)
                                ->where('student_type', @$invoice->student_type)
                                ->where('priority','!=','m')
                                ->get();
                        @endphp


                        <div class="col-lg-12">
                            <div class="demo-inline-spacing mt-3">
                                <div class="list-group">
                                    <label class="list-group-item bg-secondary text-white">
                                        {{ $child->first_name . ' ' . $child->middle_name . ' ' . $child->last_name }}
                                    </label>
                                    @foreach ($optionals as $optional)
                                    @php
                                        $paymentSlip = App\Models\PaymentSlip::select('additional')
                                            ->where('school_id', $school->id)
                                            ->where('session_id', $school->session_id)
                                            ->where('term', $school->term)
                                            ->where('student_id', $child->id)
                                            ->first();
                                        $checked = '';
                                        if ($paymentSlip && in_array($optional->id, explode(',', $paymentSlip->additional))) {
                                            $checked = 'checked';
                                        }
                                    @endphp
                                    <label class="list-group-item">
                                        <input class="form-check-input me-1 optional" type="checkbox" value="" data-student_id="{{ $child->id }}" data-fee_id="{{ @$optional->id }}" data-amount="{{ @$optional->amount }}" data-invoice_id="{{ @$invoice->id }}" {!! $checked !!} />
                                        {!! @$optional->fee_category->name.'  (&#8358;'.number_format($optional->amount,0).')' !!} 
                                    </label>
                                @endforeach
                            
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <p class="m-0">Total Payable: &#8358;<span class="total_mandatory">{{ number_format($total_amount_due,0) }}</span></p>
                        <div>
                          <button type="button" class="btn btn-label-secondary me-2" data-bs-dismiss="modal">
                            Close
                          </button>
                          {{-- <button type="button" class="btn btn-primary">Proceed to Checkout</button> --}}

                          <button class="btn btn-primary" data-bs-target="#paymentMethodModal" data-bs-toggle="modal">
                            Proceed to Checkout
                          </button>

                        </div>
                      </div>
                      
                    
                </div>
            </div>
        </div>

         <!-- proceed to payment -->
         <div class="modal fade" id="paymentMethodModal" data-bs-backdrop="static" tabindex="-2" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
              <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  <div class="text-center mb-4">
                    <h3 class="mb-2">Choose Payment Method</h3>
                    {{-- <p>Bank Transfer payment will take time before .</p> --}}
                  </div>
                  <form id="" class="row g-3" action="{{ route('proceed_payment') }}" method="post">
                    @csrf
                    <div class="col-sm-8">
                      <label class="form-label" for="choosePlan">Choose Payment Method</label>
                      <select id="choosePlan" name="payment_method" class="form-select" aria-label="Choose Payment Method" required>
                        <option value=""></option>
                        <option value="bank">Bank Transfer</option>
                        <option value="wallet">Wallet</option>
                        <option value="paystack">Paystack</option>
                      </select>
                    </div>
                    <div class="col-sm-4 d-flex align-items-end">
                      <button type="submit" class="btn btn-primary">Pay Now</button>
                    </div>
                  </form>
                </div>
                <hr class="mx-md-n5 mx-n3" />
                <div class="modal-body">
                  <p class="mb-0">You are about to pay the sum of:</p>
                  <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex justify-content-center me-2">
                      <sup class="h6 pricing-currency pt-1 mt-3 mb-0 me-1 text-primary">&#8358;</sup>
                      <h1 class="display-5 mb-0 text-primary total_mandatory">{{ number_format($total_amount_due,0) }}</h1>
                      {{-- <sub class="h5 pricing-duration mt-auto mb-2 text-muted">/month</sub> --}}
                    </div>
                    {{-- <button class="btn btn-label-danger cancel-subscription mt-3" data-bs-dismiss="modal">Close</button> --}}
                  </div>
                </div>
              </div>
            </div>
        </div>


    </div>

@endsection

@section('js')
@include('parents.fees_billing.script')
@endsection


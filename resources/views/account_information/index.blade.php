@extends('layouts.app')

@section('PageTitle', 'Account Information')

@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Subscription Details</div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Number of students</th>
                                    <th scope="col">Plan</th>
                                    <th scope="col">Price per student</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            @php
                                $subscription = $school->subscriptions()->latest()->first();
                                $pricePlanName = $subscription->plan->name;
                                $pricePlanPrice = $subscription->plan->price;
                                $discount = $pricePlanPrice * 20 / 100;
                                $total = $pricePlanPrice - $discount;

                                $paymentMade = $subscription->plan_id !== 1;

                                if ($paymentMade) {
                                    $paymentStatus = 'Payment made';
                                    $paymentColor = 'bg-success';
                                } else {
                                    $paymentStatus = 'Payment not made';
                                    $paymentColor = 'bg-danger';
                                }

                            @endphp 
                            <tbody>
                                <tr>
                                    <td>{{ number_format($school->students->count(),0) }}</td>
                                    <td>{{ $pricePlanName }}</td>
                                    <td>₦{{ $pricePlanPrice }}</td>
                                    <td>₦{{ $total }}</td>
                                </tr>
                                @if($subscription->discount !== null)
                                <tr>
                                    <td colspan="1"></td>
                                    <td colspan="2" class="text-right">Discount (20%)</td>
                                    <td>₦{{ number_format($discount,0) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="3">Total</td>
                                    <td>₦{{ number_format($total - $discount,0) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
        
        
                        <p class="mt-2">School Details:</p>
                        <ul>
                            <li><span class="fw-bold">Current session:</span> {{ $school->session->name }}</li>
                            <li><span class="fw-bold">Current term:</span> {{ ucfirst($school->term).' Term' }}</li>
                        </ul>
                        <p>Current Plan:</p>
                        <ul>
                            <li>{{ $pricePlanName.' Plan' }}</li>
                        </ul>
                        <p>Benefits of upgrading:</p>
                        <ul>
                            <li>More features</li>
                            <li>More benefits</li>
                            <li>Better support</li>
                        </ul>
                        <p class="card-text d-flex justify-content-between align-items-center">
                            <label for="payment-status" class="fw-bold">Payment status:</label>
                            <span class="badge {{ $paymentColor }}">{{ $paymentStatus }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Payment Options</div>
                    <div class="card-body">
        
                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#upgrade-plan-modal">Upgrade plan</button>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#pay-offline-modal">Pay offline through bank transfer</button>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#pay-online-modal">Pay online</button>
                        </div>
                    </div>
        
                </div>
            </div>
        
        </div>
        
    </div>

    <!-- Pay offline modal -->
    <div class="modal fade" id="pay-offline-modal" tabindex="-1" aria-labelledby="pay-offline-modal-label"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pay-offline-modal-label">Pay offline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please make your payment to the following bank account:</p>
                    <ul>
                        <li>Account name: School Management System</li>
                        <li>Account number: 1234567890</li>
                        <li>Bank name: Bank of America</li>
                    </ul>
                    <p>Please include your school name and student ID in the payment memo.</p>
                    <p>You will receive a confirmation email once your payment has been processed.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Pay online modal -->
    <div class="modal fade" id="pay-online-modal" tabindex="-1" aria-labelledby="pay-online-modal-label"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pay-online-modal-label">Pay online</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>You are about to pay $1000 for a school term.</p>
                    <p>Would you like to pay for a term or for a session?</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pay_for" id="pay-for-term" value="term">
                        <label class="form-check-label" for="pay-for-term">Pay for a term</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pay_for" id="pay-for-session" value="session">
                        <label class="form-check-label" for="pay-for-session">Pay for a session</label>
                    </div>
                    <p>You will be redirected to a secure payment processor to complete your transaction.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Pay online</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Upgrade plan modal -->
    <div class="modal fade" id="upgrade-plan-modal" tabindex="-1" aria-labelledby="upgrade-plan-modal-label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="upgrade-plan-modal-label">Upgrade plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Current plan</h5>
                            <ul>
                                <li>Plan name: Premium</li>
                                <li>Price: $1000/term</li>
                                <li>Number of students: 10</li>
                                <li>Features: All features</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Upgrade plans</h5>
                            <ul>
                                <li>
                                    <input type="radio" name="plan" id="plan-basic" value="basic" disabled>
                                    <label for="plan-basic">Basic</label>
                                    <ul>
                                        <li>Plan name: Basic</li>
                                        <li>Price: $500/term</li>
                                        <li>Number of students: 5</li>
                                        <li>Features: Basic features</li>
                                    </ul>
                                </li>
                                <li>
                                    <input type="radio" name="plan" id="plan-standard" value="standard">
                                    <label for="plan-standard">Standard</label>
                                    <ul>
                                        <li>Plan name: Standard</li>
                                        <li>Price: $750/term</li>
                                        <li>Number of students: 7</li>
                                        <li>Features: All basic features +</li>
                                        <li>- More storage</li>
                                        <li>- More users</li>
                                        <li>- Priority support</li>
                                    </ul>
                                </li>
                                <li>
                                    <input type="radio" name="plan" id="plan-premium" value="premium">
                                    <label for="plan-premium">Premium</label>
                                    <ul>
                                        <li>Plan name: Premium</li>
                                        <li>Price: $1000/term</li>
                                        <li>Number of students: 10</li>
                                        <li>Features: All basic and standard features +</li>
                                        <li>- Unlimited storage</li>
                                        <li>- Unlimited users</li>
                                        <li>- 24/7 support</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




@endsection

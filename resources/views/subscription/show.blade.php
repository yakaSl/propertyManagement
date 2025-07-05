@extends('layouts.app')
@section('page-title')
    {{__('Subscription')}}
@endsection
@push('script-page')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).on('click', '.have_coupon', function () {
            var element = $(this).parent().parent().parent().parent().parent().find('.coupon_div');
            if ($(this).is(":checked")) {
                $(element).removeClass('d-none');
            } else {
                $(element).addClass('d-none');
            }
        });

        $(document).on('click', '.packageCouponApplyBtn', function () {
            var element = $(this);
            var couponCode = element.closest('.row').find('.packageCouponCode').val();
            $.ajax({
                url: '{{route('coupons.apply')}}',
                datType: 'json',
                data: {
                    package: '{{\Illuminate\Support\Facades\Crypt::encrypt($subscription->id)}}',
                    coupon: couponCode
                },
                success: function (result) {
                    $('.discoutedPrice').text(result.discoutedPrice);
                    if (result != '') {
                        if (result.status == true) {
                            toastrs('success', result.msg, 'success');
                        } else {
                            toastrs('Error', result.msg, 'error');
                        }
                    } else {
                        toastrs('Error', "{{__('Please enter coupon code.')}}", 'error');
                    }
                }
            })
        });
    </script>

    <script>
        @if($settings['STRIPE_PAYMENT'] == 'on' && !empty($settings['STRIPE_KEY']) && !empty($settings['STRIPE_SECRET']))
        var stripe_key = Stripe('{{ $settings['STRIPE_KEY'] }}');
        var stripe_elements = stripe_key.elements();
        var strip_css = {
            base: {
                fontSize: '14px',
                color: '#32325d',
            },
        };
        var stripe_card = stripe_elements.create('card', {style: strip_css});
        stripe_card.mount('#card-element');

        var stripe_form = document.getElementById('stripe-payment-form');
        stripe_form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe_key.createToken(stripe_card).then(function (result) {
                if (result.error) {
                    $("#stripe_card_errors").html(result.error.message);
                    $.NotificationApp.send("Error", result.error.message, "top-right", "rgba(0,0,0,0.2)", "error");
                } else {
                    var token = result.token;
                    var stripeForm = document.getElementById('stripe-payment-form');
                    var stripeHiddenData = document.createElement('input');
                    stripeHiddenData.setAttribute('type', 'hidden');
                    stripeHiddenData.setAttribute('name', 'stripeToken');
                    stripeHiddenData.setAttribute('value', token.id);
                    stripeForm.appendChild(stripeHiddenData);
                    stripeForm.submit();
                }
            });
        });

        @endif

    </script>

@endpush
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('subscriptions.index')}}">{{__('Subscription')}}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Details')}}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row pricing-grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border ">
                        <thead>
                        <tr>
                            <th>{{__('Title')}}</th>
                            <th>{{__('Amount')}}</th>
                            <th>{{__('Interval')}}</th>
                            <th>{{__('User Limit')}}</th>
                            <th>{{__('Property Limit')}}</th>
                            <th>{{__('Tenant Limit')}}</th>
                            <th>{{__('Coupon Applicable')}}</th>
                            <th>{{__('User Logged History')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                {{ $subscription->title }}
                            </td>
                            <td>
                                <b class="discoutedPrice"> {{subscriptionPaymentSettings()['CURRENCY_SYMBOL']}}{{ $subscription->package_amount}}</b>
                            </td>
                            <td>{{$subscription->interval}} </td>
                            <td>{{$subscription->user_limit}} </td>
                            <td>{{$subscription->property_limit}}</td>
                            <td>{{$subscription->tenant_limit}}</td>
                            <td>
                                @if($subscription->couponCheck()>0)
                                    <i class="text-success mr-4" data-feather="check-circle"></i>
                                @else
                                    <i class="text-danger mr-4" data-feather="x-circle"></i>
                                @endif
                            </td>
                            <td>
                                @if($subscription->enabled_logged_history==1)
                                    <i class="text-success mr-4" data-feather="check-circle"></i>
                                @else
                                    <i class="text-danger mr-4" data-feather="x-circle"></i>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="row pricing-grid">
        <div class="col-lg-12">
            <div class="row">
                @if($settings['bank_transfer_payment'] == 'on')
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{__('Bank Transfer Payment')}}</h5>
                                @if($subscription->couponCheck()>0)
                                    <div class="setting-card action-menu">
                                        <div class="form-group">
                                            <div class="form-check custom-chek">
                                                <input class="form-check-input have_coupon" type="checkbox" value=""
                                                       id="have_bank_tran_coupon">
                                                <label class="form-check-label"
                                                       for="have_bank_tran_coupon">{{__('Have a Discount Coupon Code?')}} </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body profile-user-box">
                                <form
                                    action="{{ route('subscription.bank.transfer',\Illuminate\Support\Facades\Crypt::encrypt($subscription->id)) }}"
                                    method="post" class="require-validation" id="bank-payment"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="card-name-on"
                                                       class="form-label text-dark">{{__('Bank Name')}}</label>
                                                <p>{{$settings['bank_name']}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="card-name-on"
                                                       class="form-label text-dark">{{__('Bank Holder Name')}}</label>
                                                <p>{{$settings['bank_holder_name']}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="card-name-on"
                                                       class="form-label text-dark">{{__('Bank Account Number')}}</label>
                                                <p>{{$settings['bank_account_number']}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="card-name-on"
                                                       class="form-label text-dark">{{__('Bank IFSC Code')}}</label>
                                                <p>{{$settings['bank_ifsc_code']}}</p>
                                            </div>
                                        </div>
                                        @if(!empty($settings['bank_other_details']))
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="card-name-on"
                                                           class="form-label text-dark">{{__('Bank Other Details')}}</label>
                                                    <p>{{$settings['bank_other_details']}}</p>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-md-12 d-none coupon_div">
                                            <div class="form-group">
                                                <label for="card-name-on"
                                                       class="form-label text-dark">{{__('Coupon Code')}}</label>
                                                <input type="text" name="coupon"
                                                       class="form-control required packageCouponCode"
                                                       placeholder="{{__('Enter Coupon Code')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="card-name-on"
                                                       class="form-label text-dark">{{__('Attachment')}}</label>
                                                <input type="file" name="payment_receipt" id="payment_receipt"
                                                       class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 ">
                                            <input type="button" value="{{__('Coupon Apply')}}"
                                                   class="btn btn-warning packageCouponApplyBtn d-none coupon_div">
                                            <input type="submit" value="{{__('Pay')}}" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                @if($settings['STRIPE_PAYMENT'] == 'on' && !empty($settings['STRIPE_KEY']) && !empty($settings['STRIPE_SECRET']))
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{__('Stripe Payment')}}</h5>
                                @if($subscription->couponCheck()>0)
                                    <div class="setting-card action-menu">
                                        <div class="form-group">
                                            <div class="form-check custom-chek">
                                                <input class="form-check-input have_coupon" type="checkbox" value=""
                                                       id="have_stripe_coupon">
                                                <label class="form-check-label"
                                                       for="have_stripe_coupon">{{__('Have a Discount Coupon Code?')}} </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body profile-user-box">
                                <form
                                    action="{{ route('subscription.stripe.payment',\Illuminate\Support\Facades\Crypt::encrypt($subscription->id)) }}"
                                    method="post" class="require-validation" id="stripe-payment-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="card-name-on"
                                                       class="form-label text-dark">{{__('Card Name')}}</label>
                                                <input type="text" name="name" id="card-name-on"
                                                       class="form-control required"
                                                       placeholder="{{__('Card Holder Name')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="card-name-on"
                                                   class="form-label text-dark">{{__('Card Details')}}</label>
                                            <div id="card-element">
                                            </div>
                                            <div id="stripe_card_errors" role="alert"></div>
                                        </div>

                                        @if($subscription->couponCheck()>0)
                                            <div class="col-md-12 d-none coupon_div">
                                                <div class="form-group">
                                                    <label for="card-name-on"
                                                           class="form-label text-dark">{{__('Coupon Code')}}</label>
                                                    <input type="text" name="coupon"
                                                           class="form-control required packageCouponCode"
                                                           placeholder="{{__('Enter Coupon Code')}}">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-sm-12 mt-15">
                                            @if($subscription->couponCheck()>0)
                                                <input type="button" value="{{__('Coupon Apply')}}"
                                                       class="btn btn-warning packageCouponApplyBtn d-none coupon_div">
                                            @endif
                                            <input type="submit" value="{{__('Pay')}}" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                @if($settings['paypal_payment'] == 'on' && !empty($settings['paypal_client_id']) && !empty($settings['paypal_secret_key']))
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{__('Paypal Payment')}}</h5>
                                @if($subscription->couponCheck()>0)
                                    <div class="setting-card action-menu">
                                        <div class="form-group">
                                            <div class="form-check custom-chek">
                                                <input class="form-check-input have_coupon" type="checkbox" value=""
                                                       id="have_paypal_coupon">
                                                <label class="form-check-label"
                                                       for="have_paypal_coupon">{{__('Have a Discount Coupon Code?')}} </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body profile-user-box">
                                <form
                                    action="{{ route('subscription.paypal',\Illuminate\Support\Facades\Crypt::encrypt($subscription->id)) }}"
                                    method="post" class="require-validation">
                                    @csrf
                                    <div class="row">
                                        @if($subscription->couponCheck()>0)
                                            <div class="col-md-12 mt-15 d-none coupon_div">
                                                <div class="form-group">
                                                    <label for="card-name-on"
                                                           class="form-label text-dark">{{__('Coupon Code')}}</label>
                                                    <input type="text" name="coupon"
                                                           class="form-control required packageCouponCode"
                                                           placeholder="{{__('Enter Coupon Code')}}">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-sm-12 mt-15">
                                            @if($subscription->couponCheck()>0)
                                                <input type="button" value="{{__('Coupon Apply')}}"
                                                       class="btn btn-warning packageCouponApplyBtn d-none coupon_div">
                                            @endif
                                            <input type="submit" value="{{__('Pay')}}" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


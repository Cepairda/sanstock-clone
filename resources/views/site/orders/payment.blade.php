@extends('layouts.site')
@section('body_class', 'checkout')
@section('meta_title', __('Checkout title'))
@section('meta_description',  __('Checkout description'))

@section('breadcrumbs')

    <li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name">
           Оплата заказа
        </span>
        <meta itemprop="position" content="3"/>
    </li>

@endsection

@section('content')

    <main class="main-container">
        @include('site.components.breadcrumbs')

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-12">

                    <div class="main-container__title">

                        <h1 class="">Оплата заказа #{{ $order_id }}</h1>

                    </div>
                    <div id="GooglePay"></div>

                </div>

                <div class="col-8">
                    <div class="main__contacts-form" style="height: 980px">

                        <div style="width:100%; height:100%; margin:0 auto;">
                            <iframe src="{{ route('site.payment-form') }}" seamless name="frame" id="frame" width="100%" height="100%" frameborder="0" scrolling="no" style="overflow: hidden;"></iframe>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <script
        async
        src="https://pay.google.com/gp/p/js/pay.js"
        onload="showGoogleButton(); console.log('TODO: add onload function')">
    </script>

    <script>
        {{ session()->keep(['order']) }}
        // redirect bank card payment
        window.onmessage = function(event){
            if (event.data === 'success') {
                document.location.href = '{{ route('site.move-to-success-checkout-page') }}';
            }
        };

        // GOOGLE PAY API
        // Google version
        const baseRequest = {
            apiVersion: 2,
            apiVersionMinor: 0
        };

        const tokenizationSpecification = {
            type: 'PAYMENT_GATEWAY',
            {{--parameters: {--}}
            {{--    'gateway': 'platon',--}}
            {{--    'gatewayMerchantId': '{{ env('PLATON_PAYMENT_KEY') }}'--}}
            {{--}--}}
        };

        const allowedCardNetworks = ['MASTERCARD', 'VISA'];

        const allowedCardAuthMethods = ['PAN_ONLY', 'CRYPTOGRAM_3DS'];

        const baseCardPaymentMethod = {
            type: 'CARD',
            parameters: {
                allowedAuthMethods: allowedCardAuthMethods,
                allowedCardNetworks: allowedCardNetworks
            }
        };

        const cardPaymentMethod = Object.assign(
            {tokenizationSpecification: tokenizationSpecification},
            baseCardPaymentMethod
        );


        // function showGoogleButton() {
        //
        //     const paymentsClient =
        //         new google.payments.api.PaymentsClient({environment: 'TEST'});
        //
        //     const isReadyToPayRequest = Object.assign({}, baseRequest);
        //     isReadyToPayRequest.allowedPaymentMethods = [baseCardPaymentMethod];
        //
        //     paymentsClient.isReadyToPay(isReadyToPayRequest)
        //         .then(function(response) {
        //             if (response.result) {
        //                 // add a Google Pay payment button
        //                 console.log('add a Google Pay payment button');
        //                 const button =
        //                     paymentsClient.createButton({onClick: () => console.log('TODO: click handler')});
        //                 document.getElementById('GooglePay').appendChild(button);
        //             }
        //         })
        //         .catch(function(err) {
        //             // show error in developer console for debugging
        //             console.error(err);
        //         });
        // }

    </script>


    @section('javascript')
{{--        <script type="text/javascript" src="{{ mix('js/site/page/checkout.js') }}"></script>--}}
    @endsection

@endsection

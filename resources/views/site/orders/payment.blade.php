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

                </div>

                <div class="col-8">
                    <div class="main__contacts-form" style="height: 980px">

                        @foreach($paymentMethods as $key => $paymentMethod)

                            <div class="w-100">
                                <input type="radio" name="paymentType" value="{{ $key }}" class="mr-2" @if($key === $payment_method) checked @endif>{{ $paymentMethod }}
                                @if($key === 'google_pay') <div id="GooglePay"></div> @endif
                            </div>

                        @endforeach

                        <div style="width:100%; height:100%; margin:0 auto;">
                            <iframe src="@if($payment_method === 'bank_card'){{ route('site.payment-form') }}@endif" seamless name="frame" id="frame" width="100%" height="100%" frameborder="0" scrolling="no" style="overflow: hidden;"></iframe>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>

        // redirect bank card payment
        window.onmessage = function(event){
            if (event.data === 'success') {
                document.location.href = '{!! route('site.move-to-success-checkout-page', ['order_id' => $order_id, 'payment_method' => $payment_method]) !!} ';
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

        let paymentsClient = null;

        /**
         * Configure your site's support for payment methods supported by the Google Pay
         * API.
         *
         * Each member of allowedPaymentMethods should contain only the required fields,
         * allowing reuse of this base request when determining a viewer's ability
         * to pay and later requesting a supported payment method
         *
         * @returns {object} Google Pay API version, payment methods supported by the site
         */
        function getGoogleIsReadyToPayRequest() {
            return Object.assign(
                {},
                baseRequest,
                {
                    allowedPaymentMethods: [baseCardPaymentMethod]
                }
            );
        }

        /**
         * Configure support for the Google Pay API
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#PaymentDataRequest|PaymentDataRequest}
         * @returns {object} PaymentDataRequest fields
         */
        function getGooglePaymentDataRequest() {
            const paymentDataRequest = Object.assign({}, baseRequest);
            paymentDataRequest.allowedPaymentMethods = [cardPaymentMethod];
            // paymentDataRequest.transactionInfo = getGoogleTransactionInfo();
            paymentDataRequest.merchantInfo = {
                // @todo a merchant ID is available for a production environment after approval by Google
                // See {@link https://developers.google.com/pay/api/web/guides/test-and-deploy/integration-checklist|Integration checklist}
                // merchantId: '12345678901234567890',
                merchantName: 'Example Merchant'
            };
            return paymentDataRequest;
        }

        /**
         * Return an active PaymentsClient or initialize
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/client#PaymentsClient|PaymentsClient constructor}
         * @returns {google.payments.api.PaymentsClient} Google Pay API client
         */
        function getGooglePaymentsClient() {
            if ( paymentsClient === null ) {
                paymentsClient = new google.payments.api.PaymentsClient({environment: 'TEST'});
            }
            return paymentsClient;
        }

        /**
         * Initialize Google PaymentsClient after Google-hosted JavaScript has loaded
         *
         * Display a Google Pay payment button after confirmation of the viewer's
         * ability to pay.
         */
        function onGooglePayLoaded() {
            const paymentsClient = getGooglePaymentsClient();
            paymentsClient.isReadyToPay(getGoogleIsReadyToPayRequest())
                .then(function(response) {
                    if (response.result) {
                        addGooglePayButton();
                        // @todo prefetch payment data to improve performance after confirming site functionality
                        // prefetchGooglePaymentData();
                    }
                })
                .catch(function(err) {
                    // show error in developer console for debugging
                    console.error(err);
                });
        }

        /**
         * Add a Google Pay purchase button alongside an existing checkout button
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#ButtonOptions|Button options}
         * @see {@link https://developers.google.com/pay/api/web/guides/brand-guidelines|Google Pay brand guidelines}
         */
        function addGooglePayButton() {
            const paymentsClient = getGooglePaymentsClient();
            const button =
                paymentsClient.createButton({onClick: onGooglePaymentButtonClicked});
            document.getElementById('GooglePay').appendChild(button);
        }

        /**
         * Provide Google Pay API with a payment amount, currency, and amount status
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#TransactionInfo|TransactionInfo}
         * @returns {object} transaction info, suitable for use as transactionInfo property of PaymentDataRequest
         */
        // function getGoogleTransactionInfo() {
        //     return {
        //         countryCode: 'UA',
        //         currencyCode: 'UAH',
        //         totalPriceStatus: 'FINAL',
        //         // set to cart total
        //         totalPrice: '111.00'
        //     };
        // }

        /**
         * Prefetch payment data to improve performance
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/client#prefetchPaymentData|prefetchPaymentData()}
         */
        // function prefetchGooglePaymentData() {
        //     const paymentDataRequest = getGooglePaymentDataRequest();
        //     // transactionInfo must be set but does not affect cache
        //     paymentDataRequest.transactionInfo = {
        //         totalPriceStatus: 'NOT_CURRENTLY_KNOWN',
        //         currencyCode: 'USD'
        //     };
        //     const paymentsClient = getGooglePaymentsClient();
        //     paymentsClient.prefetchPaymentData(paymentDataRequest);
        // }

        /**
         * Show Google Pay payment sheet when Google Pay payment button is clicked
         */
        function onGooglePaymentButtonClicked() {
            const paymentDataRequest = getGooglePaymentDataRequest();
            //paymentDataRequest.transactionInfo = getGoogleTransactionInfo();

            const paymentsClient = getGooglePaymentsClient();
            paymentsClient.loadPaymentData(paymentDataRequest)
                .then(function(paymentData) {
                    // handle the response
                    processPayment(paymentData);
                })
                .catch(function(err) {
                    // show error in developer console for debugging
                    console.error(err);
                });
        }
        /**
         * Process payment data returned by the Google Pay API
         *
         * @param {object} paymentData response from Google Pay API after user approves payment
         * @see {@link https://developers.google.com/pay/api/web/reference/response-objects#PaymentData|PaymentData object reference}
         */
        function processPayment(paymentData) {
            // show returned data in developer console for debugging
            console.log(paymentData);
            // @todo pass payment token to your gateway to process payment
            let paymentToken = paymentData.paymentMethodData.tokenizationData.token;
        }

        function loadGooglePayPlaton() {
            document.getElementById('frame').src = '{{ route('site.google-pay-request-to-platon') }}';
        }

    </script>

    <script
        async
        src="https://pay.google.com/gp/p/js/pay.js"
        onload="onGooglePayLoaded(); console.log('TODO: add onload function')">
    </script>

    <script>

        function sentPaymentForm(route) {
            document.getElementById('frame').src = route;
        }

        @if($paymentMethod === 'bank_card')
            sentPaymentForm('{{ route('site.payment-form', ['success' => 'true']) }}');
        @else
            sentPaymentForm('');
        @endif

        let radios = document.querySelectorAll('[name="paymentType"]')

        for(let i = radios.length; i--;) {
            radios[i].addEventListener("change", function(e){
                let frame = document.getElementById('frame');
                if(e.target.value === 'bank_card') {

                    if(frame.classList.contains('d-none')) frame.classList.remove('d-none');
                    sentPaymentForm('{{ route('site.payment-form') }}');
                }
                else {
                    if(!frame.classList.contains('d-none')) frame.classList.add('d-none');
                }
            }, false);
        }

    </script>


    @section('javascript')
{{--        <script type="text/javascript" src="{{ mix('js/site/page/checkout.js') }}"></script>--}}
    @endsection

@endsection

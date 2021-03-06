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

    <script src="https://applepay.cdn-apple.com/jsapi/v1/apple-pay-sdk.js"></script>

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
                    <div class="main__contacts-form mb-2">

                        @foreach($paymentMethods as $key => $paymentMethod)

                            <div id="{{ $key }}" class="w-100">
                                <input type="radio" name="paymentType" value="{{ $key }}" class="mr-2" @if($key === $payment_method) checked @endif>{{ $paymentMethod }}

                                @if($key === 'google_pay')
                                    <div id="GooglePay" class="@if($payment_method !== 'google_pay') d-none @endif"></div>
                                @endif

                                @if($key === 'apple_pay')
                                    <div>
                                        <button type="button" id="ApplePay" style="width: 150px; height: 50px; display: none; border-radius: 5px; margin-left: auto; margin-right: auto; margin-top: 20px; background-image: -webkit-named-image(apple-pay-logo-white); background-position: 50% 50%; background-color: black; background-size: 60%; background-repeat: no-repeat;"></button>
                                        <p style="display:none" id="got_notactive">ApplePay is possible on this browser, but not currently activated.</p>
                                        <p style="display:none" id="notgot">Ваш браузер не поддерживает работу с ApplePay</p>
                                        <p style="display:none" id="success">Трансакция прошла успешно. Идет завершение оформления заказа ...</p>
                                    </div>

                                @endif

                            </div>

                        @endforeach
                    </div>

                    <div id="frame-container" class="main__contacts-form @if($payment_method !== 'bank_card') d-none @endif" style="height: 1140px">

                        <div style="width:100%; height:100%; margin:0 auto;">
                            <iframe src="" seamless name="frame" id="frame" width="100%" height="100%" frameborder="0" scrolling="no" style="overflow: hidden;"></iframe>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        let debug;
        @if($mode === 'TEST')
            debug = true;
        @else
            debug = false;
        @endif

        function logit(data) {
            if( debug == true ){
                console.log(data);
            }
        }

        function logitError(data) {
            if( debug == true ){
                console.error(data);
            }
        }

        let googlePayJsLoaded = false;

        document.cookie = "pay={{ $payment_method }}";

        let is_safari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

        if(!is_safari) {
            document.getElementById('apple_pay').remove();
        }
    </script>

    <script>
        document.cookie = "san={{ $order }}";

        // redirect bank card payment
        window.onmessage = function(event){
            if (event.data === 'success') {
                document.location.href = '{!! route('site.move-to-success-checkout-page', ['order_id' => $order_id, 'payment_method' => $payment_method]) !!} ';
            }
        };

    </script>

    <!-- GOOGLE PAY API -->
    <script>
        // Google version
        const baseRequest = {
            environment : 'PRODUCTION',
            apiVersion: 2,
            apiVersionMinor: 0
        };

        const tokenizationSpecification = {
            type: 'PAYMENT_GATEWAY',
            parameters: {
                'gateway': 'platon',
                'gatewayMerchantId': '{{ $platonPaymentKey }}'
            }
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
            paymentDataRequest.transactionInfo = getGoogleTransactionInfo();
            paymentDataRequest.merchantInfo = {
                // @todo a merchant ID is available for a production environment after approval by Google
                // See {@link https://developers.google.com/pay/api/web/guides/test-and-deploy/integration-checklist|Integration checklist}
                merchantId: '{{ $googlePayMerchantId }}',
                merchantName: '{{ $googlePayMerchantName }}'
            };
            logit(paymentDataRequest);
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
                paymentsClient = new google.payments.api.PaymentsClient({ environment: 'PRODUCTION' });
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

            if(document.cookie !== 'google_pay' || !googlePayJsLoaded) return;

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
                    logitError(err);
                    // console.error(err);
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
        function getGoogleTransactionInfo() {
            return {
                countryCode: 'UA',
                currencyCode: 'UAH',
                totalPriceStatus: 'FINAL',
                // set to cart total
                totalPrice: '{{ $total }}'
            };
        }

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
            paymentDataRequest.transactionInfo = getGoogleTransactionInfo();

            const paymentsClient = getGooglePaymentsClient();
            paymentsClient.loadPaymentData(paymentDataRequest)
                .then(function(paymentData) {
                    // handle the response
                    processPayment(paymentData);
                })
                .catch(function(err) {
                    // show error in developer console for debugging
                    logitError(err);
                    // console.error(err);
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
            logit(paymentData);
            // @todo pass payment token to your gateway to process payment
            let paymentToken = paymentData.paymentMethodData.tokenizationData.token;

            logit('PaymentToken: ');
            logit(paymentToken);

            document.cookie = "pay=google_pay";
            document.location.href = '{{ route('site.google-pay-request-to-platon') }}' + '?paymentToken=' + window.btoa(paymentToken) ;
        }

        function loadGooglePayPlaton() {
            document.getElementById('frame').src = '{{ route('site.google-pay-request-to-platon') }}';
        }

    </script>

    <script
        async
        src="https://pay.google.com/gp/p/js/pay.js"
        onload="googlePayJsLoaded = true; onGooglePayLoaded();">
    </script>

    <!-- Apple Pay -->
    <script>

        if(is_safari) {

            if (window.ApplePaySession) {
                var merchantIdentifier = '{{ $applePayMerchantId }}';
                var promise = ApplePaySession.canMakePaymentsWithActiveCard(merchantIdentifier);
                promise.then(function (canMakePayments) {
                    if (canMakePayments) {
                        document.getElementById("ApplePay").style.display = "block";
                        logit('Возможно совершить платеж с помощью Apple Pay');
                    } else {
                        document.getElementById("got_notactive").style.display = "block";
                        logit('ApplePay возможно использовать в этом браузере, но сэссия неверно активирована.');
                    }
                });
            } else {
                logit('ApplePay не возможно использовать в этом браузере');
                document.getElementById("notgot").style.display = "block";
            }

            document.getElementById("ApplePay").onclick = function(evt) {

                var runningAmount 	= '{{ $total }}';
                var runningPP		= 0; getShippingCosts('domestic_std', true);
                var runningTotal	= function() { return runningAmount; }
                var shippingOption = "";

                var subTotalDescr	= "Тестовая оплата заказа #{{ $order_id }}";

                function getShippingOptions(shippingCountry) {
                    logit('getShippingOptions: ' + shippingCountry );
                    if( shippingCountry.toUpperCase() == 'UA' ) {
                        shippingOption = [{label: 'Standard Shipping', amount: getShippingCosts('domestic_std', true), detail: '3-5 days', identifier: 'domestic_std'},{label: 'Expedited Shipping', amount: getShippingCosts('domestic_exp', false), detail: '1-3 days', identifier: 'domestic_exp'}];
                    } else {
                        shippingOption = [{label: 'International Shipping', amount: getShippingCosts('international', true), detail: '5-10 days', identifier: 'international'}];
                    }
                }

                function getShippingCosts(shippingIdentifier, updateRunningPP ){

                    var shippingCost = 0;

                    switch(shippingIdentifier) {
                        case 'domestic_std':
                            shippingCost = 0;
                            break;
                        case 'domestic_exp':
                            shippingCost = 6;
                            break;
                        case 'international':
                            shippingCost = 9;
                            break;
                        default:
                            shippingCost = 11;
                    }

                    if (updateRunningPP == true) {
                        runningPP = shippingCost;
                    }

                    logit('getShippingCosts: ' + shippingIdentifier + " - " + shippingCost +"|"+ runningPP );

                    return shippingCost;

                }

                var paymentRequest = {
                    currencyCode: 'UAH',
                    countryCode: 'UA',
                    requiredShippingContactFields: ['postalAddress'],
                    //requiredShippingContactFields: ['postalAddress','email', 'name', 'phone'],
                    //requiredBillingContactFields: ['postalAddress','email', 'name', 'phone'],
                    // lineItems: [{label: subTotalDescr, amount: runningAmount }, {label: 'P&P', amount: runningPP }],
                    lineItems: [{label: subTotalDescr, amount: runningAmount }],
                    total: {
                        label: '{{ $applePayMerchantName }}',
                        amount: runningTotal()
                    },
                    supportedNetworks: ['visa', 'masterCard', 'amex', 'discover'],
                    merchantCapabilities: ['supports3DS']
                };

                var session = new ApplePaySession(1, paymentRequest);

                // Merchant Validation
                session.onvalidatemerchant = function (event) {
                    logit(event);
                    var promise = performValidation(event.validationURL);
                    promise.then(function (merchantSession) {
                        session.completeMerchantValidation(merchantSession);
                    });
                }

                function performValidation(valURL) {
                    return new Promise(function(resolve, reject) {
                        var xhr = new XMLHttpRequest();
                        xhr.onload = function() {
                            var data = JSON.parse(this.responseText);
                            logit('Apple Pay validation session');
                            logit(data);
                            resolve(data);
                        };
                        xhr.onerror = reject;
                        xhr.open('GET', '{{ route('site.apple-pay-validation') }}?u=' + valURL);
                        xhr.send();
                    });
                }

                session.onshippingcontactselected = function(event) {
                    logit('starting session.onshippingcontactselected');
                    logit('NB: At this stage, apple only reveals the Country, Locality and 4 characters of the PostCode to protect the privacy of what is only a *prospective* customer at this point. This is enough for you to determine shipping costs, but not the full address of the customer.');
                    logit(event);

                    getShippingOptions( event.shippingContact.countryCode );

                    var status = ApplePaySession.STATUS_SUCCESS;
                    var newShippingMethods = shippingOption;
                    var newTotal = { type: 'final', label: '{{ $applePayMerchantName }}', amount: runningTotal() };
                    // var newLineItems =[{type: 'final',label: subTotalDescr, amount: runningAmount }, {type: 'final',label: 'P&P', amount: runningPP }];
                    var newLineItems =[{type: 'final',label: subTotalDescr, amount: runningAmount }];

                    session.completeShippingContactSelection(status, newShippingMethods, newTotal, newLineItems );
                }

                session.onshippingmethodselected = function(event) {
                    logit('starting session.onshippingmethodselected');
                    logit(event);

                    getShippingCosts( event.shippingMethod.identifier, true );

                    var status = ApplePaySession.STATUS_SUCCESS;
                    var newTotal = { type: 'final', label: '{{ $applePayMerchantName }}', amount: runningTotal() };
                    // var newLineItems =[{type: 'final',label: subTotalDescr, amount: runningAmount }, {type: 'final',label: 'P&P', amount: runningPP }];
                    var newLineItems =[{type: 'final',label: subTotalDescr, amount: runningAmount }];

                    session.completeShippingMethodSelection(status, newTotal, newLineItems );
                }

                session.onpaymentmethodselected = function(event) {
                    logit('starting session.onpaymentmethodselected');
                    logit(event);

                    var newTotal = { type: 'final', label: '{{ $applePayMerchantName }}', amount: runningTotal() };
                    // var newLineItems =[{type: 'final',label: subTotalDescr, amount: runningAmount }, {type: 'final',label: 'P&P', amount: runningPP }];
                    var newLineItems =[{type: 'final',label: subTotalDescr, amount: runningAmount }];

                    session.completePaymentMethodSelection( newTotal, newLineItems );
                }

                session.onpaymentauthorized = function (event) {

                    logit('starting session.onpaymentauthorized');
                    logit('NB: This is the first stage when you get the *full shipping address* of the customer, in the event.payment.shippingContact object');
                    logit(event);

                    var promise = sendPaymentToken(event.payment.token);
                    promise.then(function (success) {
                        var status;
                        if (success) {
                            status = ApplePaySession.STATUS_SUCCESS;
                            document.getElementById("ApplePay").style.display = "none";
                            document.getElementById("success").style.display = "block";

                            // Redirect on page success checkout !!!!!!
                        } else {
                            status = ApplePaySession.STATUS_FAILURE;
                        }

                        logit( "result of sendPaymentToken() function =  " + success );
                        session.completePayment(status);
                    });
                }

                function sendPaymentToken(paymentToken) {
                    return new Promise(function(resolve, reject) {
                        logit('starting function sendPaymentToken()');
                        logit(paymentToken);

                        logit("this is where you would pass the payment token to your third-party payment provider to use the token to charge the card. Only if your provider tells you the payment was successful should you return a resolve(true) here. Otherwise reject;");
                        logit("defaulting to resolve(true) here, just to show what a successfully completed transaction flow looks like");

                        document.cookie = "pay=apple_pay";
                        document.location.href = '{{ route('site.apple-pay-request-to-platon') }}' + '?paymentToken=' + window.btoa(JSON.stringify(paymentToken)) ;

                        if ( debug == true )
                            resolve(true);
                        else
                            reject;
                    });
                }

                session.oncancel = function(event) {
                    logit('starting session.cancel');
                    logit(event);
                }

                session.begin();
            };
        }

    </script>

    <script>

        function sentPaymentForm(route) {
            document.getElementById('frame').src = route;
        }

        @if($payment_method === 'bank_card')
           sentPaymentForm('{{ route('site.payment-form', ['success' => 'true']) }}');

        @else
            sentPaymentForm('{{ route('site.start-frame', ['success' => 'true']) }}');
        @endif
        // document.getElementById('frame').contentWindow.location.reload(true);

        let radios = document.querySelectorAll('[name="paymentType"]')

        for(let i = radios.length; i--;) {
            radios[i].addEventListener("change", function(e){
                let frame = document.getElementById('frame-container');
                let applePayButton = document.getElementById('ApplePay');
                let googlePayButton = document.getElementById('GooglePay');

                document.cookie = "pay=" + e.target.value;

                if(e.target.value === 'bank_card') {
                    if(frame.classList.contains('d-none')) frame.classList.remove('d-none');
                    if(is_safari && !applePayButton.classList.contains('d-none')) applePayButton.classList.add('d-none');
                    if(!googlePayButton.classList.contains('d-none')) googlePayButton.classList.add('d-none');
                    sentPaymentForm('{{ route('site.payment-form', ['success' => 'true']) }}');
                }
                else {
                    if(!frame.classList.contains('d-none')) frame.classList.add('d-none');
                    if(e.target.value === 'google_pay') {
                        onGooglePayLoaded();
                        if(is_safari && !applePayButton.classList.contains('d-none')) applePayButton.classList.add('d-none');
                        if(googlePayButton.classList.contains('d-none')) googlePayButton.classList.remove('d-none');
                    }
                    if(is_safari && e.target.value === 'apple_pay') {
                        if(!googlePayButton.classList.contains('d-none')) googlePayButton.classList.add('d-none');
                        if(applePayButton.classList.contains('d-none')) applePayButton.classList.remove('d-none');
                    }
                    //if(!frame.classList.contains('d-none')) frame.classList.add('d-none');
                }
            }, false);
        }

       //let oldDoc = document.getElementById('frame').contentDocument;
        let oldDoc = {};
        // каждый 100 мс проверяем, не изменился ли документ
        let timer = setInterval(() => {
            let iframe = document.getElementById('frame');
            if(iframe !== null) {
                let newDoc = iframe.contentDocument;
                if(oldDoc !== newDoc) {
                    logit(newDoc);
                    logit(iframe.contentDocument);
                    // logit(iframe.contentWindow.document.body.offsetHeight);
                    oldDoc = newDoc;
                }
                //if (newDoc == oldDoc) return;

                // alert("New document is here!");

                // clearInterval(timer); // отключим setInterval, он нам больше не нужен
            }

        }, 100);

    </script>

@endsection

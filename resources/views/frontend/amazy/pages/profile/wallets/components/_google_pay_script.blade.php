
@push('scripts')
    @php
        $credential = getPaymentInfoViaSellerId(1, 'google-pay');
    @endphp
    <script>
        const allowedCardNetworks = ["AMEX", "DISCOVER", "INTERAC", "JCB", "MASTERCARD", "VISA"];
        const allowedCardAuthMethods = ["PAN_ONLY", "CRYPTOGRAM_3DS"];
        if (window.PaymentRequest) {
            const request = createPaymentRequest();

            request.canMakePayment()
            .then(function(result) {
                if (result) {
                // Display PaymentRequest dialog on interaction with the existing checkout button
                document.getElementById('buyButton')
                .addEventListener('click', onBuyClicked);
                }
            })
            .catch(function(err) {
                showErrorForDebugging(
                'canMakePayment() error! ' + err.name + ' error: ' + err.message);
            });
        } else {
            showErrorForDebugging('PaymentRequest API not available.');
        }

        /**
        * Show a PaymentRequest dialog after a user clicks the checkout button
        */
        function onBuyClicked() {
            createPaymentRequest()
              .show()
              .then(function(response) {
                response.complete('success');
                // handlePaymentResponse(response);
                storeData(response.requestId);
              })
              .catch(function(err) {
                showErrorForDebugging(
                    'show() error! ' + err.name + ' error: ' + err.message);
              });
        }

        /**
        * Define your unique Google Pay API configuration
        *
        * @returns {object} data attribute suitable for PaymentMethodData
        */
        function getGooglePaymentsConfiguration() {
            return {
                environment: '{{ @$credential->perameter_1 }}',
                apiVersion: 2,
                apiVersionMinor: 0,
                merchantInfo: {
                      // A merchant ID is available after approval by Google.
                      // 'merchantId':'12345678901234567890',
                      merchantName: '{{ @$credential->perameter_4 }}'
                },
                allowedPaymentMethods: [{
                  type: 'CARD',
                  parameters: {
                    allowedAuthMethods: allowedCardAuthMethods,
                    allowedCardNetworks: allowedCardNetworks
                  },
                  tokenizationSpecification: {
                    type: 'PAYMENT_GATEWAY',
                    // Check with your payment gateway on the parameters to pass.
                    // @see {@link https://developers.google.com/pay/api/web/reference/request-objects#gateway}
                    parameters: {
                      'gateway': '{{ @$credential->perameter_2 }}',
                      'gatewayMerchantId': '{{ @$credential->perameter_3 }}'
                    }
                  }
                }]
            };
        }

        /**
        * Create a PaymentRequest
        *
        * @returns {PaymentRequest}
        */
        function createPaymentRequest() {
            // Add support for the Google Pay API.
            const methodData = [{
                supportedMethods: 'https://google.com/pay',
                data: getGooglePaymentsConfiguration()
            }];
            // Add other supported payment methods.
            methodData.push({
                supportedMethods: 'basic-card',
                data: {
                  supportedNetworks:
                      Array.from(allowedCardNetworks, (network) => network.toLowerCase())
                }
            });

            const details = {
                total: {label: 'Wallet Recharge', amount: {currency: '{{app('general_setting')->currency_code}}', value: '{{ $recharge_amount }}'}}
            };

            const options = {
                requestPayerEmail: true,
                requestPayerName: true
            };

            return new PaymentRequest(methodData, details, options);
        }

        /**
        * Process a PaymentResponse
        *
        * @param {PaymentResponse} response returned when a user approves the payment request
        */
        function handlePaymentResponse(response) {
            const formattedResponse = document.createElement('pre');
            formattedResponse.appendChild(
              document.createTextNode(JSON.stringify(response.toJSON(), null, 2)));
            // document.getElementById('gPayBtn').insertAdjacentElement('afterend', formattedResponse);
        }

        /**
        * Display an error message for debugging
        *
        * @param {string} text message to display
        */
        function showErrorForDebugging(text) {
            const errorDisplay = document.createElement('code');
            errorDisplay.style.color = 'red';
            errorDisplay.appendChild(document.createTextNode(text));
            const p = document.createElement('p');
            p.appendChild(errorDisplay);
            // document.getElementById('gPayBtn').insertAdjacentElement('afterend', p);
        }

        function storeData(el)
        {
            $.post('{{ route("googlePay.payment_status") }}', {_token:'{{ csrf_token() }}', purpose:'wallet_recharge', amount:'{{ $recharge_amount }}', requestId:el}, function(data){
               if(data == 1){
                   toastr.success("{{__('common.transaction_successfully')}}","{{__('common.success')}}")
                   location.replace("{{ route('my-wallet.index', auth()->user()->role->type) }}");
               }
               else{
                   toastr.error("{{__('common.transaction_failed')}}","{{__('common.error')}}");
               }
           });
        }
    </script>
@endpush

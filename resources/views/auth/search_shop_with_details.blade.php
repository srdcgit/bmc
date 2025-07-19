<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SEARCH SHOP | MARKET DASHBOARD </title>

    <!-- Global stylesheets -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('front/image/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('user_asset/global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('user_asset/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('user_asset/assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('user_asset/assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('user_asset/assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('user_asset/assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <link href="{{ asset('user_asset/assets/css/toastr.css') }}" rel="stylesheet" type="text/css">

    <!-- Core JS files -->
    <script src="{{ asset('user_asset/global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('user_asset/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('user_asset/global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('user_asset/global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>

    <script src="{{ asset('user_asset/assets/js/app.js') }}"></script>
    <script src="{{ asset('user_asset/global_assets/js/demo_pages/login.js') }}"></script>
    <!-- /theme JS files -->

</head>

<body>

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <div class="card-body" style="width:auto; margin:auto; border:1px solid #c0c0c0;border-radius:10px">
                <div><a href="https://vz.bmc.gov.in/" class="icon-block">
    <i class="icon-home icon-2x"></i>
    <span>{{ __('messages.home') }}</span>
</a></div>
                    <div class="text-center mb-3">
                        <img src="https://vz.bmc.gov.in/uploaded_images/profiles/541723525831.PNG"
                            style="width:120px;height:80px;" />
                        <h5 class="mb-0">{{ __('messages.Search Shop To Pay') }}</h5>
                    </div>
                    <form method="GET" action="{{ route('search_details') }}">
                        <div class="row">
                            {{-- Establishment Dropdown --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="establishment_id">{{ __('messages.Select Establishment') }}</label>
                                    <select name="establishment_id" id="establishment_id" class="form-control">
                                        <option value="">-- {{ __('messages.Select') }} --</option>
                                        @foreach ($establishments as $establishment)
                                            <option value="{{ $establishment->id }}">{{ $establishment->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shop_number">{{ __('messages.Select Shop Number') }}</label>
                                    <select name="shop_number" id="shop_number" class="form-control" disabled>
                                        <option value="">-- {{ __('messages.Select') }} --</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Go Button --}}
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Go</button>
                                </div>
                            </div>
                        </div>


                        {{-- Shop Numbers Dropdown (will be filled by AJAX) --}}




                    </form>

                     @if(@$shop)
                            <div class="card" style="margin-top: 10px;">
                                <div class="card-body">
                                    <form action="{{url('payment_pay')}}" method="post" enctype="multipart/form-data" >
                                        @csrf 
                                        <input type="hidden" name="shop_id" value="{{$shop->id}}">
                                        <input type="hidden" id="due_payments" value="{{$shop->getDuePayments()}}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6" style="border-bottom:1px dotted #c0c0c0">
                                                        <h6><strong>{{ __('messages.Shop Name') }}:</strong> {{$shop->shop_name}}</h6>
                                                        <h6><strong>{{ __('messages.Owner Name') }}:</strong> {{$shop->owner_name}}</h6>
                                                        <h6><strong>{{ __('messages.Establishment') }}:</strong> {{$shop->establishment->name}}</h6>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top:15px">
                                                    <div class="col-md-6" style="border-bottom:1px dotted #c0c0c0">
                                                        <h6><strong>{{ __('messages.Previous Arrear') }}:  </strong>Rs. {{$shop->getDuePayments()}}</h6>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top:15px">
                                                    <div class="col-md-2">
                                                        <h6><strong>{{ __('messages.Current Bill') }}:</strong></h6>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6><strong>{{ __('messages.Rent') }}:</strong> {{ __('messages.rs') }}{{@$payment->shop_rent}}</h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        {{-- <h6><strong>{{ __('messages.Current Bill') }}:</strong></h6> --}}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6><strong>{{ __('messages.Tax') }} :</strong> {{ __('messages.rs') }} {{@$payment->tax_amount}}</h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        {{-- <h6><strong>{{ __('messages.Current Bill') }}:</strong></h6> --}}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6><strong>{{ __('messages.Cam Charges') }}:</strong> {{ __('messages.rs') }} {{@$payment->cam_charges}}</h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        {{-- <h6><strong>Current Bill:</strong></h6> --}}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6><strong>{{ __('messages.Interest') }} :</strong> {{ __('messages.rs') }} {{@$payment ? $payment->getInterestValue() : 0}}</h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6" style="border-bottom:1px dotted #c0c0c0">
                                                        <h6><strong>{{ __('messages.total') }} :</strong>{{ __('messages.rs') }}{{@$payment ? $payment->dueAmount() : 0}}</h6>
                                                    </div>
                                                </div>
                                                    @php 
                                                        $totalAmount = $shop->getDuePayments() + (@$payment ? $payment->dueAmount() : 0);
                                                    @endphp
                                                <div class="row" style="margin-top:15px">
                                                    <div class="col-md-2">
                                                        <h6><strong>{{ __('messages.Amount to Pay') }} :</strong></h6>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <h6><strong>{{ __('messages.Rent') }} :</strong></h6>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" readonly id="rent_amount" class="form-control" value="{{@$payment ? $payment->dueAmount() : 0}}">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <h6><strong>{{ __('messages.Previous Arrear') }} :</strong></h6>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" id="arrear_amount" min="0" class="form-control" value="{{$shop->getDuePayments()}}">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <h6><strong>{{ __('messages.Total Amount') }} :</strong></h6>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <h6> <input required type="number" step="0.01"  id="amount" name="amount" readonly value="{{$totalAmount}}" class="form-control" min="0" max="{{$totalAmount}}"></h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="text-right">
                                                            <a href="{{route('shop_payments',$shop->id)}}" class="btn btn-warning">{{ __('messages.Payment History') }}</a>
                                                            <button type="submit" class="btn btn-primary">{{ __('messages.Pay') }} <i class="icon-paperplane ml-2"></i></button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>
					</div>
            <!-- /login card -->

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

    </div>
    <!-- /page content -->
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyB7vIAAXbybkOV2F3QXvJgkByxHnYE7g5s",
            authDomain: "bmcmarket-4ea8a.firebaseapp.com",
            projectId: "bmcmarket-4ea8a",
            storageBucket: "bmcmarket-4ea8a.firebasestorage.app",
            messagingSenderId: "104307857999",
            appId: "1:104307857999:web:b918ce7dd4dedbdcfa283a",
            measurementId: "G-5Z2TWRY3D1"
        };
        firebase.initializeApp(config);
    </script>

    <script type="text/javascript">
        window.onload = function() {
            render();
        };

        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }

        function SendCode() {

            var number = $("#number").val();

            firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {

                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;

                $("#sentSuccess").text("Message Sent Successfully.");
                $("#sentSuccess").show();
                $("#verification-code-field").show();

            }).catch(function(error) {
                $("#error").text(error.message);
                $("#error").show();
            });

        }

        function VerifyCode() {

            var code = $("#verificationCode").val();

            coderesult.confirm(code).then(function(result) {
                var user = result.user;
                console.log('12');
                var url = "{{ url('search_shop') }}" + '?phone=' + $('#number').val();
                console.log(url);
                $("#successRegsiter").text("You Are Register Successfully.");
                $("#successRegsiter").show();
                setTimeout(function() {
                    window.location.href = url;
                }, 2000);
            }).catch(function(error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }

        document.getElementById('establishment_id').addEventListener('change', function() {
            const establishmentId = this.value;
            console.log(establishmentId);
            const shopSelect = document.getElementById('shop_number');

            shopSelect.innerHTML = '<option value="">-- Loading Shops --</option>';
            shopSelect.disabled = true;

            if (establishmentId) {
                fetch(`get-shops-by-establishment/${establishmentId}`)
                    .then(res => res.json())
                    .then(data => {
                        shopSelect.innerHTML = '<option value="">-- Select Shop --</option>';
                        data.forEach(shop => {
                            shopSelect.innerHTML +=
                                `<option value="${shop.id}">${shop.shop_name}</option>`;
                        });
                        shopSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching shops:', error);
                        shopSelect.innerHTML = '<option value="">-- Error Loading Shops --</option>';
                    });
            } else {
                shopSelect.innerHTML = '<option value="">-- Select Shop --</option>';
                shopSelect.disabled = true;
            }
        });
        $('#arrear_amount').on('change',function(){
    let amount = parseFloat($(this).val()) || 0;
    let arrear_amount = parseFloat($('#due_payments').val()) || 0;
    arrear_amount = parseFloat(arrear_amount) || 0;
    if(amount > 0){
        if(amount > arrear_amount){
            $('#arrear_amount').val(arrear_amount);
            let rent_amount = parseFloat($('#rent_amount').val()) || 0;
            let total = rent_amount + arrear_amount;
            $('#amount').val(total.toFixed(2));
            alert('Value Must be lesser or equal to '+arrear_amount);
        }else{
            let rent_amount = parseFloat($('#rent_amount').val()) || 0;
            let total = rent_amount + amount;
            $('#amount').val(total.toFixed(2));
        }
    }else{
        $('#arrear_amount').val(arrear_amount);
        let rent_amount = parseFloat($('#rent_amount').val()) || 0;
        let total = rent_amount + arrear_amount;
        $('#amount').val(total.toFixed(2));
        alert('Value Must be greater than 0');
    }
   });
    </script>
</body>

</html>

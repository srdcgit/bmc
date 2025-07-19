<html>
<head>
<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SEARCH SHOP | MARKET DASHBOARD </title>

	<!-- Global stylesheets -->
    <link rel="shortcut icon" type="image/png" href="{{asset('front/image/favicon.png')}}">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
    <link href="{{asset('user_asset/assets/css/toastr.css')}}" rel="stylesheet" type="text/css">

	<!-- Core JS files -->
	<script src="{{asset('user_asset/global_assets/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{asset('user_asset/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

	<script src="{{asset('user_asset/assets/js/app.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/demo_pages/login.js')}}"></script>
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
								<img src="https://vz.bmc.gov.in/uploaded_images/profiles/541723525831.PNG" style="width:120px;height:80px;" />
							</div>
                            @if(!@$shop)
                           <div class="container">
                                <h3 style="margin-top: 30px;">{{ __('messages.Verify Mobile No') }} </h3><br>  
                                <div class="alert alert-danger" id="error" style="display: none;"></div>  
                                <div class="card" id="phone-number-field">
                                <div class="card-header">
                                    {{ __('messages.Enter Phone Number') }}
                                </div>
                                <div class="card-body">  
                                    <div class="alert alert-success" id="sentSuccess" style="display: none;"></div>
                                    <form>
                                        <label>{{ __('messages.Phone Number') }}:</label>
                                        <input type="text" id="number" class="form-control" placeholder="9876543210"><br>
                                        <div id="recaptcha-container"></div><br>
                                        <button type="button" class="btn btn-success" onclick="SendCode();">{{ __('messages.Send Code') }}</button>
                                    </form>
                                </div>
                                </div>
      
                                <div class="card" style="margin-top: 10px;display:none;"  id="verification-code-field">
                                <div class="card-header">
                                    {{ __('messages.Enter Verification code') }}
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-success" id="successRegsiter" style="display: none;"></div>
                                    <form>
                                        <input type="text" id="verificationCode" class="form-control" placeholder="{{ __('messages.Enter Verification code') }}"><br>
                                        <button type="button" class="btn btn-success" onclick="VerifyCode();">{{ __('messages.verify') }}</button>
                                    </form>
                                </div>
                                </div>
                            
                            </div>
                            @endif
                            @if(@$shop)
                            <div class="card" style="margin-top: 10px;">
                                <div class="card-body">
                                    <form action="{{url('payment_pay')}}" method="post" enctype="multipart/form-data" >
                                        @csrf 
                                        <input type="hidden" name="shop_id" value="{{$shop->id}}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6><strong>Shop Name:</strong> {{$shop->shop_name}}</h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6><strong>Establishment:</strong> {{$shop->establishment->name}}</h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6><strong>Previous Arrear:</strong></h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Rs. {{$shop->getDuePayments()}}</h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <h6><strong>Current Bill:</strong></h6>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6><strong>Rent:</strong> Rs. {{@$payment->shop_rent}}</h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        {{-- <h6><strong>Current Bill:</strong></h6> --}}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6><strong>Tax :</strong> Rs. {{@$payment->tax}}</h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        {{-- <h6><strong>Current Bill:</strong></h6> --}}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6><strong>Cam Charges :</strong> Rs. {{@$payment->cam_charges}}</h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        {{-- <h6><strong>Current Bill:</strong></h6> --}}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6><strong>Interest :</strong> Rs. {{@$payment ? $payment->getInterestValue() : 0}}</h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6><strong>Total :</strong></h6>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6>Rs. {{@$payment ? $payment->dueAmount() : 0}}</h6>
                                                    </div>
                                                </div>
                                                    @php 
                                                        $totalAmount = $shop->getDuePayments() + (@$payment ? $payment->dueAmount() : 0);
                                                    @endphp
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <h6><strong>Amount to Pay :</strong></h6>
                                                    </div>
                                                    <div class="col-md-1">
                                                        Rs.
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6> <input required step="0.01" type="number" style="width:25%;" name="amount" value="{{$totalAmount}}" class="form-control" min="0" max="{{$totalAmount}}"></h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="text-right">
                                                            <a href="{{route('shop_payments',$shop->id)}}" class="btn btn-warning">Payment History</a>
                                                            <button type="submit" class="btn btn-primary">Create <i class="icon-paperplane ml-2"></i></button>
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
                var url = "{{ url('search_shop_with_details') }}"
                console.log(url);
                $("#successRegsiter").text("{{ __('messages.verified') }}");
                $("#successRegsiter").show();
                setTimeout(function() {
                    window.location.href = url;
                }, 2000);
            }).catch(function(error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }
     document.getElementById("number").addEventListener("input", function() {
       if (this.value.indexOf("+") === -1 && this.value.indexOf("91") === -1) {
         this.value = "+91" + this.value;
       }
     });
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
    </script>
  </body>
  </html>
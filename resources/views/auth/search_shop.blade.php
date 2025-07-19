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
								<h5 class="mb-0">{{ __('messages.search_shop') }}</h5>
							</div>
                     <form method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-feedback form-group-feedback-left">
                                    <input type="text" name="identifier" class="form-control"
                                        placeholder="{{ __('messages.Search Shop Using Aadhar No / Mobile No') }}"
                                        value="{{ request()->identifier }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">{{ __('messages.search') }}</button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <a href="{{ route('mobile_verify') }}"
                                        class="btn btn-primary btn-block">{{ __('messages.search_with_details') }}</a>
                                </div>
                            </div>
                        </div>
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
    
      window.onload=function () {
        render();
      };
    
      function render() {
          window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container');
          recaptchaVerifier.render();
      }
    
      function SendCode() {
             
          var number = $("#number").val();
            
          firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
                
              window.confirmationResult=confirmationResult;
              coderesult=confirmationResult;            
    
              $("#sentSuccess").text("Message Sent Successfully.");
              $("#sentSuccess").show();
              $("#verification-code-field").show();
                
          }).catch(function (error) {
              $("#error").text(error.message);
              $("#error").show();
          });
    
      }
    
      function VerifyCode() {
    
          var code = $("#verificationCode").val();
    
          coderesult.confirm(code).then(function (result) {
              var user=result.user;            
              console.log('12');
              var url = "{{url('search_shop')}}" + '?phone=' + $('#number').val();
              console.log(url);
              $("#successRegsiter").text("You Are Register Successfully.");
              $("#successRegsiter").show();
              setTimeout(function() {
                  window.location.href = url;
              }, 2000);
          }).catch(function (error) {
              $("#error").text(error.message);
              $("#error").show();
          });
      }
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
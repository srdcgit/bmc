<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Receipt </title>

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
    <style>
        /* Add your custom styles here if needed */
        .wizard {
            display: flex;
            justify-content: space-around;
            align-items: center;
            position: relative;
        }

        .wizard-step {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .step-circle {
            width: 30px;
            height: 30px;
            background-color: #f35b3f;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1; /* Set z-index to 1 to bring it in front of the line */
        }

    </style>
</head>

<body class="" >

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Login card -->
				<form class="login-form" style="width:50rem!important;">
                   
					<div class="card mb-0"  style="background-color:#fbebfc;">
						<div class="card-body">
                            <div class="text-center mb-3">
                                <img src="https://cms.bhubaneswarone.in/uploadDocuments/Logo/Logo20181122_164103.png" alt="">
                                {{-- <i class="icon-plus3 icon-2x text-success border-success border-3 rounded-round p-3 mb-3 mt-1"></i> --}}
                               
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h1 class="mb-0" style="color:#baad00;"><strong>{{@$shop->establishment->name}} </strong></h1>
                                </div>
                                <div class="col-md-12 text-center">
                                    <h1 class="mb-0" style="color:#baad00;"><strong>{{$shop->location}}  </strong></h1>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6 text-left">
                                    <h4 class="mb-0" ><strong>{{ __('messages.SL No') }}: {{$shop->id}}  </strong></h4>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h4 class="mb-0"><strong>{{ __('messages.Receipt No') }} : {{$payment->id}}  </strong></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="mb-0" ><strong>{{ __('messages.Owner Name') }} : {{$shop->owner_name}}</strong></h4>
                                </div>
                                <div class="col-md-12">
                                    <h4 class="mb-0"><strong>{{ __('messages.Shop No') }} : {{$shop->shop_number}}</strong></h4>
                                </div>
                                <div class="col-md-12">
                                    <h4 class="mb-0" ><strong>{{ __('messages.Shop Name') }} : {{$shop->shop_name}}</strong></h4>
                                </div>
                                <div class="col-md-12">
                                    <h4 class="mb-0"><strong>{{ __('messages.Received Amount') }} : {{@$payment->paidAmount()}}</strong></h4>
                                </div>
                                <div class="col-md-12">
                                    <h4 class="mb-0" ><strong>{{ __('messages.Invoice No') }} : {{@$payment->id}}.  {{ __('messages.for the Month of') }} : {{$payment->month}}({{$payment->year}})</strong></h4>
                                </div>
                            </div>
                        </div>
					</div>
				</form>
				<!-- /login card -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
    <script src="{{asset('user_asset/assets/js/toastr.js')}}"></script>
	<script>
		window.print();

</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SHOP PAYMENTS | MARKET DASHBOARD </title>

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

<body class="bg-slate-800">

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content">
				<!-- Login card -->
					<div class="card mb-0">
						<div class="card-body">
						<div><a href="https://vz.bmc.gov.in/" class="icon-block">
    <i class="icon-home icon-2x"></i>
    <span>{{ __('messages.home') }}</span>
</a></div>
							<div class="text-center mb-3">
								<img src="https://vz.bmc.gov.in/uploaded_images/profiles/541723525831.PNG" style="width:120px;height:80px;" />
								
							</div>
                            <div class="row">
                                <div class="col-md-12">
                                <h5 class="mb-0"><strong>{{ __('messages.Shop Name') }}: {{$shop->shop_name}} <br>{{ __('messages.Owner Name') }}: {{$shop->owner_name}}<br>{{ __('messages.Establishment') }}: {{$shop->establishment->name}}</strong></h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="padding:.4rem .4rem;">{{ __('messages.Month') }}</th>
                                                <th style="padding:.4rem .4rem;">{{ __('messages.Year') }}</th>
                                                <td style="padding:.4rem .4rem;">{{ __('messages.Invoice') }}</td>
                                                <td style="padding:.4rem .4rem;">{{ __('messages.Receipt') }}</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($payments  as $key => $payment)
                                                @if($payment->paidAmount() > 0)
                                                    <tr>
                                                        <td style="padding:.4rem .4rem;">{{@$payment->month}}</td>
                                                        <td style="padding:.4rem .4rem;">{{@$payment->year}}</td>
                                                        <td style="padding:.4rem .4rem;"><a href="#" class="btn btn-info">{{ __('messages.Download') }}</a></td>
                                                        <td style="padding:.4rem .4rem;"><a href="{{route('receipt',$payment->id)}}" class="btn btn-info">{{ __('messages.Download') }}</a></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
					</div>
				<!-- /login card -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>

    <script>
        function sumTotalPayable(){
             let total = 0;
             $('.payment-checkbox:checked').each(function() {
                 let amount = parseFloat($(this).attr('amount')) || 0;
                 total += amount;
             });
             $('#total_payable').text(total.toFixed(2));
        }
     </script>
</body>
</html>

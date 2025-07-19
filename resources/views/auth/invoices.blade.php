<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SHOP PAYMENT INVOICES | MARKET DASHBOARD </title>

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
							<div class="text-center mb-3">
								<img src="https://vz.bmc.gov.in/uploaded_images/profiles/541723525831.PNG" style="width:120px;height:80px;" />
								
							</div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-0"><strong>Shop Name:</strong> {{$payment->shop->shop_name}} <br><strong>Owner Name:</strong> {{$payment->shop->owner_name}}  <br><strong>Establishment: </strong>{{$payment->shop->establishment->name}}</h5>
                       
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>SL No</th>
                                                <th>Paid Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices  as $key => $invoice)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{@$invoice->amount}}</td> 
                                                    <td>{{$invoice->created_at ? \Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d') : ''}}</td>
                                                </tr>
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

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{$shop->name}} Shop Detail | MARKET DASHBOARD </title>

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
						  <div class="language">
                <select class="form-control changeLang">
                    <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                    <option value="od" {{ session()->get('locale') == 'od' ? 'selected' : '' }}>ଓଡ଼ିଆ</option>
                </select>
             </div>


							<div class="text-center mb-3">
								<img src="https://vz.bmc.gov.in/uploaded_images/profiles/541723525831.PNG" style="width:120px;height:80px;margin-top:20px" />
								
							</div>
                            <ul class="nav nav-tabs nav-tabs-top">
                                <li class="nav-item"><a href="#top-tab1" class="nav-link active" class="nav-link" data-toggle="tab">{{ __('messages.Shop Detail') }}</a></li>
                                <li class="nav-item"><a href="#top-tab2" class="nav-link" data-toggle="tab">{{ __('messages.Payment Detail') }} </a></li>
                                {{-- <li class="nav-item"><a href="#top-tab3" class="nav-link" data-toggle="tab">Arrears</a></li> --}}
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="top-tab1">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                    <span>
                                                        <h5>{{ __('messages.Shop Name') }} </h5> 
                                                        <p class="font-weight-semibold">
                                                            {{@$shop->shop_name}}
                                                        </p>
                                                        <hr class="dotted-line">
                                                    </span>
                                            </div>
                                            <div class="col-xl-6">  
                                                <span>
                                                    <h5>{{ __('messages.Owner Name') }} </h5> 
                                                    <p class="font-weight-semibold">{{@$shop->owner_name}}</p>
                                                    <hr class="dotted-line">
                                                </span>
                                            </div>
                                            <div class="col-xl-6">  
                                                <span>
                                                    <h5>{{ __('messages.Phone Number') }}</h5> 
                                                    <p class="font-weight-semibold">{{@$shop->phone}}</p>
                                                    <hr class="dotted-line">
                                                </span>
                                            </div>
                                            <div class="col-xl-6">  
                                                <span>
                                                    <h5>{{ __('messages.Email Address') }} </h5> 
                                                    <p class="font-weight-semibold">{{@$shop->email}}</p>
                                                    <hr class="dotted-line">
                                                </span>
                                            </div>
                                            <div class="col-xl-6">  
                                                <span>
                                                    <h5>{{ __('messages.Establishment Category') }}</h5> 
                                                    <p class="font-weight-semibold">{{@$shop->establishment_category->name}}</p>
                                                    <hr class="dotted-line">
                                                </span>
                                            </div>
                                            <div class="col-xl-6">  
                                                <span>
                                                    <h5>{{ __('messages.Establishment') }}  </h5> 
                                                    <p class="font-weight-semibold">{{@$shop->establishment->name}}</p>
                                                    <hr class="dotted-line">
                                                </span>
                                            </div>
                                            <div class="col-xl-6">  
                                                <span>
                                                    <h5>{{ __('messages.Shop No') }}  </h5> 
                                                    <p class="font-weight-semibold">{{@$shop->shop_number}}</p>
                                                    <hr class="dotted-line">
                                                </span>
                                            </div>
                                            <div class="col-xl-6">  
                                                <span>
                                                    <h5>{{ __('messages.Shop Size') }}</h5> 
                                                    <p class="font-weight-semibold">{{@$shop->shop_size}}</p>
                                                    <hr class="dotted-line">
                                                </span>
                                            </div>
                                            <div class="col-xl-6">  
                                                <span>
                                                    <h5>{{ __('messages.Rent') }} </h5> 
                                                    <p class="font-weight-semibold">{{@$shop->shop_rent}}</p>
                                                    <hr class="dotted-line">
                                                </span>
                                            </div>
                                           
                                            
                                        </div>
                                    </div>
            
                                </div>
                                <div class="tab-pane fade show " id="top-tab2">
                                    <div class="card-body">
                                        <h5>{{ __('messages.search_shop') }} </h5>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <a href="{{url('search_shop')}}">{{ __('messages.Search Shop Using Aadhar No / Mobile No') }}</a>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="{{url('mobile_verify')}}">{{ __('messages.search_with_details') }} </a>
                                            </div>
                                        </div>
                                        {{-- <div class="table-responsive mt-3">
                                            <table class="table datatable-save-state">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Month</th>
                                                        <th>Amount</th>
                                                        <th>Payment Date</th>
                                                        <th>Payment Mode</th>
                                                        <th>Payment Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payments  as $key => $payment)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{@$payment->month}}</td>
                                                        <td>{{@$payment->amount}}</td>
                                                        <td>{{@$payment->updated_at->format('d M,Y')}}</td>
                                                        <td>{{@$payment->payment_mode}}</td>
                                                        <td>{{$payment->is_paid ? 'Paid' : 'Not Paid'}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
            
                                        </div> --}}
                                    </div>
            
                                </div>
                                <div class="tab-pane fade show" id="top-tab3">
                                    <div class="card-body">
                                        
                                        <div class="table-responsive mt-3">
                                            <table class="table datatable-save-state">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Establishment Name</th>
                                                        <th>Shop Name</th>
                                                        <th>Amount</th>
                                                        <th>Arrear Entry Date</th>
                                                        <th>Entry By</th>
                                                        
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($shop->arrears  as $key => $arrear)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{@$arrear->establishment->name}}</td>
                                                        <td>{{@$arrear->shop->shop_name}}</td>
                                                        <td>{{@$arrear->amount}}</td>
                                                        <td>{{@$arrear->created_at->format('d M,Y')}}</td>
                                                        <td>{{@$arrear->user->name}}</td>       
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
            
                                        </div>
                                    </div>
            
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
     <script type="text/javascript">
    var url = "{{ route('changeLang') }}";
    $(".changeLang").change(function(){

        window.location.href = url + "?lang="+ $(this).val();

    });

</script>
</body>
</html>

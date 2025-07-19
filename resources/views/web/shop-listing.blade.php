@include('component.header')
	
		<section id="home" class="welcome-hero" style="height:300px!important;">
			<div class="container">
				<div class="welcome-hero-txt" style="padding-top:70px!important;">
					<h2>{{$establishment->name}} <br> SHOPS </h2>
				</div>
				
			</div>

		</section><!--/.welcome-hero-->
		<!--welcome-hero end -->

		<!--works start -->
		

		<!--explore start -->
		<section style="margin-top:20px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table datatable-save-state" style="border:1px solid #c0c0c0;border-radius:10px">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Shop Name</th>
                                    <th>Shop No</th>
                                    <th>Owner Name</th>
                                    <th>Shop Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shops  as $key => $shop)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$shop->shop_name}}</td>
                                    <td>{{$shop->shop_number}}</td>
                                    <td>{{$shop->owner_name}}</td>
                                    <td>{{$shop->shop_type}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
		</section><!--/.explore-->
		<!--explore end -->

		<!--reviews start -->
		

		

			<div id="scroll-Top">
				<div class="return-to-top">
					<i class="fa fa-angle-up " id="scroll-top" data-toggle="tooltip" data-placement="top" title="" data-original-title="Back to Top" aria-hidden="true"></i>
				</div>
				
			</div>

		
		<!-- Include all js compiled plugins (below), or include individual files as needed -->

		<script src="{{asset('assets/js/jquery.js')}}"></script>
        
        <!--modernizr.min.js-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
		
		<!--bootstrap.min.js-->
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
		
		<!-- bootsnav js -->
		<script src="{{asset('assets/js/bootsnav.js')}}"></script>

        <!--feather.min.js-->
        <script  src="{{asset('assets/js/feather.min.js')}}"></script>

        <!-- counter js -->
		<script src="{{asset('assets/js/jquery.counterup.min.js')}}"></script>
		<script src="{{asset('assets/js/waypoints.min.js')}}"></script>

        <!--slick.min.js-->
        <script src="{{asset('assets/js/slick.min.j')}}s"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
		     
        <!--Custom JS-->
        <script src="{{asset('assets/js/custom.js')}}"></script>
        
    </body>
	
</html>
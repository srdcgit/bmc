@include('component.header')
	<div style="border-top:1px solid #F9F6F6;padding:5px;font-color:red"><marquee onmouseover="this.stop();" onmouseout="this.start();">
  <a href="https://vz.bmc.gov.in/search_shop" style="color:red !important">{{ __('messages.scroll') }}</a>
</marquee></div>
		<section id="home" class="welcome-hero">
			<div class="container">
				<div class="welcome-hero-txt">
					<h2>{{ __('messages.slider_text') }} <br> {{ __('messages.slider_text2') }}  </h2>
				</div>
				
			</div>

		</section><!--/.welcome-hero-->
		<!--welcome-hero end -->
{{-- modal --}}
<!-- Button trigger inside modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <img src="https://vz.bmc.gov.in/assets/logo/bmc2.png" style="height:50px;width:60%; margin:auto" />
            </div>
            <div class="modal-body">
                <h2 style="padding:30px 0">Want to pay shop rent? </h2>
                <button class="btn btn-primary" id="modal-action" onclick="location.href='https://vz.bmc.gov.in/search_shop'">Click Here</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close">Close</button>
            </div>
        </div>
    </div>
</div>
		<!--list-topics start -->
		<section id="list-topics" class="list-topics">
			<div class="container">
				<div class="list-topics-content">
					<ul>
						@foreach(App\Models\EstablishmentCategory::get()->take(5) as $category)
						<li>
							<div class="single-list-topics-content">
								<div class="single-list-topics-icon">
									<i class="{{$category->icon}}"></i>
								</div>
								<h2>{{$category->{'name_' . App::getLocale()} }}</h2>
								<p>{{$category->establishments->count()}} Nos</p>
							</div>
						</li>
						@endforeach
					</ul>
				</div>
			</div><!--/.container-->

		</section><!--/.list-topics-->
		<!--list-topics end-->

		<!--works start -->
		

		<!--explore start -->
		<section id="explore" class="explore">
			<div class="container">
				<div class="section-header">
					<h2>{{ __('messages.explore') }}</h2>
					<p>{{ __('messages.section_head') }}</p>
				</div><!--/.section-header-->
				<div class="explore-content">
					<div class="row">
						@foreach(App\Models\Establishment::all() as $establishment)
						<div class=" col-md-4 col-sm-6">
							<div class="single-explore-item">
								<div class="single-explore-img">
									@if($establishment->image)
										<img src="{{asset($establishment->image)}}" alt="explore image">
									@else
										<img src="https://vz.bmc.gov.in/uploaded_images/1001702963558.png" alt="explore image">
									@endif
									<div class="single-explore-img-info">
										
									</div>
								</div>
								<div class="single-explore-txt bg-theme-1">
									<h2><a href="{{route('web.shops',str_replace(' ', '_',$establishment->name))}}">{{$establishment->name}}</a></h2>
									<p class="explore-rating-price" style="font-size:11px!important;">
										<a>Total Shops: {{$establishment->total_shops}}</a> 
										<span class="explore-price-box">
											<span class="explore-price">Occupied: {{$establishment->shops->count()}}</span>
										</span>
										<span class="explore-price-box">
											<span class="explore-price2">Available: {{$establishment->total_shops - $establishment->shops->count()}}</span>
										</span>
									</p>
																		
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div><!--/.container-->

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
        <script type="text/javascript">
    var url = "{{ route('changeLang') }}";
    $(".changeLang").change(function(){

        window.location.href = url + "?lang="+ $(this).val();

    });

</script>
<script>
    $(document).ready(function() {
        // Check if the modal has already been closed
        if (!localStorage.getItem('modalClosed')) {
            $('#myModal').modal('show');
        }

        // When the modal is closed
        $('#myModal').on('hidden.bs.modal', function() {
            localStorage.setItem('modalClosed', 'true');
        });


    });
</script>
    </body>
	
</html>
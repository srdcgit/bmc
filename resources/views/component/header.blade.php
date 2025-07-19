<!doctype html>
<html class="no-js" lang="en">

<head>
    <!-- meta data -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags must come first in the head; any other head content must come after these tags -->

    <!--font-family-->
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- title of site -->
    <title>Bhubaneswar Municipal Corporation</title>

    <!-- For favicon png -->
    <link rel="shortcut icon" type="image/icon" href="https://www.bmc.gov.in/images/favicon.ico" />

    <!--font-awesome.min.css-->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link href="{{ asset('user_asset/assets/css/components.min.css') }}" rel="stylesheet" type="text/css">

    <!--linear icon css-->
    <link rel="stylesheet" href="{{ asset('assets/css/linearicons.css') }}">

    <!--animate.css-->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

    <!--flaticon.css-->
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">

    <!--slick.css-->
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">

    <!--bootstrap.min.css-->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- bootsnav -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootsnav.css') }}">

    <!--style.css-->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!--responsive.css-->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
   <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<section class="top-area">
    <div class="header-area">
        <!-- Start Navigation -->
        <nav class="navbar navbar-default bootsnav  navbar-sticky navbar-scrollspy" data-minus-value-desktop="70"
            data-minus-value-mobile="55" data-speed="1000">

            <div class="container">

                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="https://vz.bmc.gov.in/"><img
                            src="{{ asset('assets/logo/bmc2.png') }}" alt="explore image" style="width:400px"></a>

                </div><!--/.navbar-header-->
                <!-- End Header Navigation -->
                {{-- <div class="language">
                    <select class="form-control changeLang">
                        <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English
                        </option>
                        <option value="od" {{ session()->get('locale') == 'od' ? 'selected' : '' }}>ଓଡ଼ିଆ</option>
                    </select>
                </div> --}}

                <div class="language d-flex justify-content-end align-items-center">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-primary {{ session('locale') == 'en' ? 'active' : '' }}">
                            <input type="radio" name="lang" class="changeLang" value="en"
                                {{ session('locale') == 'en' ? 'checked' : '' }}> English
                        </label>
                        <label class="btn btn-primary {{ session('locale') == 'od' ? 'active' : '' }}">
                            <input type="radio" name="lang" class="changeLang" value="od"
                                {{ session('locale') == 'od' ? 'checked' : '' }}> ଓଡ଼ିଆ
                        </label>
                    </div>
                </div>


                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse menu-ui-design" id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp"
                        style="margin:0px!important">
                        <li><a href="https://vz.bmc.gov.in/">{{ __('messages.home') }}</a></li>
                        <li class="scroll"><a href="#explore">{{ __('messages.explore') }}</a></li>
                        <li><a href="https://citizenservices.bhubaneswar.me/grievance/complaint-registration/grievance"
                                target="_blank">{{ __('messages.Contact') }}</a></li>
                        {{-- <li><a href="{{ url('login') }}">{{ __('messages.login') }}</a></li> --}}
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">
                                {{ __('messages.login') }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="text-center"><a href="{{ url('login') }}">{{ __('messages.staff_login') }}</a></li>
                                <li class="text-center"><a href="{{ url('search_shop') }}">{{ __('messages.guest_login') }}</a></li>
                            </ul>
                        </li>

                    </ul><!--/.nav -->
                </div><!-- /.navbar-collapse -->
            </div><!--/.container-->
        </nav><!--/nav-->
        <!-- End Navigation -->
    </div><!--/.header-area-->
    <div class="clearfix"></div>

</section>
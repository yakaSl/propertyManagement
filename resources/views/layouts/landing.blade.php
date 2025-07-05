<!DOCTYPE html>
<html lang="en">
@php
    $settings=settings();
     $user=\App\Models\User::find(1);
    \App::setLocale($user->lang);
@endphp

<head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('APP_NAME')}}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <meta name="author" content="{{!empty($settings['app_name'])?$settings['app_name']:env('APP_NAME')}}">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{!empty($settings['app_name'])?$settings['app_name']:env('APP_NAME')}} - @yield('page-title') </title>

    <meta name="title" content="{{$settings['meta_seo_title']}}">
    <meta name="keywords" content="{{$settings['meta_seo_keyword']}}">
    <meta name="description" content="{{$settings['meta_seo_description']}}">


    <meta property="og:type" content="website">
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:title" content="{{$settings['meta_seo_title']}}">
    <meta property="og:description" content="{{$settings['meta_seo_description']}}">
    <meta property="og:image" content="{{asset(Storage::url('upload/seo')).'/'.$settings['meta_seo_image']}}">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:title" content="{{$settings['meta_seo_title']}}">
    <meta property="twitter:description" content="{{$settings['meta_seo_description']}}">
    <meta property="twitter:image" content="{{asset(Storage::url('upload/seo')).'/'.$settings['meta_seo_image']}}">

    <!-- shortcut icon-->
    <link rel="icon" href="{{asset(Storage::url('upload/logo')).'/'.$settings['company_favicon']}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset(Storage::url('upload/logo')).'/'.$settings['company_favicon']}}"
          type="image/x-icon">

    <!-- shortcut icon-->
    <link rel="shortcut icon" href="{{asset(Storage::url('upload/logo')).'/favicon.png'}}" type="image/x-icon">
    <!-- Fonts css-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <!-- Font awesome -->
    <link href="{{ asset('assets/css/vendor/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/icoicon/icoicon.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/vendor/slider/slick-slider/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/slider/slick-slider/slick-theme.css') }}" rel="stylesheet">
    <!-- animat css-->
    <link href="{{ asset('assets/css/vendor/animate.css') }}" rel="stylesheet">
    <!-- Bootstrap css-->
    <link href="{{ asset('assets/css/vendor/bootstrap.css') }}" rel="stylesheet">
    <!-- Custom css-->

    @php
        $style=$settings['theme_color']=='color1'?'style.css':$settings['theme_color'].'.css';
        if($settings['color_type']=='custom'){
            $style='style.css';
        }
    @endphp
    <link href="{{ asset('assets/css/'.$style) }}" id="customstyle" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body class="{{$settings['layout_direction']}} {{$settings['layout_mode']}}">
<!-- header start-->
<header class="land-header fixed">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header-contain position-relative">
                    <div class="codex-brand">
                        <a href="javascript:void(0);">
                            <img class="img-fluid dark-logo landing-logo"
                                 src="{{asset(Storage::url('upload/logo')).'/'.$settings['landing_logo']}}"
                                 alt="">
                        </a>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="menu-block">
                            <ul class="menu-list">
                                <li class="d-xl-none">
                                    <a class="close-menu" href="javascript:void(0);">
                                        <div class="menu-brand">
                                            <img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}"
                                                 alt=""><i data-feather="x"></i>
                                        </div>
                                    </a>
                                </li>
                                
                                

                                <li class="menu-item">
                                    <a class="btn btn-primary me-2" href="{{route('login')}}">{{__('Login')}} </a>
                                    @if($settings['register_page']=='on')
                                        <a class="btn btn-primary" href="{{route('register')}}">{{__('Register')}} </a>
                                    @endif

                                </li>

                            </ul>
                            <a class="menu-action d-xl-none" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header end-->

<!-- intro start-->
<section class="intro" id="demos">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-7 col-lg-7">
                <div class="intro-contain">
                    <div>
                        <h1 class="wow fadeInLeft"
                            data-wow-duration="1s">{{__('Smart Tenant - Property Management System')}}</h1>
                        <p class="wow fadeInLeft"
                           data-wow-duration="1.5s">{{__('Property management refers to the administration, operation, and oversight of real estate properties on behalf of property owners. It involves various tasks such as marketing rental properties, finding tenants, collecting rent and ensuring legal compliance.')}}</p>
                        <a class="btn btn-primary" href="{{route('login')}}" data-wow-duration="1.8s"><i
                                class="fa fa-television" aria-hidden="true"></i>{{__('Get Started')}} </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="landing_dash">
        <img class="" src="{{ asset('assets/images/landing/9.jpg') }}" alt="">
    </div>
</section>
<!-- intro end-->
<!-- demo start-->

<!-- demo end-->
<!-- header otpion start-->

<!-- header otpion End-->
<!-- innderpages start-->

<!-- innderpages end-->

<!-- header otpion start-->

<!-- header otpion End-->
<!-- footer start-->
<footer class="lan-footer space-py-10">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="support-contain">
                    <div class="codex-brand">
                        <p class="mt-20 mb-20">{{__('Copyright')}} {{date('Y')}} {{env('APP_NAME')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer end-->
<!-- tap to top start-->
<div class="scroll-top"><i class="fa fa-angle-double-up"></i></div>
<!-- tap to top end-->
<!-- main jquery-->
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<!-- Feather iocns js-->
<script src="{{ asset('assets/js/icons/feather-icon/feather.js') }}"></script>
<!-- Wow js-->
<script src="{{ asset('assets/js/vendors/wow.min.js') }}"></script>

<script src="{{ asset('assets/js/vendors/slider/slick-sldier/slick.js') }}"></script>
<script src="{{ asset('assets/js/vendors/slider/slick-sldier/slick-custom.js') }}"></script>

<!-- Bootstrap js-->
<script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
<script>
    //*** Header Js ***//
    $(window).scroll(function () {
        if ($(window).scrollTop() > 100) {
            $('header').addClass('sticky');
        } else {
            $('header').removeClass('sticky');
        }
    });

    //*** Menu Js ***//
    $(document).on("click", '.menu-action', function () {
        $('.menu-list').toggleClass('open');
    });
    $(document).on("click", '.close-menu', function () {
        $('.menu-list').removeClass('open');
    });

    //*** BACK TO TOP START ***//
    $(window).scroll(function () {
        if ($(window).scrollTop() > 450) {
            $('.scroll-top').addClass('show');
        } else {
            $('.scroll-top').removeClass('show');
        }
    });
    $(document).ready(function () {
        $(document).on("click", '.scroll-top', function () {
            $('html, body').animate({scrollTop: 0}, '450');
        });
    });

    //*** WOW Js ***//
    new WOW().init();
</script>
</body>
</html>

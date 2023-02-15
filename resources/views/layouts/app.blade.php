
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">

    <!-- ========== SEO ========== -->
    <title>Santorenz Bay Resort </title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta content="" name="author">

    <!-- ========== FAVICON ========== -->
    <link rel="apple-touch-icon-precomposed" href="{{asset('assets/images/favicon.ico')}}" />
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}">

    <!-- ========== STYLESHEETS ========== -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/revolution/css/layers.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/revolution/css/settings.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/revolution/css/navigation.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/animate.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/famfamfam-flags.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/magnific-popup.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/owl.carousel.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet" type="text/css">

    <!-- ========== ICON FONTS ========== -->
    <link href="{{asset('assets/fonts/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/fonts/flaticon.css')}}" rel="stylesheet">

    <!-- ========== GOOGLE FONTS ========== -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900%7cRaleway:400,500,600,700" rel="stylesheet">
    
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link href="{{url('assets/parsley/parsley.css')}}" rel="stylesheet" type="text/css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    

    <div id="smoothpage" class="wrapper">

        @include('layouts.header')
            @yield('container')
        @include('layouts.footer')

    </div>

    <!-- ========== BACK TO TOP ========== -->
    <div id="back_to_top">
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>

    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "107393832215416");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId            : ''
          xfbml            : true,
          version          : 'v15.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- ========== JAVASCRIPT ========== -->
    <script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap-select.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.smoothState.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/morphext.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/wow.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.easing.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/owl.carousel.thumbs.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jPushMenu.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/isotope.pkgd.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/imagesloaded.pkgd.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/countUp.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.countdown.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/main.js')}}"></script>
	<script src="{{url('assets/parsley/parsley.min.js')}}"></script>
    @yield('custom')

</body>
</html>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/icons/admin/bdlogo.png')}}" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>PLIS</title>
        
        @section('header_css_js_scrip_area')
        <!-- Bootstrap core CSS -->
        <link href="{{ asset('project/common/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Fontawesome core CSS -->
        <link href="{{ asset('project/common/css/font-awesome.min.css')}}" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="{{ asset('project/frontend/css/navbar-fixed-top.css')}}" rel="stylesheet">
        
        <!-- Custom styles for login template -->
        <link rel="stylesheet" href="{{ asset('project/backend/css/AdminLTE.min.css')}}">
        
        @show
    </head>

    <body>
        
        <!--Start Navigation Area-->
            @include('frontend.layout.nav')
        <!--End Navigation Area-->
        
        <div class="container">            
            <!--Start Main Content Area-->
            
            @yield('content')
            <!--End Main Content Area-->
            
           <!--Start Footer Area-->
            @include('frontend.layout.footer')
            <!--End Footer Area-->
            
        </div><!--End Main Content Area-->
        
        @section('footer_js_scrip_area')
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="{{ asset('project/common/js/jquery-3.3.1.min.js')}}"></script>
        <script src="{{ asset('project/common/js/bootstrap.min.js')}}"></script>
        @show 
        
    </body>
</html>

<!DOCTYPE HTML>

<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        @yield('meta')
        <!--[if lte IE 8]><script src="{{url('/')}}/assets/js/ie/html5shiv.js"></script><![endif]-->
        <link rel="stylesheet" href="{{url('/')}}/assets/css/main.css" />
        <link rel="stylesheet" href="{{url('/')}}/assets/css/print.css" />
        <link rel="stylesheet" href="{{url('/')}}/assets/css/jquery-ui.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        @yield('css')
    </head>
    <body class="dashboard">
    @include('flash::message')
        <div id="page-wrapper">
            <!-- Header -->
                <header id="header">
                    @yield('header')
                </header>

            <!-- Main -->
                <article id="main">
                    @yield('content')
                </article>

            

            <!-- Footer -->
                <footer id="footer">
                   <p>&copy; Copyright {{date('Y')}} Talal Trading & Contracting Co.
                </footer>
        </div>
         
    @yield('modal')
        <!-- Scripts -->
            <script src="{{url('/')}}/assets/js/jquery.min.js"></script>
            <script src="{{url('/')}}/assets/js/jquery-ui.min.js"></script>
            <script src="{{url('/')}}/assets/js/jquery.leanModal.min.js"></script>
            <script src="{{url('/')}}/assets/js/skel.min.js"></script>
            <script src="{{url('/')}}/assets/js/skel-layout.min.js"></script>
            <script src="{{url('/')}}/assets/js/util.js"></script>
            <script src="{{url('/')}}/assets/js/inputmask.min.js"></script>
            <script src="{{url('/')}}/assets/js/inputmask.extensions.min.js"></script>
            <script src="{{url('/')}}/assets/js/inputmask.date.extensions.min.js"></script>
            <script src="{{url('/')}}/assets/js/jquery.inputmask.min.js"></script>
            <script src="https://maps.google.com/maps/api/js?sensor=false&libraries=geometry&v=3.22&key=AIzaSyDfDgriuIKRi45gcfzmbkNL29P9ST5r89U"></script>
            <script src="{{url('/')}}/assets/js/maplace.js"></script>
            <script src="{{url('/')}}/assets/js/chart.min.js"></script>
            <!--[if lte IE 8]><script src="{{url('/')}}/assets/js/ie/respond.min.js"></script><![endif]-->
            <script src="{{url('/')}}/assets/js/main.js"></script>
            <script type="text/javascript">
                @yield('script')
            </script>
    </body>
</html>
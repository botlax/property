<!DOCTYPE HTML>

<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!--[if lte IE 8]><script src="{{url('/')}}/assets/js/ie/html5shiv.js"></script><![endif]-->
        <link rel="stylesheet" href="{{url('/')}}/assets/css/main.css" />
        <link rel="stylesheet" href="{{url('/')}}/assets/css/jquery-ui.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        @yield('css')
    </head>
    <body class="@yield('body-class')">
    @include('flash::message')
        <div id="page-wrapper">
            
            <!-- Main -->
                <article id="main">
                    @yield('content')
                </article>

        </div>
         

        <!-- Scripts -->
            <script src="{{url('/')}}/assets/js/jquery.min.js"></script>
            <script src="{{url('/')}}/assets/js/jquery-ui.min.js"></script>
            <script src="{{url('/')}}/assets/js/jquery.leanModal.min.js"></script>
            <script src="{{url('/')}}/assets/js/skel.min.js"></script>
            <script src="{{url('/')}}/assets/js/skel-layout.min.js"></script>
            <script src="{{url('/')}}/assets/js/util.js"></script>
            <!--[if lte IE 8]><script src="{{url('/')}}/assets/js/ie/respond.min.js"></script><![endif]-->
            <script src="{{url('/')}}/assets/js/main.js"></script>
            @yield('js')
    </body>
</html>
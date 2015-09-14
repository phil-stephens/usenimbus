<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link href="/img/favicon.png" rel="shortcut icon">

    <title>Powerfully Simple File-sharing :: Nimbus</title>

    @section('meta')
        <!-- Stylesheets -->
        <link rel="stylesheet" href="/css/site.css"/>

        <!-- Fonts etc -->
        <link href="/css/font-awesome.min.css" rel="stylesheet">
    @show
</head>
<body>
<header>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                @section('navbar-brand')
                <a class="navbar-brand" href="/">Nimbus</a>
                @show
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>{!! link_to_route('login_path', 'Login') !!}</li>
                    <li>{!! link_to_route('register_path', 'Sign Up') !!}</li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

</header>

<main class="main">
    @yield('content')
</main>

@section('credits')
    <footer class="footer">
        <div class="container text-center">
            <ul class="list-inline text-muted">
                <li>{!! link_to_route('terms_path', 'Terms and Conditions') !!}</li>
                <li>{!! link_to_route('privacy_path', 'Privacy Policy') !!}</li>
                <li><a href="http://alchemydigital.com.au/#form" target="_blank">Contact Us</a></li>
            </ul>

            <a href="http://alchemydigital.com.au" class="alchemy-credit">made by <span>Alchemy</span></a>
        </div>
    </footer>
@show

@section('scripts')
    <script src="/js/jquery.min.js"></script><!-- 1.11.2 -->
    <script src="/js/bootstrap.min.js"></script>
@show
</body>
</html>
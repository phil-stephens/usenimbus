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
        <link rel="stylesheet" href="/css/nimbus.css"/>

        <!-- Fonts etc -->
        <link href="/css/font-awesome.min.css" rel="stylesheet">
    @show
</head>
<body>
<header class="header">
    <h1 class="logo"><a href="/" title="Nimbus">Nimbus</a></h1>
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
    <script src="/js/bootbox.js"></script> <!-- Need to build a minified version -->
@show
</body>
</html>
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


<main class="main">
    @yield('content')
</main>

<footer>
    <a class="nimbus-credit" href="/" title="Nimbus">shared on <span>Nimbus</span></a>
</footer>

@section('scripts')
    <script src="/js/jquery.min.js"></script><!-- 1.11.2 -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootbox.js"></script> <!-- Need to build a minified version -->
@show
</body>
</html>
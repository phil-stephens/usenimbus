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
<body class="{{ $class or '' }}">
<header class="header">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-sm-9 col-md-offset-2 col-sm-offset-3">
                @include('flash::message')
            </div>
        </div>
    </div>
</header>

<main class="main">
    <div class="container-fluid">
        <div class="row">
            @section('sidenav')
                @include('layouts.partials.sidenav')
            @show

            <div class="col-md-10 col-sm-9 col-md-offset-2 col-sm-offset-3">
                @yield('content')
            </div>
        </div>
    </div>
</main>

@section('scripts')
    <script src="/js/jquery.min.js"></script><!-- 1.11.2 -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootbox.js"></script> <!-- Need to build a minified version -->
@show
</body>
</html>
<html>
<head>
    <style>
        body
        {
            background: #ddd;
            text-align: center;
            margin: 20px;
            font-family: Helvetica, Arial, Verdana, sans-serif;
        }

        .content
        {
            width: 500px;
            background: #ffffff;
            padding: 20px;
            margin: 0 auto;
            text-align: left;
        }

        h1.title
        {
            font-weight: normal;
            margin: 0 0 20px;
        }

        a.credit
        {
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="content">
        @yield('content')
    </div>

    {!! link_to_route('homepage', 'Powered by Nimbus') !!}
</body>
</html>
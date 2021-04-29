<head>
    @include('layouts.components.gtm-head')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | theClubhouse®</title>
    <!-- Twitter Card data -->
    <meta name="twitter:card" value="summary_large_image">
    <meta name="description" content="@yield('description', 'SBS Consulting provides training, consulting, and recruiting services for sports teams and provide career services for those interested in working in sports.')" />
    <!-- OPEN GRAPH -->
    <meta property="og:title" content="@yield('title', 'theClubhouse®') | theClubhouse®" />
    <meta property="og:description" content="@yield('description', 'SBS Consulting provides training, consulting, and recruiting services for sports teams and provide career services for those interested in working in sports.')" />
    <meta property="og:image" content="@yield('image', url('/').'/images/Share-Sports-Business-Solutions-Clubhouse.jpg')">
    <meta property="og:image:alt" content="@yield('image-alt', "theClubhouse® at SBS Consulting")">
    <meta property="og:image:height" content="520">
    <meta property="og:image:width" content="1000">
    <meta property="og:url" content="@yield('url', url('/'))">
    <!-- iOS icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/CH_logo-apple-touch.png">
    <!-- Clubhouse Favicon -->
    <link rel="icon" href="/clubhouse_favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/clubhouse_favicon.ico" type="image/x-icon">
    <!-- CSS  -->
    <link href="/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Oswald:600" rel="stylesheet">
    @yield('additional-fonts')
    <link href="/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link href="/css/medium-editor.css" type="text/css" rel="stylesheet"/>
    <link href="/css/medium-editor/default.css" type="text/css" rel="stylesheet"/>
    <link href="/css/daterangepicker.css" rel="stylesheet" type="text/css">
    <link href="/css/app.css?v=48" type="text/css" rel="stylesheet"/>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Sports Business Solutions</title>
    <!-- Twitter Card data -->
    <meta name="twitter:card" value="summary">
    <meta name="description" content="@yield('description', 'Sports Business Solutions provides training, consulting, and recruiting services for sports teams and provide career services for those interested in working in sports.')" />
    <!-- OPEN GRAPH -->
    <meta property="og:title" content="@yield('title', 'Sports Business Solutions') | Sports Business Solutions" />
    <meta property="og:description" content="@yield('description', 'Sports Business Solutions provides training, consulting, and recruiting services for sports teams and provide career services for those interested in working in sports.')" />
    <meta property="og:image" content="@yield('image', url('/').'/images/Share-Sports-Business-Solutions.png')">
    <meta property="og:image:height" content="520">
    <meta property="og:image:width" content="1000">
    <meta property="og:url" content="@yield('url', url('/'))">
    <!-- CSS  -->
    <link href="/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Oswald:600" rel="stylesheet">
    <link href="/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link href="/css/medium-editor.css" type="text/css" rel="stylesheet"/>
    <link href="/css/medium-editor/default.css" type="text/css" rel="stylesheet"/>
    <link href="/css/daterangepicker.css" rel="stylesheet" type="text/css">
    <link href="/css/app.css?v=36" type="text/css" rel="stylesheet"/>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

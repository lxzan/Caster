<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ isset($title) ? $title : APP_NAME . ' Admin' }}</title>
    <link href="/static/plugin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .center { text-align: center; }
    </style>
    @yield('css')
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/whitelist">{{APP_NAME}} Admin</a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/whitelist">WhiteList</a></li>
                <li><a href="/analysis">Data Analysis</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$_SERVER['PHP_AUTH_USER']}} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/whitelist/logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container" id="app">@yield('content')</div>
<script src="/static/plugin/jquery.min.js"></script>
<script src="/static/plugin/bootstrap/dist/js/bootstrap.min.js"></script>
@yield('js')
</body>
</html>
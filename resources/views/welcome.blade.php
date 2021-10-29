<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name')}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
           
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        @auth
            <div id="app">
                <div id="layout-wrapper">
                    <Topbar></Topbar>
                    <div class="main-content">
                        <div class="container-fluid">
                            <router-view></router-view>
                        </div>
                        <Footer />
                    </div>
                </div>
            </div>
        @else
            <div id="app">
                <router-view></router-view>
            </div>
        @endauth
        <script type="text/javascript">
            window.NH = {};
            window.NH.lang = 'cn';
            @auth
                window.token="";
                window.user = {!!Auth::User()->toWebJson() !!};
            @else
                window.token=null;
                window.user=null;
            @endauth

            window.msg = '{{$msg ?? ''}}';
        </script>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>

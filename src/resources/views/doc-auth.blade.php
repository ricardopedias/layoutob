<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ Authentication::getLogin()->getTitle() }}</title>

        <meta name="admin-url" content="{{ config('layout-ui.admin_url') }}">
        <meta name="environment" content="{{ env('APP_ENV') }}">
        <meta name="debug" content="{{ env('APP_DEBUG') }}">

        <link rel="stylesheet" href="@asset_theme">
    </head>

    <body class="auth">

        {!! $slot !!}

        <script src="@asset_js('admin.js')"></script>

    </body>

</html>

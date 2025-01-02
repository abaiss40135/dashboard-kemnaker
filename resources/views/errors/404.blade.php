<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id"
        content="732390917608-9r9gi63glh7sa2s967v58977kprk01cj.apps.googleusercontent.com">

    <title>{{ config('app.long_name') }} - 404</title>

    <script src="https://cdn.tailwindcss.com" defer></script>
    <link rel="stylesheet" href="{{ asset('css/crmhq/vendors_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/crmhq/tailwind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/crmhq/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/crmhq/skin_color.css') }}">
</head>
<body class="hold-transition theme-primary bg-img" style="background-image: url('{{ asset('img/bg-kemnaker.png') }}')">
    <section class="error-page h-p100">
        <div class="container h-p100">
            <div class="grid grid-cols-8 h-p100 items-center justify-center text-center">
                <div class="col-start-3 col-span-6">
                    <div class="rounded10 p-50">
                        <h1 class="fs-100">404</h1>
                        <h1>Page Not Found !</h1>
                        <h3 class="text-fade text-xl font-medium">looks like, page doesn't exist</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('js/crmhq/vendors.min.js') }}"></script>
</body>
</html>

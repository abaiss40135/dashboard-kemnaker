<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id" content="732390917608-9r9gi63glh7sa2s967v58977kprk01cj.apps.googleusercontent.com">

    <title>{{ config('app.long_name') }}</title>

    <script src="https://cdn.tailwindcss.com" defer></script>
    <link rel="stylesheet" href="{{ asset('css/crmhq/vendors_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/crmhq/tailwind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/crmhq/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/crmhq/skin_color.css') }}">
</head>
<body
    class="hold-transition theme-primary bg-img"
    style="background-image: url('{{ asset('img/bg-kemnaker.png') }}')"
>
    <div class="login-card login-dark">
        <div class="login-main">
            <div class="theme-form">
                <img
                    src="{{ asset('img/logo-dashboard.png') }}"
                    class="mx-auto w-64 mb-20 pb-20"
                    alt="Kemnaker Logo"
                >
                <div class="relative w-full">
                    <label for="input-label" class="block text-sm font-medium mb-2">Email Address/Username</label>
                    <input
                        type="text"
                        id="input-label"
                        class="border-1 py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="email@domain.com"
                    >
                </div>
                <label class="font-medium block mb-1 mt-4 text-gray-700" for="password">
                    Password
                </label>
                <div class="relative w-full">
                    <input
                        class=" border-1 rounded w-full py-3 px-3 leading-tight border-gray-300 bg-gray-100 focus:outline-none focus:border-indigo-700 focus:bg-white text-gray-700 pr-16 font-mono js-password"
                        id="password"
                        type="password"
                        name="login[password]"
                        autocomplete="off"
                        placeholder="*********"
                    />
                </div>
                <div class="form-group mt-7 flex items-center justify-between">
                    <div class="checkbox flex items-center p-0">
                        <input id="checkbox1" type="checkbox" class="mr-2">
                        <label class="text-muted" for="checkbox1">Remember password</label>
                    </div>
                    <a class="link text-blue-500" href="#">Forgot password?</a>
                </div>
                
                <div class="text-end mt-6">
                    <button
                        class="btn btn-dark btn-block rounded-md text-white w-full"
                        type="submit"
                        onclick="submitForm()"
                    >
                        Sign in
                    </button>
                </div>
                <p class="mt-4 !mb-0 text-center">
                    Don't have account?
                    <a class="ms-2 text-blue-500" href="#">Create Account</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        function submitForm(e)
        {
            setTimeout(() => {
                window.location.href = "{{ route('dashboard-kemnaker.index') }}";
            }, 300)
        }
    </script>
    <script src="{{ asset('js/crmhq/vendors.min.js') }}"></script>
</body>
</html>

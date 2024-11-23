<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BOSv2 | Development</title>
    <link rel="icon" href="{{asset('img/bhabin/binmas.svg')}}" sizes="144x144" type="image/svg">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background-image: url("{{ asset('img/login-bg.jpg') }}");
            background-repeat: repeat;
        }
        main {
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .pesan {
            text-align: center;
            width: clamp(350px, 75%, 800px);
            display: flex;
            flex-direction: column;
        }
        .pesan > h1 {
            color: #222125
        }
    </style>
</head>
<body>
    <main>
        <div class="pesan">
            <h1 class="mb-4">Fitur ini masih dalam tahap pengembangan</h1>
            <span>
                <button class="btn btn-lg btn-danger text-white" onclick="javascript:window.history.back()">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </button>
            </span>
        </div>
    </main>
</body>
</html>
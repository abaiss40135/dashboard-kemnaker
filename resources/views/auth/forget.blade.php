@extends("templates.core.main")

@section('mainComponent')
<link rel="stylesheet" href="{{ asset('css/login/forget.css') }}">
<br>

<div class="divider"></div>
<form class=" shadow">
  <div class="col-auto d-flex justify-content-center mx-auto flex-column">
    <i class="fas fa-lock text-center " style="font-size: 60px; color: #1E4588;"></i><br>
    <h5 class="text-center mx-auto">Reset Password</h5>
  </div>
  <br>
  <div class="d-flex justify-content-between flex-column align-items-center">
    <br>

    <input type="text" class="form-control" id="masukan email anda" style="width: 80%; height: fit-content;" placeholder="masukan email anda">

    <button type="submit" class="btn btn-primary mb-3 mt-4 py-2" style="height: fit-content; width: 80%; background-color: #1E4588;">Kirim Link Reset Password</button>
  </div>

</form>
@endsection

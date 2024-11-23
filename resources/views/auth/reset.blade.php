@extends("templates.core.main")

@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/login/forget.css') }}">
   @if (role('satpam'))
    <style>
        .divider , .reset {
            background: #212529 !important;
        }

        .icon-reset{
            color: #212529 !important;
        }

    </style>
   @endif
@endsection

@section('mainComponent')
<br>

<div class="divider"></div>
<form class="shadow mt-5 reset-password-form" action="{{ url('reset') }}" method="POST">
    @csrf
  <div class="cowl-auto d-flex justify-content-center mx-auto flex-column">
    <i class="fas fa-lock text-center icon-reset" style="font-size: 60px; color: #1E4588;"></i><br>
    <h5 class="text-center mx-auto">Reset Password</h5>
  </div>
  <br>
  <div class="d-flex flex-column px-4">
    <br>
    <div class="my-2">
        <label for="email" class="form-label">Nrp / Email :</label>
        @if(role('administrator' || role('operator_bhabinkamtibmas_polda')))
            <input type="text" class="form-control @error('email') is-invalid @enderror"  name="email" id="email" style="width: 100%; height: fit-content;" placeholder="masukan nrp atau email anda" value="{{ request('nrp') ?? '' }}">
        @else
            <input type="text" class="form-control @error('email') is-invalid @enderror"  name="email" id="email" style="width: 100%; height: fit-content;" placeholder="masukan nrp atau email anda" readonly value="{{ request('nrp') ?? auth()->user()->nrp ?? auth()->user()->email }}">
        @endif

        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="my-2">
        <label for="new_password" class="form-label">Password Baru :</label>
        <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" style="width: 100%; height: fit-content;" placeholder="masukan password baru">
        @error('new_password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="row mt-3">
        <div class="col-6">
            <button type="button" class="btn btn-block w-100 btn-secondary" onclick="window.history.back()">Batal</button>
        </div>
        <div class="col-6">
            <button type="submit" class="btn btn-block w-100 btn-primary reset" style="background-color: #1E4588;">Reset</button>
        </div>
    </div>
  </div>

</form>
@endsection

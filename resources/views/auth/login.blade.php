@extends('layouts.auth')

@section('content')

<!-- form -->
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Username or email" name="login" value="{{ old('email') }}" required autocomplete="email" autofocus>
    </div>
    <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group d-flex justify-content-between">
        <a href="{{ route('pages.register') }}">Register now!</a>
        <a href="{{ route('password.request') }}">Reset password</a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <a class="btn btn-danger btn-block mt-2" download="mamase" href="https://rspaboyolali.com/files/mamase.apk">Download Apk</a>
        </div>
        <div class="col-md-6">
            <button class="btn btn-primary btn-block mt-2">Sign in</button>
        </div>
    </div>
</form>
<!-- ./ form -->

@endsection
@extends('layouts.auth')

@section('content')

    <h5>Form Profile</h5>

    <form method="POST" action="/change-password">
        @csrf
        <div class="form-group d-flex align-items-center">
            <input type="text" name="username" value="{{ Auth::user()->username }}" class="form-control" placeholder="Username">
        </div>
        <div class="form-group d-flex align-items-center">
            <input type="password" name="password" class="form-control" placeholder="New Password">
        </div>
        <button class="btn btn-primary btn-block">Simpan</button>
        <hr>
        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light ml-1">
            Kembali ke Beranda
        </a>
    </form>

</div>

@endsection

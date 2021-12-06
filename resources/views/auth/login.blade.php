@extends('layouts/auth')

@section('title', 'Masuk')

@section('form')
    <form action="/masuk" method="post">
        @csrf
        <div class="mb-3">
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    placeholder="Email" value={{ old('email') }}>
                <label for="email">Email</label>
                <div class="invalid-feedback">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" placeholder="Password">
                <label for="password">Password</label>
                <div class="invalid-feedback">
                    @error('password')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="text-end mt-4 mb-3">
            <a href="/daftar">Belum punya akun?</a>
        </div>
        <div class="d-grid">
            <button class="btn btn-primary">Masuk</button>
        </div>
    </form>
@endsection

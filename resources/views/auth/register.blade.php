@extends('layouts/auth')

@section('title', 'Daftar')

@section('form')
    <form action="/daftar" method="POST">
        @csrf
        <div class="mb-3">
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                    placeholder="Nama" value="{{ old('nama') }}">
                <label for="nama">Nama</label>
                <div class="invalid-feedback">
                    @error('nama')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    placeholder="Email" value="{{ old('email') }}">
                <label for="email">Email</label>
                <div class="invalid-feedback">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="row gy-3">
                <div class="col-12 col-sm">
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
                <div class="col-12 col-sm">
                    <div class="form-floating">
                        <input type="password" class="form-control @error('konfirmasi_password') is-invalid @enderror"
                            id="konfirmasi_password" name="konfirmasi_password" placeholder="Konfirmasi Password">
                        <label for="konfirmasi_password">Konfirmasi Password</label>
                        <div class="invalid-feedback">
                            @error('konfirmasi_password')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end mt-4 mb-3">
            <a href="/masuk">Sudah punya akun?</a>
        </div>
        <div class="d-grid">
            <button class="btn btn-primary">Daftar</button>
        </div>
    </form>
@endsection

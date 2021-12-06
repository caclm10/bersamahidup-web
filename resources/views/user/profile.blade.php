@extends('layouts/main')


@section('content')
    <h2 class="mb-4">Profil Saya</h2>

    <form action="{{ route('update-profile') }}" method="post">
        @method("PATCH")
        @csrf
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                value="{{ auth()->user()->email }}" disabled>
            <label for="email">Email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama"
                placeholder="Nama" value="{{ old('nama') ?: auth()->user()->nama }}">
            <label for="nama">Nama</label>
            <div class="invalid-feedback">
                @error('nama')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="row gy-3 mb-4">
            <div class="col-12 col-sm">
                <div class="form-floating">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Password">
                    <label for="password">Password Baru</label>
                    <div class="invalid-feedback">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </div>
                    <div id="passwordHelp" class="form-text">Kosongkan password jika tidak ingin mengganti</div>
                </div>
            </div>
            <div class="col-12 col-sm">
                <div class="form-floating">
                    <input type="password" class="form-control @error('konfirmasi_password') is-invalid @enderror"
                        id="konfirmasi_password" name="konfirmasi_password" placeholder="Konfirmasi Password">
                    <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                    <div class="invalid-feedback">
                        @error('konfirmasi_password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary">Perbarui</button>
        </div>
    </form>
@endsection

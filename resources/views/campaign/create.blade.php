@extends('layouts/main')

@section('title', 'BersamaHidup - Ajukan Galangan')

@section('meta-description', 'BersamaHidup - Ajukan Galangan. Ajukan galangan yang ingin Anda galangkan disinil. Lengkapi data - data yang dibutuhkan dan Anda dapat langsung melakukan pengajuan')

@section('top')
    <div class="d-flex align-items-center"
        style="background: linear-gradient(90deg, rgba(57,182,255,1) 0%, rgba(160,222,255,1) 24%); height:150px;">
        <div class="container">
            <h2 class="fs-1 text-center">Form Ajukan Galangan Donasi</h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        @error('query')
            <div class="alert alert-danger mb-5" role="alert">
                {{ $message }}
            </div>
        @enderror

        <form action="{{ route('campaigns.store') }}" method="post" data-behavior="normal" enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama"
                    placeholder="Nama" value="{{ old('nama') }}">
                <label for="nama">Nama / Golongan / Daerah Penerima Donasi</label>
                <div class="invalid-feedback">
                    @error('nama')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat"
                    placeholder="Alamat">{{ old('alamat') }}</textarea>
                <label for="alamat">Alamat Penerima Donasi</label>
                <div class="invalid-feedback">
                    @error('alamat')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control only-number @error('rekening') is-invalid @enderror" name="rekening"
                    id="rekening" placeholder="Nomor Rekening" value="{{ old('rekening') }}">
                <label for="rekening">Nomor Rekening</label>
                <div class="invalid-feedback">
                    @error('rekening')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" id="judul"
                    placeholder="Judul Donasi" value="{{ old('judul') }}">
                <label for="judul">Judul Donasi</label>
                <div class="invalid-feedback">
                    @error('judul')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" name="deskripsi" id="deskripsi"
                    placeholder="Deskripsi">{{ old('deskripsi') }}</textarea>
                <label for="deskripsi">Deskripsi</label>

            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control only-number money-format @error('target') is-invalid @enderror"
                    name="target" id="target" placeholder="Target Nominal" value="{{ old('target') }}">
                <label for="target">Target Nominal</label>
                <div class="invalid-feedback">
                    @error('target')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori">
                    <option {{ old('kategori') ? '' : 'selected' }} disabled>Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('kategori') == $category->id ? ' selected' : '' }}>
                            {{ $category->nama }}</option>
                    @endforeach
                </select>
                <label for="kategori">Kategori</label>
                <div class="invalid-feedback">
                    @error('kategori')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="datetime-local" class="form-control @error('waktu') is-invalid @enderror" name="waktu"
                    id="waktu" placeholder="Jangka Waktu" value="{{ old('waktu') }}">
                <label for="waktu">Jangka Waktu</label>
                <div class="invalid-feedback">
                    @error('waktu')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-4">
                <label for="gambar" class="form-label">Gambar</label>
                <input class="form-control @error('gambar') is-invalid @enderror" type="file" id="gambar" name="gambar"
                    accept="image/*">
                <div class="invalid-feedback" value="{{ old('gambar') }}">
                    @error('gambar')
                        {{ $message }}
                    @enderror
                </div>
            </div>


            <div class="d-flex justify-content-end">
                <a href="/" class="btn btn-outline-neutral me-4">Batal</a>
                <button type="submit" class="btn btn-primary">Ajukan</button>
            </div>
        </form>
    </div>
@endsection

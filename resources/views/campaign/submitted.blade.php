@extends('layouts/main')

@section('title', 'BersamaHidup - Pengajuan Berhasil')

@section('content')
    <div class="text-center d-flex flex-column justify-content-center mt-5">
        <h2 class="mb-4">
            Pengajuan berhasil!
            <br>
            Verifikasi akan segera kami lakukan.
        </h2>
        <div>
            <a href="{{ route('campaigns.show', ['id' => $id]) }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection

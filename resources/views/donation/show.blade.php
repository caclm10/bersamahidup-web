@extends('layouts/main')

@section('title', 'BersamaHidup - Data Donasi')

@section('meta-description')
    BersamaHidup adalah sebuah situs web yang mana dibuat untuk meng-inspirasi semua orang untuk saling
    membantu ber-amal di mana pun dan kapan pun tanpa memikirkan susah nya jarak yang dapat di tempuh.
@endsection

@section('content')
    @if ($donation)
        <h2 class="mb-4">Donasi</h2>

        <div class="mb-3">
            <h4>ID</h4>
            <p>{{ $donation->id }}</p>
        </div>
        <div class="mb-3">
            <h4>Nama Donatur</h4>
            <p>{{ $donation->donatur->nama }}</p>
        </div>
        <div class="mb-3">
            <h4>Judul Galangan yang didonasi</h4>
            <p>{{ $donation->galangan->judul }}</p>
        </div>
        <div class="mb-3">
            <h4>Nominal Donasi</h4>
            <p>Rp{{ \NumberHelper::money($donation->nominal) }}</p>
        </div>
        <div class="mb-4">
            <h4>Status Pembayaran</h4>
            <p>{{ $donation->status == 'selesai' ? 'Sudah Dibayar' : 'Menunggu Pembayaran' }}</p>
        </div>

        <div class="d-flex">
            <a href="{{ route('campaigns.show', ['id' => $donation->id_galangan]) }}"
                class="btn btn-outline-primary me-3">Lihat
                Galangan</a>
            <a href="{{ $transaction->checkout_url }}" class="btn btn-outline-accent">Lihat Pembayaran</a>
        </div>
    @else
        <h2 class="text-center">Donasi Tidak Ditemukan</h2>
    @endif
@endsection

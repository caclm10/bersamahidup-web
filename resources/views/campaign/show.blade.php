@extends('layouts/main')


@section('title', "BersamaHidup - " . ($campaign ? $campaign->judul : ''))


@section('meta-description', $campaign ? "BersamaHidup - Galangan $campaign->judul. $campaign->deskripsi" : 'Galangan tidak ditmukan')

@if ($campaign)
    @php
        $progress = ($campaign->terkumpul->jumlah / $campaign->target) * 100;
    @endphp


    @section('top')
        <div class="bg-secondary bg-opacity-30 pt-3 pb-4">
            <div class="container">
                <div class="card h-100 mb-5">
                    <div class="row g-0 position-relative">
                        <div class="col-md-4">
                            <img src="{{ asset($campaign->gambar) }}" class="mw-100 rounded-start h-100 w-100"
                                style="max-height: 277px; object-fit:cover; object-position: top center">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body h-100 d-flex flex-column gap-4 justify-content-between">
                                <h2 class="card-title fs-3 ">{{ $campaign->judul }}</h2>

                                <div>
                                    <span
                                        class="text-accent">Rp{{ \NumberHelper::money($campaign->terkumpul->jumlah) }}</span>
                                    <small class="text-muted">terkumpul
                                        dari
                                        Rp{{ \NumberHelper::money($campaign->target) }}</small>
                                    <div class="progress" style="height: 7px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"
                                            aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>{{ count($donations) }} Donasi</span>
                                        @if (strtotime($campaign->waktu) - now()->unix() > 0)
                                            <small
                                                class="text-muted">{{ \DateHelper::diffEndDays($campaign->waktu) }}
                                        @endif
                                        </small>
                                    </div>
                                </div>

                                @if (!$campaign->tgl_diterima)
                                    <p class="text-center mb-0">Sedang menunggu persetujuan</p>
                                @elseif (strtotime($campaign->waktu) > now()->unix())
                                    <div class="row">
                                        <div class="col-8 d-grid">
                                            <a href="{{ route('payment', ['id' => $campaign->id]) }}"
                                                class="btn btn-accent rounded-3 text-white">Donasi
                                                Sekarang</a>
                                        </div>
                                        <div class="col d-grid">
                                            <button class="btn btn-outline-secondary rounded-3 share-link-btn"
                                                data-link="{{ route('campaigns.show', ['id' => $campaign->id]) }}">Bagikan</button>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-center mb-0">Donasi telah berakhir</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-pills gap-4" id="detailTab">
                    <li class="nav-item">
                        <a class="nav-link tab-link" href="#informasi" data-link="#informasi">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab-link" href="#donatur" data-link="#donatur">Donatur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab-link" href="#bukti" data-link="#bukti">Bukti</a>
                    </li>
                </ul>
            </div>
        </div>
    @endsection

    @section('content')
        <input type="hidden" id="campaign-id" value="{{ $campaign->id }}">
        @if (session('updated'))
            <div class="alert alert-success mb-5" role="alert">
                {{ session('updated') }}
            </div>
        @endif

        <div class="row gx-md-5 gx-0 gy-5 gy-md-0" data-section="#informasi" data-name="detail-section">
            <div class="col-12 col-md-6 order-2 order-md-1">
                @if (!auth()->check() || auth()->id() != $campaign->id_penggalang)
                    <h3>Deskripsi</h3>
                    <hr>
                    <p class="mb-5" style="text-align:justify">
                        {{ $campaign->deskripsi }}
                    </p>
                    <h3>Penggalang</h3>
                    <hr>
                    <p class="mb-5" style="text-align:justify">
                        {{ $campaign->penggalang->nama }}
                    </p>
                    <h3>Nama / Golongan yang akan didonasi</h3>
                    <hr>
                    <p class="mb-5" style="text-align:justify">
                        {{ $campaign->nama }}
                    </p>
                    <h3>Alamat tujuan donasi</h3>
                    <hr>
                    <p class="mb-5" style="text-align:justify">
                        {{ $campaign->alamat }}
                    </p>
                @else
                    <form action="{{ route('campaigns.update', ['id' => $campaign->id]) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                id="nama" placeholder="Nama" value="{{ old('nama') ?: $campaign->nama }}">
                            <label for="nama">Nama / Golongan / Daerah Penerima Donasi</label>
                            <div class="invalid-feedback">
                                @error('nama')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat"
                                placeholder="Alamat">{{ old('alamat') ?: $campaign->alamat }}</textarea>
                            <label for="alamat">Alamat Penerima Donasi</label>
                            <div class="invalid-feedback">
                                @error('alamat')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control only-number @error('rekening') is-invalid @enderror"
                                name="rekening" id="rekening" placeholder="Nomor Rekening"
                                value="{{ old('rekening') ?: $campaign->rekening }}">
                            <label for="rekening">Nomor Rekening</label>
                            <div class="invalid-feedback">
                                @error('rekening')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                                id="judul" placeholder="Judul Donasi" value="{{ old('judul') ?: $campaign->judul }}">
                            <label for="judul">Judul Donasi</label>
                            <div class="invalid-feedback">
                                @error('judul')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="deskripsi" id="deskripsi"
                                placeholder="Deskripsi">{{ old('deskripsi') ?: $campaign->deskripsi }}</textarea>
                            <label for="deskripsi">Deskripsi</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text"
                                class="form-control only-number money-format @error('target') is-invalid @enderror"
                                name="target" id="target" placeholder="Target Nominal" value="{{ $campaign->target }}"
                                disabled>
                            <label for="target">Target Nominal</label>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-3">Edit</button>
                        </div>
                    </form>
                @endif
            </div>
            <div class="col-12 col-md-6 text-center order-1 order-md-2">
                <img src="{{ asset($campaign->gambar) }}" alt="" class="img-fluid">
            </div>
        </div>
        <div class="mw-sm" data-section="#donatur" data-name="detail-section">
            <h3 class="mb-4">Donatur ({{ count($donations) }})</h3>

            @foreach ($donations as $donasi)
                <div>
                    <div class="d-flex mb-3 justify-content-between">
                        <span class="text-info me-5">{{ $donasi->donatur->nama }}</span>
                        <small class="text-muted">
                            {{ \DateHelper::diffString($donasi->tgl_donasi) }}
                        </small>
                    </div>
                    <p>Donasi Rp{{ \NumberHelper::money($donasi->nominal) }}</p>
                    <p>{{ $donasi->donatur->komentar }}</p>
                </div>
                <hr>
            @endforeach
        </div>

        <div data-section="#bukti" data-name="detail-section">
            <div id="gambar-container" class="mb-5">
                @foreach ($campaign->bukti->gambar ?: [] as $gambar)
                    <img src="{{ asset($gambar) }}" alt="bukti-{{ $campaign->id }}-@php echo pathinfo($gambar, PATHINFO_FILENAME) @endphp"
                        class="img-fluid mb-3" style="max-height:400px;" />
                @endforeach
            </div>

            @if (auth()->check() && auth()->id() == $campaign->id_penggalang)
                <div class="mb-5">
                    <label for="bukti-gambar" class="btn btn-primary">+ Gambar</label>
                </div>

                <form id="tambahBuktiKomentarForm">
                    <div class="form-floating mb-3">
                        <textarea name="bukti-komentar" id="bukti-komentar" class="form-control"
                            placeholder="Komentar">{{ $campaign->bukti->komentar }}</textarea>
                        <label for="bukti-komentar">Komentar</label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            @else
                <p style="white-space: pre-wrap;">{{ $campaign->bukti->komentar }}</p>
            @endif
        </div>

        <input type="file" name="bukti-gambar" id="bukti-gambar" class="d-none" multiple accept="image/*">

        @if (auth()->check() && auth()->id() == $campaign->id_penggalang && strtotime($campaign->waktu) > now()->unix())
            <form action="{{ route('campaigns.destroy', ['id' => $campaign->id]) }}"
                class="d-flex justify-content-end mt-7" method="POST"
                onsubmit="return confirm('Yakin ingin {{ $campaign->tgl_diterima ? 'mengakhiri' : 'menghapus' }} galangan ini? Galangan yang {{ $campaign->tgl_diterima ? 'diakhiri' : 'dihapus' }} tidak dapat dikembalikan.')">
                @method("DELETE")
                @csrf
                <button class="btn btn-outline-danger">
                    {{ $campaign->tgl_diterima ? 'Akhiri' : 'Hapus' }}
                    Galangan</button>
            </form>
        @endif
    @endsection

@else

    @section('content')
        <x-campaign.not-found />
    @endsection

@endif

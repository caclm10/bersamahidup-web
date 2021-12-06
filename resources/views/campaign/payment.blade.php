@extends('layouts/main')

@section('title', 'BersamaHidup - Pembayaran')

@section('top')
    @if ($campaign)
        @php
            $progress = ($campaign->terkumpul->jumlah / $campaign->target) * 100;
        @endphp
        <div class="bg-secondary bg-opacity-30 py-3">
            <div class="container">
                <div class="card h-100">
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
                                        <span>{{ $campaign->donasi()->where('status', 'selesai')->count() }} Donasi</span>
                                        @if (strtotime($campaign->waktu) - now()->unix() > 0)
                                            <small
                                                class="text-muted">{{ \Date::parse($campaign->waktu)->diff(now())->days }}
                                                Hari Lagi</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-secondary rounded-3 share-link-btn"
                                        data-link="{{ route('campaigns.show', ['id' => $campaign->id]) }}">Bagikan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('content')
    @error('query')
        <div class="alert alert-danger mb-5" role="alert">
            {{ $message }}
        </div>
    @enderror

    @if ($campaign)
        @if (strtotime($campaign->waktu) - now()->unix() > 0)
            <form action="{{ route('pay', ['id' => $campaign->id]) }}" method="POST">
                @csrf
                <div class="mb-5">
                    <h4>Nominal Donasi</h4>
                    @error('nominal')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="d-flex gap-3 justify-content-between mb-4">
                        <button type="button" class="btn btn-outline-secondary rounded-pill nominal-btn" data-value="10000"
                            style="width:130px;">Rp10.000</button>
                        <button type="button" class="btn btn-outline-secondary rounded-pill nominal-btn" data-value="20000"
                            style="width:130px;">Rp20.000</button>
                        <button type="button" class="btn btn-outline-secondary rounded-pill nominal-btn" data-value="50000"
                            style="width:130px;">Rp50.000</button>
                    </div>
                    <div class="d-flex gap-3 justify-content-between mb-4">
                        <button type="button" class="btn btn-outline-secondary rounded-pill nominal-btn" data-value="100000"
                            style="width:130px;">Rp100.000</button>
                        <button type="button" class="btn btn-outline-secondary rounded-pill nominal-btn" data-value="500000"
                            style="width:130px;">Rp500.000</button>
                        <button type="button" class="btn btn-outline-secondary rounded-pill nominal-btn" data-value="other"
                            style="width:130px;">Lainnya</button>
                    </div>

                    <div class="form-floating" id="nominalWrapper" style="display:none">
                        <input type="text" class="form-control money-format only-number" id="nominal" name="nominal"
                            placeholder="Nominal" value="{{ old('nominal') }}">
                        <label for="nominal">Nominal</label>
                        <div id="nominalHelp" class="form-text">Minimal Rp10.000</div>
                    </div>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">Metode Pembayaran</h4>

                    @foreach ($channels as $channel)
                        <div class="form-check">
                            <input type="radio" name="metode" id="{{ $channel->code }}" value="{{ $channel->code }}"
                                class="form-check-input @error('metode') is-invalid @enderror" @if (old('metode') == $channel->code) checked @endif>
                            <label class="form-check-label" for="{{ $channel->code }}">
                                {{ $channel->name }} <img src="{{ $channel->icon_url }}"
                                    alt="{{ $channel->code }} icon" style="width:40px; margin-left:15px;">
                            </label>
                            @if ($loop->last)
                                <div class="invalid-feedback">
                                    @error('metode')
                                        {{ $message }}
                                    @enderror
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>


                <div class="mb-5">
                    <h4>Data Diri</h4>
                    <div class="row gy-3 mb-3">
                        <div class="col-12 col-md-6">
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" placeholder="Nama">
                            <div class="invalid-feedback">
                                @error('nama')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                            <div class="invalid-feedback">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="nohp" id="nohp" class="form-control @error('nohp') is-invalid @enderror"
                            placeholder="No HP (Isi jika menggunakan OVO)">
                        <div class="invalid-feedback">
                            @error('nohp')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <textarea name="komentar" id="komentar" class="form-control"
                            placeholder="Komentar">{{ old('komentar') }}</textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary" style="width:130px">Bayar</button>
                    </div>
                </div>
            </form>
        @else
            <div class="text-center">
                <h3>Penerimaan donasi sudah ditutup</h3>
            </div>
        @endif
    @else
        <x-campaign.not-found />
    @endif
@endsection

@push('script')
    <script>
        const nominalInput = document.getElementById('nominal')

        if (nominalInput.value) {
            let isOther = false
            let nominalBtn = document.querySelector(`.nominal-btn[data-value='${nominalInput.value}']`)
            if (!nominalBtn) {
                isOther = true
                nominalBtn = document.querySelector(`.nominal-btn[data-value='other']`)
            }
            nominalBtn.classList.replace('btn-outline-secondary', 'btn-secondary')

            if (isOther) {
                document.getElementById('nominalWrapper').style.display = 'block'
            }
        }
    </script>
@endpush

<h3>{{ $title }}</h3>
@if (!$campaigns->isEmpty())
    <div class="row row-cols-1 row-cols-lg-2 g-4">

        @foreach ($campaigns as $campaign)

            @php
                $progress = ($campaign->terkumpul->jumlah / $campaign->target) * 100;
            @endphp

            <div class="col">
                <div class="card h-100 shadow" style="border-color:#a0deff4c;">
                    <div class="row g-0 position-relative h-100">
                        <div class="col-md-4">
                            <img src="{{ asset($campaign->gambar) }}" class="mw-100 rounded-start h-100"
                                style="object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body bg-secondary h-100 bg-opacity-30 d-flex flex-column">
                                <h5 class="card-title">{{ $campaign->judul }}</h5>
                                <p class="card-text"><small
                                        class="text-muted">{{ \Date::parse($campaign->tgl_diajukan)->translatedFormat('d M Y') }}
                                        - {{ \Date::parse($campaign->waktu)->translatedFormat('d M Y') }}</small></p>
                                <p class="card-text text-justify line-clamp-3">{{ $campaign->deskripsi }}</p>

                                <div class="flex-grow-1 d-flex align-items-end">
                                    <div class="w-100">
                                        <div class="mb-3">
                                            <span
                                                class="text-accent">Rp{{ \NumberHelper::money($campaign->terkumpul->jumlah) }}</span>
                                            <small class="text-muted">dari
                                                Rp{{ \NumberHelper::money($campaign->target) }}</small>
                                            <div class="progress" style="height: 7px;">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $progress }}%"
                                                    aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>{{ $campaign->donasi()->where('status', 'selesai')->count() }}
                                                    Donasi</span>
                                                <span>{{ \DateHelper::diffEndDays($campaign->waktu) }}</span>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('campaigns.show', ['id' => $campaign->id]) }}"
                                                class="btn btn-secondary rounded-3">Donasi Sekarang</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@else
    <p class="text-center text-muted">Belum ada galangan</p>
@endif

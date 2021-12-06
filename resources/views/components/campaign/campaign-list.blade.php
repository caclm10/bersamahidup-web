@if ($campaigns)
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
        @foreach ($campaigns as $campaign)
            @php
                $progress = ($campaign->terkumpul->jumlah / $campaign->target) * 100;
            @endphp
            <div class="col">
                <a href="{{ route('campaigns.show', ['id' => $campaign->id]) }}"
                    class="text-decoration-none text-black">
                    <div class="card h-100" role="button">
                        <img src="{{ asset($campaign->gambar) }}" class="card-img-top" alt="..."
                            style="max-height:300px; object-fit:cover;">
                        <div class="card-body position-relative">
                            <span class="badge rounded-pill bg-secondary position-absolute text-black"
                                style="top:-40px; right: 18px;">{{ $campaign->donasi()->where('status', 'selesai')->count() }}
                                Donasi</span>
                            <h5 class="card-title mb-1">{{ $campaign->judul }}</h5>

                            <p class="card-text mb-2"><small
                                    class="text-muted">{{ \Date::parse($campaign->tgl_diajukan)->translatedFormat('d M Y') }}
                                    - {{ \Date::parse($campaign->waktu)->translatedFormat('d M Y') }}</small></p>

                            <p class="card-text text-muted text-justify line-clamp-3">{{ $campaign->deskripsi }}
                            </p>
                            <div class="mb-3">
                                <small class="text-muted">Dari {{ $campaign->penggalang->nama }}</small>
                                <div class="progress" style="height: 7px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"
                                        aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small
                                        class="text-accent">Rp{{ \NumberHelper::money($campaign->terkumpul->jumlah) }}</small>
                                    <small class="text-muted">dari
                                        Rp{{ \NumberHelper::money($campaign->target) }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endif

{{ $campaigns->links('pagination') }}

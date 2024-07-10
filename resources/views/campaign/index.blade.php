@extends('layouts/main')

@section('title', 'BersamaHidup - Daftar Galangan')

@section('meta-description', $category ? 'BersamaHidup - Daftar Galangan ' . $category->nama . ' ' .
    $category->deskripsi : '')

@section('top')
    @if ($category)
        <div class="position-relative d-flex align-items-center"
            style="background: linear-gradient(90deg, rgba(57,182,255,1) 0%, rgba(160,222,255,1) 24%); height:150px;">
            <div class="container text-secondary-dark">
                <h2 class="mb-3">{{ $category->nama }}</h2>
                <p>{{ $category->deskripsi }}</p>
            </div>

            <img id="categoryCover" src="/img/contoh-cover.png" alt="contoh-cover"
                class="position-absolute end-0 top-0 h-100 d-none d-lg-block">
        </div>
    @endif
@endsection

@section('content')
    @if ($category)
        <x-campaign.campaign-list :campaigns="$campaigns" />
    @else
        @if ($slug == '')
            <h2 class="mb-3">Pilih Kategori</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($categories as $category)
                    <div class="col">
                        <a href="/campaigns?kategori={{ $category->slug }}" class="text-decoration-none text-dark">
                            <div class="card border-dark h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $category->nama }}</h5>
                                    <p class="card-text">{{ $category->deskripsi }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <h2 class="text-center pt-6">Kategori Tidak Ditemukan</h2>
        @endif
    @endif


@endsection

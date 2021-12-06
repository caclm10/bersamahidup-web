@extends('layouts/main')

@section('title', 'BersamaHidup - Home')

@section('meta-description', 'BersamaHidup adalah sebuah situs web yang mana dibuat untuk meng-inspirasi semua orang untuk saling membantu ber-amal di mana pun dan kapan pun tanpa memikirkan susah nya jarak yang dapat di tempuh.')

@php
$useHero = true;
@endphp

@section('content')

    <section id="galangan-terbaru" class="mb-5">
        <x-home.campaign-list title="Galangan Terbaru" :campaigns="$latest" />
    </section>

    <section id="akan-berakhir">
        <x-home.campaign-list title="Akan Berakhir" :campaigns="$endSoon" />
    </section>


@endsection

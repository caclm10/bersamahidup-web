@extends('layouts/main')


@section('content')
    <h2 class="mb-4">Galangan Saya</h2>
    <x-campaign.campaign-list :campaigns="$campaigns" />
@endsection

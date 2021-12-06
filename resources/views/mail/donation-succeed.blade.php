@component('mail::message')
# Donasi Berhasil

Donasi atas nama {{$donation->donatur->nama}} dengan ID {{ $donation->id }} yang bernominalkan Rp{{ \NumberHelper::money($donation->nominal) }} telah
berhasil
dilakukan. Terima kasih atas bantuan Anda.

@component('mail::button', ['url' => route('donation.show', ['id' => $donation->id])])
    Lihat Detail
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent

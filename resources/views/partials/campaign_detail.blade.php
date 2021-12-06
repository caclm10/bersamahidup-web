<div class="mb-3">
    <h5>Judul Galangan</h5>
    <p>{{ $campaign->judul }}</p>
</div>
<div class="mb-3">
    <h5>Deskripsi</h5>
    <p>{{ $campaign->deskripsi }}</p>
</div>
<div class="mb-3">
    <h5>Rekening</h5>
    <p>{{ $campaign->rekening }}</p>
</div>
<div class="mb-3">
    <h5>Target Donasi</h5>
    <p>Rp{{ \NumberHelper::money($campaign->target) }}</p>
</div>
<div class="mb-3">
    <h5>Batas Waktu</h5>
    <p>{{ \Date::parse($campaign->waktu)->isoFormat('LLLL') }}</p>
</div>
<div class="mb-3">
    <h5>Nama / Golongan yang akan didonasi</h5>
    <p>{{ $campaign->nama }}</p>
</div>
</div>
<div class="mb-3">
    <h5>Alamat yang akan didonasi</h5>
    <p>{{ $campaign->alamat }}</p>
</div>
<div class="mb-3">
    <h5>Penggalang</h5>
    <p>{{ $campaign->penggalang->nama }} | {{ $campaign->penggalang->email }}</p>
</div>

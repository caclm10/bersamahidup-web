@if ($paginator->hasPages())
    <div class="d-flex">
        <div class="mx-auto d-flex pagination">
            @if (!$paginator->onFirstPage())
                <a href="{{ $paginator->url(1) }}" class="btn btn-secondary-light">Awal</a>
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-secondary-light">Sebelumnya</a>
            @endif
            <span class="btn btn-secondary-light text-muted">Halaman {{ $paginator->currentPage() }} dari
                {{ $paginator->lastPage() }}</span>
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-secondary-light">Selanjutnya</a>
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="btn btn-secondary-light">Akhir</a>
            @endif
        </div>
    </div>

@endif

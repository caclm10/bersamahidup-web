<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin</title>

    @if (env('APP_ENV') == 'production')
        <link rel="stylesheet" href="/css/app.css">
        <script src="/js/app.js"></script>
    @else
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}"></script>
    @endif

    <style>
        body {
            background-color: #eeeeee;
        }

        .sidebar {
            position: fixed;
            background-color: #59ba47;
            top: 0;
            left: 0;
            bottom: 0;
            width: 170px;
            padding: 80px 10px;
            color: #fff;
        }

        .sidebar__menu {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            row-gap: 15px;
        }

        .sidebar__menu>* {
            color: #fff;
            text-decoration: none;
            padding: 6px 8px;
            border-radius: 5px;
        }

        .sidebar__menu>button {
            background-color: transparent;
            border: none;
            text-align: left;
        }

        .sidebar__menu>*:hover {
            color: #fff;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .sidebar__menu>*.--active {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .content {
            margin: 100px 0;
            padding-left: 170px;
        }

    </style>
</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="campaignDetail" tabindex="-1" aria-labelledby="campaignDetailLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="campaignDetailLabel">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-justify" id="campaignDetailBody">

                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST" id="logout">
        @csrf
    </form>
    <aside class="sidebar">
        <nav class="sidebar__menu">
            <a href="/admin/campaigns" class="@if (url()->current() == route('admin-campaigns')) --active @endif">
                Galangan
            </a>
            <button form="logout">Logout</button>
        </nav>
    </aside>

    <div class="content">
        <div class="container">
            <main class="card">
                <div class="card-body">
                    <h1 class="card-tile mb-3">
                        Galangan
                    </h1>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Judul Galangan</th>
                                <th scope="col">Penggalang</th>
                                <th scope="col">Tanggal Diterima</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($campaigns as $index => $campaign)
                                <tr data-campaign-id="{{ $campaign->id }}">
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $campaign->judul }}</td>
                                    <td>{{ $campaign->penggalang->nama }}</td>
                                    <td>{{ $campaign->tgl_diterima ?: '-' }}</td>
                                    <td class="d-flex gap-3">
                                        <button class="btn btn-sm btn-secondary show-campaign-detail-button"
                                            data-campaign-id="{{ $campaign->id }}" data-bs-toggle="modal"
                                            data-bs-target="#campaignDetail">
                                            Detail
                                        </button>
                                        <div class="d-flex gap-3" data-campaign-id="{{ $campaign->id }}">
                                            @if (!$campaign->tgl_diterima)
                                                <button class="accept-button btn btn-sm btn-primary">
                                                    Terima
                                                </button>
                                                <button class="reject-button btn btn-sm btn-danger">
                                                    Tolak
                                                </button>
                                            @else
                                                <span>Penggalangan ini telah diterima</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>

</html>

<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latest = Campaign::whereRaw('TIMESTAMPDIFF(SECOND, CURRENT_TIMESTAMP, waktu) > 0')
            ->where('tgl_diterima', '<>', NULL)
            ->orderBy('tgl_diajukan', 'desc')
            ->limit(2)
            ->get();

        $endSoon = Campaign::selectRaw('id, target, gambar, waktu, judul, tgl_diajukan, deskripsi, TIMESTAMPDIFF(SECOND, CURRENT_TIMESTAMP, waktu) as sisa_waktu')
            ->whereRaw('TIMESTAMPDIFF(SECOND, CURRENT_TIMESTAMP, waktu) > 0')
            ->where('tgl_diterima', '<>', NULL)
            ->orderBy('sisa_waktu')
            ->limit(2)
            ->get();

        return view('home', [
            'latest' => $latest,
            'endSoon' => $endSoon
        ]);
    }
}

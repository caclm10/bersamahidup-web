<?php

namespace App\Http\Controllers;

use App\Mail\DonationSucceed;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\CollectedDonation;
use App\Models\Donation;
use App\Models\Donator;
use App\Models\Proof;
use App\Models\User;
use App\Services\Tripay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only(['create', 'store', 'update', 'destroy', 'addImagesProof', 'addCommentProof']);
    }

    public function index(Request $request)
    {
        $categorySlug = $request->input('kategori');
        $category = Category::where('slug', $categorySlug)->first();

        if ($category) {
            $campaigns = $category->galangan()->where('tgl_diterima', '<>', NULL)->orderBy('tgl_diajukan', 'desc')->paginate(3);
        }

        return view('campaign.index', [
            'category' => $category,
            'campaigns' => $campaigns ?? NULL,
            'slug' => $categorySlug,
        ]);
    }


    public function create()
    {
        return view('campaign.create');
    }

    public function store(Request $request)
    {
        $longest = Date::now()->addMonths(6);
        $soonest = Date::now()->addWeeks(2);

        $data = $request->validate([
            'nama' => 'required|max:50',
            'alamat' => 'required|max:255',
            'rekening' => 'required|max:16',
            'judul' => 'required|max:80',
            'target' => 'required|numeric|gte:1000000',
            'kategori' => 'required',
            'waktu' => "required|date|after_or_equal:$soonest|before_or_equal:$longest",
            'gambar' => 'required|image'
        ], [
            'nama.required' => 'Nama harus diisi',
            'nama.max' => 'Maksimal 50 karakter',
            'alamat.required' => 'Alamat harus diisi',
            'alamat.max' => 'Maksimal 255 karakter',
            'rekening.required' => 'Nomor Rekening harus diisi',
            'rekening.max' => 'Maksimal 16 karakter',
            'judul.required' => 'Judul harus diisi',
            'judul.max' => 'Maksimal 80 karakter',
            'target.required' => 'Target harus diisi',
            'target.numeric' => 'Target harus berupa angka',
            'target.gte' => 'Target minimal Rp1.000.000',
            'kategori.required' => 'Pilih salah satu kategori',
            'waktu.required' => 'Jangka waktu harus diisi',
            'waktu.date' => 'Format waktu tidak valid',
            'waktu.after_or_equal' => 'Jangka waktu paling cepat adalah 2 minggu',
            'waktu.before_or_equal' => 'Jangka waktu paling lama adalah 6 bulan',
            'gambar.required' => 'Gambar harus disertakan',
            'gambar.image' => 'Format gambar tidak valid'
        ]);

        $data['deskripsi'] = $request->deskripsi;
        $data['id_kategori'] = $request->kategori;
        $data['id_penggalang'] = Auth::id();

        $gambar = $request->file('gambar');
        $path = $gambar->store('images/donasi');
        $data['gambar'] = $path;

        try {
            $campaign = new Campaign($data);

            DB::transaction(function () use ($campaign) {
                $campaign->save();

                $collectedDonation = new CollectedDonation;
                $collectedDonation->id_galangan = $campaign->id;
                $collectedDonation->save();

                $proof = new Proof;
                $proof->id_galangan = $campaign->id;
                $proof->save();
            });

            return redirect()->route('campaigns.submitted', ['id' => $campaign->id]);
        } catch (\Throwable $e) {
            if (env('APP_ENV') === 'local') {
                dd($e);
            }

            $errors = new MessageBag();
            $errors->add('query', 'Terjadi kesalahan dalam menyimpan data, coba beberapa saat lagi');
            return redirect()->route('campaigns.create')->withErrors($errors);
        }
    }

    public function show($id)
    {
        $campaign = Campaign::find($id);
        $donations = [];

        if ($campaign && !$campaign->isAvailable()) {
            $campaign = null;
        }

        if ($campaign) {
            $donations = $campaign->donasi()->where('status', 'selesai')->orderBy('tgl_donasi', 'desc')->get(['id', 'tgl_donasi', 'nominal']);
        }

        return view('campaign.show', compact('campaign', 'donations'));
    }

    public function update(Request $request, $id)
    {
        $campaign = Campaign::find($id, ['id_penggalang']);

        if (!$campaign || $campaign->id_penggalang != auth()->id())
            return redirect()->back();

        $data = $request->validate([
            'nama' => 'required|max:50',
            'alamat' => 'required|max:255',
            'rekening' => 'required|max:16',
            'judul' => 'required|max:80',
        ], [
            'nama.required' => 'Nama harus diisi',
            'nama.max' => 'Maksimal 50 karakter',
            'alamat.required' => 'Alamat harus diisi',
            'alamat.max' => 'Maksimal 255 karakter',
            'rekening.required' => 'Nomor Rekening harus diisi',
            'rekening.max' => 'Maksimal 16 karakter',
            'judul.required' => 'Judul harus diisi',
            'judul.max' => 'Maksimal 80 karakter',
        ]);

        $data['deskripsi'] = $request->input('deskripsi');
        Campaign::where('id', $id)->update($data);

        return redirect()->route('campaigns.show', ['id' => $id])->with('updated', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $campaign = Campaign::find($id);

        if (!$campaign || $campaign->id_penggalang != auth()->id())
            return redirect()->back();


        if (!$campaign->tgl_diterima) {
            Campaign::destroy($id);
            return redirect()->route('my-campaigns');
        } else {
            $campaign->waktu = now();
            $campaign->save();
            return redirect()->route('campaigns.show', ['id' => $id]);
        }
    }

    public function submitted($id)
    {
        $campaign = Campaign::find($id, ['id', 'id_penggalang', 'tgl_diterima']);
        if (!$campaign)
            return redirect()->route('campaigns.index');

        if (!auth()->check() || auth()->id() !== $campaign->penggalang->id || $campaign->tgl_diterima)
            return redirect()->route('campaigns.show', ['id' => $id]);


        return view('campaign.submitted', [
            'id' => $campaign->id,
        ]);
    }

    public function payment(Tripay $tripay, $id)
    {
        $channels = $tripay->getPaymentChannels();

        $campaign = Campaign::find($id);

        if (!$campaign->tgl_diterima)
            return redirect()->route('campaigns.show', ['id' => $id]);



        return view('campaign.payment', compact('channels', 'campaign'));
    }

    public function pay(Request $request, Tripay $tripay, $id)
    {
        // dd($request->all());
        $campaign = Campaign::find($id);

        if (!$campaign || strtotime($campaign->waktu) - now()->unix() < 0 || !$campaign->tgl_diterima) {
            return redirect()->back();
        }


        $data = $request->validate([
            'nominal' => 'required|numeric|gte:10000',
            'metode' => 'required',
            'nama' => 'required|max:50',
            'email' => 'required|email',
            'nohp' => 'nullable|required_if:metode,OVO|digits_between:1,14',
        ], [
            'nominal.required' => 'Pilih / Masukkan Nominal',
            'nominal.numeric' => 'Format nominal tidak sesuai',
            'nominal.gte' => 'Nilai nominal minimal Rp10.000',
            'metode.required' => 'Pilih salah satu metode',
            'nama.required' => 'Nama harus diisi',
            'nama.max' => 'Maksimal 50 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'nohp.required_if' => 'Pembayaran OVO wajib memasukkan nomor HP',
            'nohp.digits_between' => 'Hanya dapat berupa angka (maksimal 14 angka)',
        ]);

        $errors = new MessageBag();

        $id_donasi = Str::orderedUuid();
        $transaction = $tripay->requestTransaction($data['metode'], $data['nominal'], [
            'email' => $data['email'],
            'nama' => $data['nama'],
            'nohp' => $data['nohp'],
        ], $campaign, $id_donasi);

        if (!$transaction) {
            $errors->add('transaction', 'Terjadi kesalahan dalam membuat transaksi. Silahkan coba lagi');
            return redirect()->back()->withError($errors);
        }

        try {
            DB::transaction(function () use ($id, $id_donasi, $data, $request, $transaction) {

                $donation = new Donation;
                $donation->id = $id_donasi;
                $donation->id_galangan = $id;
                $donation->nominal = $data['nominal'];
                $donation->transaksi_ref = $transaction->reference;
                if (env('APP_ENV') != 'production') {
                    $donation->tgl_donasi = now();
                    $donation->status = 'selesai';
                }

                $donation->save();

                $donator = new Donator;
                $donator->id = Str::orderedUuid();
                $donator->id_donasi = $id_donasi;
                $donator->nama = $data['nama'];
                $donator->email = $data['email'];
                $donator->komentar = $request->input('komentar');
                $donator->save();

                if (env('APP_ENV') != 'production') {
                    $collectedDonation = CollectedDonation::where('id_galangan', $id)->first();
                    $collectedDonation->jumlah += $data['nominal'];
                    $collectedDonation->save();

                    Mail::to(new User(['email' => $donation->donatur->email]))
                        ->send(new DonationSucceed($donation));
                }
            });

            return redirect()->to($transaction->checkout_url);
        } catch (\Throwable $e) {
            if (env('APP_ENV') === 'local') {
                dd($e);
            }

            $errors->add('query', 'Terjadi kesalahan dalam menyimpan data, coba beberapa saat lagi');
            return redirect()->to("campaigns/$id/payment")->withErrors($errors);
        }
    }

    public function paid($id)
    {
        if (!session('success'))
            return redirect()->route('campaigns.show', ['id' => $id]);


        return view('campaign.paid', [
            'id' => $id,
        ]);
    }

    public function addImagesProof(Request $request, $id)
    {
        $campaign = Campaign::find($id);

        if (!$campaign)
            return response()->json([], 404);

        if ($campaign->penggalang->id !== auth()->id())
            return response()->json([], 401);


        $images = $request->file('gambar');

        $paths = [];
        foreach ($images as $image) {
            $paths[] = $image->store("images/galangan/$id/bukti");
        }

        $bukti = $campaign->bukti;

        $prevBukti = $bukti->gambar;
        $bukti->gambar = array_merge($prevBukti ?: [], $paths);
        $bukti->save();

        foreach ($paths as $key => $path) {
            $paths[$key] = asset($path);
        }

        return response()->json($paths);
    }

    public function addCommentProof(Request $request, $id)
    {
        $campaign = Campaign::find($id);

        if (!$campaign)
            return response()->json([], 404);

        if ($campaign->penggalang->id !== auth()->id())
            return response()->json([], 401);

        $comment = $request->input('komentar');

        $bukti = $campaign->bukti;
        $bukti->komentar = $comment;
        $bukti->save();

        return response()->json([
            'komentar' => $comment,
        ]);
    }
}

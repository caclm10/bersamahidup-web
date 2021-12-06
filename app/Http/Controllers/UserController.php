<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function campaigns()
    {
        $campaigns = Campaign::where('id_penggalang', Auth::id())->paginate(9);

        return view('user.campaigns', [
            'campaigns' => $campaigns
        ]);
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'min:4', 'max:50', 'regex:/^[a-zA-Z ]*$/'],
            'password' => 'nullable|min:4|max:16|string',
            'konfirmasi_password' => 'nullable|same:password'
        ], [
            'nama.required' => 'Nama harus diisi',
            'nama.min' => 'Nama diisi dengan minimal 4 karakter',
            'nama.max' => 'Nama diisi dengan maksimal 50 karakter',
            'nama.regex' => 'Nama hanya dapat diisi dengan huruf dan spasi',
            'password.min' => 'Password diisi dengan minimal 4 karakter',
            'password.max' => 'Password diisi dengan maksimal 16 karakter',
            'password.string' => 'Password harus berupa karakter',
            'konfirmasi_password.same' => 'Konfirmasi password tidak sesuai dengan password',
        ]);

        $user = User::find(auth()->id());

        $user->nama = $data['nama'];
        if ($data['password']) {
            $user->password = bcrypt($data['password']);
        }

        $user->save();

        return redirect()->route('profile')->with('updated', 'Berhasil memperbarui profil');
    }
}

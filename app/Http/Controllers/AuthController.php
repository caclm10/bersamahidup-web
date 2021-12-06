<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function viewRegister()
    {
        return view('auth.register');
    }

    public function viewLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'min:4', 'max:70', 'regex:/^[a-zA-Z ]*$/'],
            'email' => 'required|email|unique:pengguna,email|max:70',
            'password' => 'required|min:4|max:16|string',
            'konfirmasi_password' => 'required|same:password'
        ], [
            'nama.required' => 'Nama harus diisi',
            'nama.min' => 'Nama diisi dengan minimal 4 karakter',
            'nama.max' => 'Nama diisi dengan maksimal 70 karakter',
            'nama.regex' => 'Nama hanya dapat diisi dengan huruf dan spasi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email telah terdaftar',
            'email.max' => 'Email diisi dengan maksimal 70 karakter',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password diisi dengan minimal 4 karakter',
            'password.max' => 'Password diisi dengan maksimal 16 karakter',
            'password.string' => 'Password harus berupa karakter',
            'konfirmasi_password.required' => 'Konfirmasi password harus diisi',
            'konfirmasi_password.same' => 'Konfirmasi password tidak sesuai dengan password',
        ]);

        $user = new User;

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended();
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        $errors = new MessageBag();
        if (!$user) {
            $errors->add('email', trim($request->email) ? 'Email tidak terdaftar' : 'Email harus diisi');

            if (!trim($request->password)) {
                $errors->add('password', 'Password harus diisi');
            }
        } else if (!Hash::check($request->password, $user->password)) {
            $errors->add('password', trim($request->password) ? 'Password salah' : 'Password harus diisi');
        }


        if ($errors->any()) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended($user->admin ? '/admin' : '/');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

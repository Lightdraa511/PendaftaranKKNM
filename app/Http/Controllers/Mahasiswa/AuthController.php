<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('mahasiswa.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nim' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('mahasiswa')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('mahasiswa.dashboard'));
        }

        return back()->withErrors([
            'nim' => 'NIM atau password salah.',
        ])->onlyInput('nim');
    }

    public function showRegisterForm()
    {
        return view('mahasiswa.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas',
            'nama' => 'required',
            'email' => 'required|email|unique:mahasiswas',
            'password' => 'required|min:8|confirmed',
            'no_hp' => 'required',
            'fakultas' => 'required',
            'prodi' => 'required',
            'alamat' => 'required',
        ]);

        $mahasiswa = Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
            'alamat' => $request->alamat,
        ]);

        Auth::guard('mahasiswa')->login($mahasiswa);

        return redirect()->route('mahasiswa.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('mahasiswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('mahasiswa.login');
    }
}

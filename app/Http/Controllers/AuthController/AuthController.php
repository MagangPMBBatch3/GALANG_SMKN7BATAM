<?php

namespace App\Http\Controllers\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User\User;

class AuthController
{
    public function showLogin()
    {
   
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();    
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang salah.',
        ]);
    }

    public function dashboard()
    {
        return view('dashboard/index');
    }

    public function bagian()
    {
        return view('bagian.index');
    }

    public function level()
    {
        return view('level.index');
    }

    public function status()
    {
        return view('status.index');
    }

    public function user()
    {
        return view('user.index');
    }

    public function userprofile()
    {
        return view('userprofile.index');
    }

    public function proyek()
    {
        return view('proyek.index');
    }

    public function keterangan()
    {
        return view('keterangan.index');
    }

    public function aktivitas()
    {
        return view('aktivitas.index');
    }

    public function ModeJamKerja()
    {
        return view('mode-jam-kerja.index');
    }

    public function StatusJamKerja()
    {
        return view('status-jam-kerja.index');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function progresKerja()
    {
        return view('progres-kerja.index');
    }

    public function lembur()
    {
        return view('lembur.index');
    }

    public function pesan()
    {
        return view('pesan.index');
    }

    public function jenisPesan()
    {
        return view('jenis-pesan.index');
    }

    public function uploadFoto(Request $request)
    {
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            if ($file->isValid() && str_starts_with($file->getMimeType(), 'image/')) {
                $path = $file->store('public/foto'); 
                $url = Storage::url($path); 
                return response()->json(['url' => $url]);
            }
        }
        return response()->json(['error' => 'File tidak valid atau bukan gambar'], 400);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    
}
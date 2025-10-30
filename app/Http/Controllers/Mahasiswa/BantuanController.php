<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BantuanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        return view('Mahasiswa.bantuan.index', compact('mahasiswa'));
    }

    public function dokumentasi()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        return view('Mahasiswa.bantuan.dokumentasi', compact('mahasiswa'));
    }

    public function kontak()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        return view('Mahasiswa.bantuan.kontak', compact('mahasiswa'));
    }
}

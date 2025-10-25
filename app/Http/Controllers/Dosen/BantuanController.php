<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BantuanController extends Controller
{
    public function index()
    {
        return view('dosen.bantuan.index');
    }

    public function dokumentasi()
    {
        return view('dosen.bantuan.dokumentasi');
    }

    public function kontak()
    {
        return view('dosen.bantuan.kontak');
    }
}

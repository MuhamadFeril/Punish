<?php

namespace App\Http\Controllers;

use App\Models\Sanksi;

class SanksiController extends Controller
{
    public function index()
    {
        $sanksi = Sanksi::with('pelanggaran.karyawan')->paginate(15);
        return view('sanksi.index', compact('sanksi'));
    }

    public function show(Sanksi $sanksi)
    {
        $sanksi->load('pelanggaran.karyawan.departemen', 'pelanggaran.jenisPelanggaran');
        return view('sanksi.show', compact('sanksi'));
    }
}

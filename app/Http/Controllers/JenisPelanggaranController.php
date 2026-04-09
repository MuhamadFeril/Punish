<?php

namespace App\Http\Controllers;

use App\Models\Jenispelanggaran;
use Illuminate\Http\Request;

class JenisPelanggaranController extends Controller
{
    public function index()
    {
        $jenisPelanggaran = Jenispelanggaran::all();
        return view('jenis-pelanggaran.index', compact('jenisPelanggaran'));
    }

    public function create()
    {
        return view('jenis-pelanggaran.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'deskripsi_pelanggaran' => 'required|string',
            'tingkat_pelanggaran' => 'required|in:ringan,sedang,berat',
        ]);

        Jenispelanggaran::create($validated);
        return redirect('jenis-pelanggaran')->with('success', 'Jenis pelanggaran berhasil ditambahkan');
    }

    public function edit(Jenispelanggaran $jenisPelanggaran)
    {
        return view('jenis-pelanggaran.form', compact('jenisPelanggaran'));
    }

    public function update(Request $request, Jenispelanggaran $jenisPelanggaran)
    {
        $validated = $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'deskripsi_pelanggaran' => 'required|string',
            'tingkat_pelanggaran' => 'required|in:ringan,sedang,berat',
        ]);

        $jenisPelanggaran->update($validated);
        return redirect('jenis-pelanggaran')->with('success', 'Jenis pelanggaran berhasil diupdate');
    }

    public function destroy(Jenispelanggaran $jenisPelanggaran)
    {
        if ($jenisPelanggaran->pelanggaran()->count() > 0) {
            return redirect('jenis-pelanggaran')->with('error', 'Tidak bisa menghapus jenis pelanggaran yang masih terpakai');
        }

        $jenisPelanggaran->delete();
        return redirect('jenis-pelanggaran')->with('success', 'Jenis pelanggaran berhasil dihapus');
    }
}

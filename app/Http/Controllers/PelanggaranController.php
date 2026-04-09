<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Karyawan;
use App\Models\Jenispelanggaran;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggaran::with('karyawan', 'jenisPelanggaran');

        if ($request->search) {
            $query->where('keterangan_pelanggaran', 'like', '%' . $request->search . '%')
                  ->orWhereHas('karyawan', function ($q) use ($request) {
                      $q->where('nama_karyawan', 'like', '%' . $request->search . '%');
                  });
        }

        $pelanggaran = $query->paginate(15);
        return view('pelanggaran.index', compact('pelanggaran'));
    }

    public function create()
    {
        $karyawans = Karyawan::all();
        $jenisPelanggaran = Jenispelanggaran::all();
        return view('pelanggaran.form', compact('karyawans', 'jenisPelanggaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal_pelanggaran' => 'required|date',
            'keterangan_pelanggaran' => 'required|string',
            'bukti_pelanggaran' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('bukti_pelanggaran')) {
            $validated['bukti_pelanggaran'] = $request->file('bukti_pelanggaran')->store('pelanggaran', 'public');
        }

        Pelanggaran::create($validated);
        return redirect('pelanggaran')->with('success', 'Pelanggaran berhasil dilaporkan');
    }

    public function show(Pelanggaran $pelanggaran)
    {
        $pelanggaran->load('karyawan.departemen', 'jenisPelanggaran', 'sanksi');
        return view('pelanggaran.show', compact('pelanggaran'));
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        $karyawans = Karyawan::all();
        $jenisPelanggaran = Jenispelanggaran::all();
        return view('pelanggaran.form', compact('pelanggaran', 'karyawans', 'jenisPelanggaran'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal_pelanggaran' => 'required|date',
            'keterangan_pelanggaran' => 'required|string',
            'bukti_pelanggaran' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('bukti_pelanggaran')) {
            $validated['bukti_pelanggaran'] = $request->file('bukti_pelanggaran')->store('pelanggaran', 'public');
        }

        $pelanggaran->update($validated);
        return redirect('pelanggaran')->with('success', 'Pelanggaran berhasil diupdate');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        $pelanggaran->delete();
        return redirect('pelanggaran')->with('success', 'Pelanggaran berhasil dihapus');
    }
}

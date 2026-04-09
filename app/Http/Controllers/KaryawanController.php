<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Departemen;
use App\Http\Requests\KaryawanRequest;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with('departemen')->paginate(15);
        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        $departemens = Departemen::all();
        return view('karyawan.form', compact('departemens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'email_karyawan' => 'required|email|unique:karyawan',
            'alamat_karyawan' => 'nullable|string',
            'departemen_id' => 'required|exists:departemens,id',
            'jabatan_karyawan' => 'required|string|max:255',
            'status' => 'required|in:aktif,non-aktif',
            'foto_karyawan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto_karyawan')) {
            $validated['foto_karyawan'] = $request->file('foto_karyawan')->store('karyawan', 'public');
        }

        Karyawan::create($validated);
        return redirect('karyawan')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function show(Karyawan $karyawan)
    {
        $karyawan->load('departemen', 'pelanggaran.jenisPelanggaran');
        return view('karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        $departemens = Departemen::all();
        return view('karyawan.form', compact('karyawan', 'departemens'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'email_karyawan' => 'required|email|unique:karyawan,email_karyawan,' . $karyawan->id,
            'alamat_karyawan' => 'nullable|string',
            'departemen_id' => 'required|exists:departemens,id',
            'jabatan_karyawan' => 'required|string|max:255',
            'status' => 'required|in:aktif,non-aktif',
            'foto_karyawan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto_karyawan')) {
            $validated['foto_karyawan'] = $request->file('foto_karyawan')->store('karyawan', 'public');
        }

        $karyawan->update($validated);
        return redirect('karyawan')->with('success', 'Karyawan berhasil diupdate');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect('karyawan')->with('success', 'Karyawan berhasil dihapus');
    }
}

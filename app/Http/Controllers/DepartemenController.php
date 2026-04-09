<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::withCount('karyawan')->get();
        return view('departemen.index', compact('departemens'));
    }

    public function create()
    {
        return view('departemen.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:255|unique:departemens',
        ]);

        Departemen::create($validated);
        return redirect('departemen')->with('success', 'Departemen berhasil ditambahkan');
    }

    public function edit(Departemen $departemen)
    {
        return view('departemen.form', compact('departemen'));
    }

    public function update(Request $request, Departemen $departemen)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:255|unique:departemens,nama_departemen,' . $departemen->id,
        ]);

        $departemen->update($validated);
        return redirect('departemen')->with('success', 'Departemen berhasil diupdate');
    }

    public function destroy(Departemen $departemen)
    {
        if ($departemen->karyawan()->count() > 0) {
            return redirect('departemen')->with('error', 'Tidak bisa menghapus departemen yang masih memiliki karyawan');
        }

        $departemen->delete();
        return redirect('departemen')->with('success', 'Departemen berhasil dihapus');
    }
}

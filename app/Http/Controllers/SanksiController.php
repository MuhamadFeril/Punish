<?php

namespace App\Http\Controllers;

use App\Models\Sanksi;
use App\Models\Pelanggaran;
use App\Models\User;
use App\Notifications\SanksiNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SanksiController extends Controller
{
    public function index()
    {
        $sanksi = Sanksi::with('pelanggaran.karyawan')->paginate(15);
        return view('sanksi.index', compact('sanksi'));
    }

    public function create()
    {
        $pelanggarans = Pelanggaran::with(['karyawan', 'jenisPelanggaran'])->get();
        return view('sanksi.form', compact('pelanggarans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'jenis_sanksi' => 'required|string|max:255',
            'tanggal_sanksi' => 'required|date',
            'keterangan_sanksi' => 'nullable|string|max:2000',
            'status' => 'required|in:aktif,selesai',
        ]);

        $sanksi = Sanksi::create($validated);
        $sanksi->load('pelanggaran.karyawan');

        if ($sanksi->pelanggaran && $sanksi->pelanggaran->karyawan) {
            $user = User::where('email', $sanksi->pelanggaran->karyawan->email_karyawan)->first();
            if ($user) {
                $user->notify(new SanksiNotification($sanksi));
            }
        }

        return redirect()->route('sanksi.show', $sanksi->id)->with('success', 'Sanksi berhasil ditambahkan. Silakan download PDF untuk dikirim ke karyawan.');
    }

    public function show(Sanksi $sanksi)
    {
        $sanksi->load('pelanggaran.karyawan.departemen', 'pelanggaran.jenisPelanggaran');
        return view('sanksi.show', compact('sanksi'));
    }

    public function edit(Sanksi $sanksi)
    {
        $pelanggarans = Pelanggaran::with(['karyawan', 'jenisPelanggaran'])->get();
        return view('sanksi.form', compact('sanksi', 'pelanggarans'));
    }

    public function update(Request $request, Sanksi $sanksi)
    {
        $validated = $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'jenis_sanksi' => 'required|string|max:255',
            'tanggal_sanksi' => 'required|date',
            'keterangan_sanksi' => 'nullable|string|max:2000',
            'status' => 'required|in:aktif,selesai',
        ]);

        $sanksi->update($validated);

        return redirect()->route('sanksi.index')->with('success', 'Sanksi berhasil diperbarui.');
    }

    public function destroy(Sanksi $sanksi)
    {
        $sanksi->delete();

        return redirect()->route('sanksi.index')->with('success', 'Sanksi berhasil dihapus.');
    }

    public function downloadPdf(Sanksi $sanksi)
    {
        $sanksi->load(['pelanggaran.karyawan.departemen', 'pelanggaran.jenisPelanggaran', 'pelanggaran.sanksi']);
        $pelanggaran = $sanksi->pelanggaran;

        return Pdf::loadView('pdf.sanksi', [
            'sanksi' => $sanksi,
            'pelanggaran' => $pelanggaran,
        ])->setPaper('a4', 'landscape')->download('sanksi-' . $sanksi->id . '.pdf');
    }
}

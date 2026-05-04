<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PelanggaranNotification;
use App\Models\Pelanggaran;
use App\Models\Karyawan;
use App\Models\Jenispelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggaran::with('karyawan', 'jenisPelanggaran', 'reportedBy')
            ->latest();

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($builder) use ($search) {
                $builder->where('keterangan_pelanggaran', 'like', '%' . $search . '%')
                    ->orWhereHas('karyawan', function ($q) use ($search) {
                        $q->where('nama_karyawan', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('jenisPelanggaran', function ($q) use ($search) {
                        $q->where('nama_pelanggaran', 'like', '%' . $search . '%');
                    });
            });
        }

        $pelanggaran = $query->paginate(15);
        $notifications = $request->user()->notifications()->latest()->take(5)->get();
        $unreadNotificationCount = $request->user()->unreadNotifications()->count();

        return view('pelanggaran.index', compact('pelanggaran', 'notifications', 'unreadNotificationCount'));
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

        $validated['reported_by'] = Auth::id();
        $pelanggaran = Pelanggaran::create($validated);
        $pelanggaran->load('karyawan', 'jenisPelanggaran', 'reportedBy');

        $recipients = User::where('role', 'admin')->get()->keyBy('id');
        $recipients[Auth::id()] = $request->user();

        if ($pelanggaran->karyawan?->email_karyawan) {
            $violatorUser = User::where('email', $pelanggaran->karyawan->email_karyawan)->first();
            if ($violatorUser) {
                $recipients[$violatorUser->id] = $violatorUser;
            }
        }

        Notification::send($recipients->values(), new PelanggaranNotification($pelanggaran));

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
        if ($pelanggaran->bukti_pelanggaran && Storage::disk('public')->exists($pelanggaran->bukti_pelanggaran)) {
            Storage::disk('public')->delete($pelanggaran->bukti_pelanggaran);
        }

        $pelanggaran->delete();
        return redirect('pelanggaran')->with('success', 'Pelanggaran berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jenispelanggaran;
use App\Models\Karyawan;
use App\Models\Pelanggaran;
use App\Models\Sanksi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            if (Auth::user()->role === 'admin') {
                $data = [
                    'isAdmin' => true,
                    'totalKaryawan' => Karyawan::count(),
                    'totalDepartemen' => Departemen::count(),
                    'totalJenisPelanggaran' => Jenispelanggaran::count(),
                    'totalPelanggaran' => Pelanggaran::count(),
                    'totalSanksi' => Sanksi::count(),
                ];
            } else {
                $user = Auth::user();
                $karyawan = Karyawan::where('email_karyawan', $user->email)->first();

                $userPelanggaranCount = 0;
                $userSanksiCount = 0;
                $recentPelanggaran = collect();
                $notifications = $user->notifications()->latest()->take(5)->get();
                $unreadNotificationCount = $user->unreadNotifications()->count();

                if ($karyawan) {
                    $userPelanggaranCount = $karyawan->pelanggaran()->count();
                    $userSanksiCount = Sanksi::whereHas('pelanggaran', function ($query) use ($karyawan) {
                        $query->where('karyawan_id', $karyawan->id);
                    })->count();
                    $recentPelanggaran = $karyawan->pelanggaran()->with(['jenisPelanggaran', 'sanksi'])->latest()->take(5)->get();
                }

                $data = [
                    'isAdmin' => false,
                    'totalPelanggaran' => $userPelanggaranCount,
                    'totalSanksi' => $userSanksiCount,
                    'recentPelanggaran' => $recentPelanggaran,
                    'notifications' => $notifications,
                    'unreadNotificationCount' => $unreadNotificationCount,
                ];
            }

            return view('dashboard.index', $data);
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Gagal memuat dashboard');
        }
    }
}

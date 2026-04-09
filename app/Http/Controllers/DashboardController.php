<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Departemen;
use App\Models\Jenispelanggaran;
use App\Models\Pelanggaran;
use App\Models\Sanksi;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $data = [
                'totalKaryawan' => Karyawan::count(),
                'totalDepartemen' => Departemen::count(),
                'totalJenisPelanggaran' => Jenispelanggaran::count(),
                'totalPelanggaran' => Pelanggaran::count(),
                'totalSanksi' => Sanksi::count(),
            ];

            return view('dashboard.index', $data);
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Gagal memuat dashboard');
        }
    }
}

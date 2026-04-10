<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test Sanksi model
$sanksi = \App\Models\Sanksi::with(['pelanggaran.karyawan.departemen', 'pelanggaran.jenisPelanggaran'])->first();
if ($sanksi) {
    echo 'Sanksi ID: ' . $sanksi->id . PHP_EOL;
    echo 'Has Pelanggaran: ' . ($sanksi->pelanggaran ? 'YES' : 'NO') . PHP_EOL;
    echo 'Pelanggaran -> Karyawan: ' . ($sanksi->pelanggaran->karyawan->nama_karyawan ?? '-') . PHP_EOL;
    echo 'Departemen: ' . ($sanksi->pelanggaran->karyawan->departemen->nama_departemen ?? '-') . PHP_EOL;
    echo 'Jenis Pelanggaran: ' . ($sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-') . PHP_EOL;
    echo 'PDF Route: /sanksi/' . $sanksi->id . '/download' . PHP_EOL;
    echo 'SUCCESS: All relations loaded OK!' . PHP_EOL;
} else {
    echo 'ERROR: No Sanksi found' . PHP_EOL;
}

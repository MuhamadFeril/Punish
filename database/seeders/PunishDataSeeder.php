<?php

namespace Database\Seeders;

use App\Models\Departemen;
use App\Models\Jenispelanggaran;
use App\Models\Karyawan;
use App\Models\Pelanggaran;
use App\Models\Sanksi;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PunishDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@punish.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'otp_verified_at' => now(),
            ]
        );

        // Create regular user
        $user = User::updateOrCreate(
            ['email' => 'user@punish.com'],
            [
                'name' => 'User Regular',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // Create departments and capture instances
        $deptIT   = Departemen::create(['nama_departemen' => 'IT Development']);
        $deptHR   = Departemen::create(['nama_departemen' => 'Human Resources']);
        $deptFin  = Departemen::create(['nama_departemen' => 'Finance']);
        $deptMkt  = Departemen::create(['nama_departemen' => 'Marketing']);
        $deptOps  = Departemen::create(['nama_departemen' => 'Operations']);

        // Create violation types and capture instances
        $jenisLambat = Jenispelanggaran::create([
            'nama_pelanggaran'    => 'Terlambat Masuk Kerja',
            'tingkat_pelanggaran' => 'ringan',
            'deskripsi_pelanggaran' => 'Karyawan datang terlambat tanpa alasan yang sah',
        ]);
        $jenisAbsen = Jenispelanggaran::create([
            'nama_pelanggaran'    => 'Tidak Hadir Tanpa Keterangan',
            'tingkat_pelanggaran' => 'sedang',
            'deskripsi_pelanggaran' => 'Karyawan tidak hadir kerja tanpa memberikan keterangan yang sah',
        ]);
        $jenisFasilitas = Jenispelanggaran::create([
            'nama_pelanggaran'    => 'Penggunaan Fasilitas Perusahaan untuk Kepentingan Pribadi',
            'tingkat_pelanggaran' => 'sedang',
            'deskripsi_pelanggaran' => 'Menggunakan fasilitas kantor untuk kepentingan pribadi yang tidak terkait pekerjaan',
        ]);
        Jenispelanggaran::create([
            'nama_pelanggaran'    => 'Pelanggaran Kode Etik',
            'tingkat_pelanggaran' => 'berat',
            'deskripsi_pelanggaran' => 'Melanggar kode etik perusahaan yang telah ditetapkan',
        ]);
        Jenispelanggaran::create([
            'nama_pelanggaran'    => 'Pencurian Barang Perusahaan',
            'tingkat_pelanggaran' => 'berat',
            'deskripsi_pelanggaran' => 'Mengambil barang milik perusahaan tanpa izin',
        ]);

        // Create employees and capture instances
        $emp1 = Karyawan::create([
            'nama_karyawan'    => 'Ahmad Rahman',
            'email_karyawan'   => 'ahmad.rahman@company.com',
            'jabatan_karyawan' => 'Software Developer',
            'alamat_karyawan'  => 'Jl. Sudirman No. 123, Jakarta',
            'departemen_id'    => $deptIT->id,
            'status'           => 'aktif',
        ]);
        Karyawan::create([
            'nama_karyawan'    => 'Siti Nurhaliza',
            'email_karyawan'   => 'siti.nurhaliza@company.com',
            'jabatan_karyawan' => 'HR Manager',
            'alamat_karyawan'  => 'Jl. Thamrin No. 456, Jakarta',
            'departemen_id'    => $deptHR->id,
            'status'           => 'aktif',
        ]);
        $emp3 = Karyawan::create([
            'nama_karyawan'    => 'Budi Santoso',
            'email_karyawan'   => 'budi.santoso@company.com',
            'jabatan_karyawan' => 'Finance Analyst',
            'alamat_karyawan'  => 'Jl. Gatot Subroto No. 789, Jakarta',
            'departemen_id'    => $deptFin->id,
            'status'           => 'aktif',
        ]);
        $emp4 = Karyawan::create([
            'nama_karyawan'    => 'Maya Sari',
            'email_karyawan'   => 'maya.sari@company.com',
            'jabatan_karyawan' => 'Marketing Specialist',
            'alamat_karyawan'  => 'Jl. Sudirman No. 321, Jakarta',
            'departemen_id'    => $deptMkt->id,
            'status'           => 'aktif',
        ]);
        Karyawan::create([
            'nama_karyawan'    => 'Rudi Hartono',
            'email_karyawan'   => 'rudi.hartono@company.com',
            'jabatan_karyawan' => 'Operations Manager',
            'alamat_karyawan'  => 'Jl. MH Thamrin No. 654, Jakarta',
            'departemen_id'    => $deptOps->id,
            'status'           => 'aktif',
        ]);
        $emp6 = Karyawan::create([
            'nama_karyawan'    => 'Dewi Lestari',
            'email_karyawan'   => 'dewi.lestari@company.com',
            'jabatan_karyawan' => 'UI/UX Designer',
            'alamat_karyawan'  => 'Jl. Sudirman No. 987, Jakarta',
            'departemen_id'    => $deptIT->id,
            'status'           => 'aktif',
        ]);

        // Create violations and capture instances
        $pelanggaran1 = Pelanggaran::create([
            'karyawan_id'           => $emp1->id,
            'jenis_pelanggaran_id'  => $jenisLambat->id,
            'tanggal_pelanggaran'   => '2024-01-15',
            'keterangan_pelanggaran' => 'Datang terlambat 30 menit tanpa alasan yang sah pada tanggal 15 Januari 2024',
            'bukti_pelanggaran'     => null,
            'reported_by'           => $admin->id,
            'status'                => 'aktif',
        ]);
        $pelanggaran2 = Pelanggaran::create([
            'karyawan_id'           => $emp3->id,
            'jenis_pelanggaran_id'  => $jenisAbsen->id,
            'tanggal_pelanggaran'   => '2024-01-20',
            'keterangan_pelanggaran' => 'Tidak hadir kerja selama 2 hari tanpa memberikan keterangan yang sah',
            'bukti_pelanggaran'     => null,
            'reported_by'           => $admin->id,
            'status'                => 'aktif',
        ]);
        $pelanggaran3 = Pelanggaran::create([
            'karyawan_id'           => $emp4->id,
            'jenis_pelanggaran_id'  => $jenisFasilitas->id,
            'tanggal_pelanggaran'   => '2024-02-01',
            'keterangan_pelanggaran' => 'Menggunakan komputer kantor untuk bermain game selama jam kerja',
            'bukti_pelanggaran'     => null,
            'reported_by'           => $admin->id,
            'status'                => 'aktif',
        ]);
        Pelanggaran::create([
            'karyawan_id'           => $emp6->id,
            'jenis_pelanggaran_id'  => $jenisLambat->id,
            'tanggal_pelanggaran'   => '2024-02-10',
            'keterangan_pelanggaran' => 'Datang terlambat 45 menit karena macet lalu lintas',
            'bukti_pelanggaran'     => null,
            'reported_by'           => $user->id,
            'status'                => 'aktif',
        ]);

        // Create sanctions using captured violation UUIDs
        Sanksi::create([
            'pelanggaran_id'  => $pelanggaran1->id,
            'jenis_sanksi'    => 'peringatan',
            'tanggal_sanksi'  => '2024-01-16',
            'keterangan_sanksi' => 'Peringatan tertulis pertama karena terlambat masuk kerja. Karyawan diharapkan lebih disiplin dalam hal waktu kedatangan.',
        ]);
        Sanksi::create([
            'pelanggaran_id'  => $pelanggaran2->id,
            'jenis_sanksi'    => 'skorsing',
            'tanggal_sanksi'  => '2024-01-22',
            'keterangan_sanksi' => 'Skorsing selama 3 hari kerja karena tidak hadir tanpa keterangan. Potongan gaji sebesar 30% dari gaji pokok.',
        ]);
        Sanksi::create([
            'pelanggaran_id'  => $pelanggaran3->id,
            'jenis_sanksi'    => 'peringatan',
            'tanggal_sanksi'  => '2024-02-02',
            'keterangan_sanksi' => 'Peringatan lisan karena penggunaan fasilitas perusahaan untuk kepentingan pribadi. Karyawan diingatkan untuk menggunakan fasilitas sesuai dengan ketentuan perusahaan.',
        ]);

        $this->command->info('✅ Data dummy berhasil dibuat!');
        $this->command->info('📧 Admin login: admin@punish.com / password');
        $this->command->info('📧 User login: user@punish.com / password');
        $this->command->info('📊 Data yang dibuat:');
        $this->command->info('   - 2 Users (1 admin, 1 user)');
        $this->command->info('   - 5 Departemen');
        $this->command->info('   - 5 Jenis Pelanggaran');
        $this->command->info('   - 6 Karyawan');
        $this->command->info('   - 4 Pelanggaran');
        $this->command->info('   - 3 Sanksi');
    }
}

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
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@punish.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create regular user
        $user = User::create([
            'name' => 'User Regular',
            'email' => 'user@punish.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create departments
        $departments = [
            ['nama_departemen' => 'IT Development'],
            ['nama_departemen' => 'Human Resources'],
            ['nama_departemen' => 'Finance'],
            ['nama_departemen' => 'Marketing'],
            ['nama_departemen' => 'Operations'],
        ];

        foreach ($departments as $dept) {
            Departemen::create($dept);
        }

        // Create violation types
        $violationTypes = [
            [
                'nama_pelanggaran' => 'Terlambat Masuk Kerja',
                'tingkat_pelanggaran' => 'ringan',
                'deskripsi_pelanggaran' => 'Karyawan datang terlambat tanpa alasan yang sah',
            ],
            [
                'nama_pelanggaran' => 'Tidak Hadir Tanpa Keterangan',
                'tingkat_pelanggaran' => 'sedang',
                'deskripsi_pelanggaran' => 'Karyawan tidak hadir kerja tanpa memberikan keterangan yang sah',
            ],
            [
                'nama_pelanggaran' => 'Penggunaan Fasilitas Perusahaan untuk Kepentingan Pribadi',
                'tingkat_pelanggaran' => 'sedang',
                'deskripsi_pelanggaran' => 'Menggunakan fasilitas kantor untuk kepentingan pribadi yang tidak terkait pekerjaan',
            ],
            [
                'nama_pelanggaran' => 'Pelanggaran Kode Etik',
                'tingkat_pelanggaran' => 'berat',
                'deskripsi_pelanggaran' => 'Melanggar kode etik perusahaan yang telah ditetapkan',
            ],
            [
                'nama_pelanggaran' => 'Pencurian Barang Perusahaan',
                'tingkat_pelanggaran' => 'berat',
                'deskripsi_pelanggaran' => 'Mengambil barang milik perusahaan tanpa izin',
            ],
        ];

        foreach ($violationTypes as $type) {
            Jenispelanggaran::create($type);
        }

        // Create employees
        $employees = [
            [
                'nama_karyawan' => 'Ahmad Rahman',
                'email_karyawan' => 'ahmad.rahman@company.com',
                'jabatan_karyawan' => 'Software Developer',
                'alamat_karyawan' => 'Jl. Sudirman No. 123, Jakarta',
                'departemen_id' => 1,
                'status' => 'aktif'
            ],
            [
                'nama_karyawan' => 'Siti Nurhaliza',
                'email_karyawan' => 'siti.nurhaliza@company.com',
                'jabatan_karyawan' => 'HR Manager',
                'alamat_karyawan' => 'Jl. Thamrin No. 456, Jakarta',
                'departemen_id' => 2,
                'status' => 'aktif'
            ],
            [
                'nama_karyawan' => 'Budi Santoso',
                'email_karyawan' => 'budi.santoso@company.com',
                'jabatan_karyawan' => 'Finance Analyst',
                'alamat_karyawan' => 'Jl. Gatot Subroto No. 789, Jakarta',
                'departemen_id' => 3,
                'status' => 'aktif'
            ],
            [
                'nama_karyawan' => 'Maya Sari',
                'email_karyawan' => 'maya.sari@company.com',
                'jabatan_karyawan' => 'Marketing Specialist',
                'alamat_karyawan' => 'Jl. Sudirman No. 321, Jakarta',
                'departemen_id' => 4,
                'status' => 'aktif'
            ],
            [
                'nama_karyawan' => 'Rudi Hartono',
                'email_karyawan' => 'rudi.hartono@company.com',
                'jabatan_karyawan' => 'Operations Manager',
                'alamat_karyawan' => 'Jl. MH Thamrin No. 654, Jakarta',
                'departemen_id' => 5,
                'status' => 'aktif'
            ],
            [
                'nama_karyawan' => 'Dewi Lestari',
                'email_karyawan' => 'dewi.lestari@company.com',
                'jabatan_karyawan' => 'UI/UX Designer',
                'alamat_karyawan' => 'Jl. Sudirman No. 987, Jakarta',
                'departemen_id' => 1,
                'status' => 'aktif'
            ],
        ];

        foreach ($employees as $emp) {
            Karyawan::create($emp);
        }

        // Create violations
        $violations = [
            [
                'karyawan_id' => 1,
                'jenis_pelanggaran_id' => 1,
                'tanggal_pelanggaran' => '2024-01-15',
                'keterangan_pelanggaran' => 'Datang terlambat 30 menit tanpa alasan yang sah pada tanggal 15 Januari 2024',
                'bukti_pelanggaran' => null,
                'reported_by' => $admin->id,
                'status' => 'aktif'
            ],
            [
                'karyawan_id' => 3,
                'jenis_pelanggaran_id' => 2,
                'tanggal_pelanggaran' => '2024-01-20',
                'keterangan_pelanggaran' => 'Tidak hadir kerja selama 2 hari tanpa memberikan keterangan yang sah',
                'bukti_pelanggaran' => null,
                'reported_by' => $admin->id,
                'status' => 'aktif'
            ],
            [
                'karyawan_id' => 4,
                'jenis_pelanggaran_id' => 3,
                'tanggal_pelanggaran' => '2024-02-01',
                'keterangan_pelanggaran' => 'Menggunakan komputer kantor untuk bermain game selama jam kerja',
                'bukti_pelanggaran' => null,
                'reported_by' => $admin->id,
                'status' => 'aktif'
            ],
            [
                'karyawan_id' => 6,
                'jenis_pelanggaran_id' => 1,
                'tanggal_pelanggaran' => '2024-02-10',
                'keterangan_pelanggaran' => 'Datang terlambat 45 menit karena macet lalu lintas',
                'bukti_pelanggaran' => null,
                'reported_by' => $user->id,
                'status' => 'aktif'
            ],
        ];

        foreach ($violations as $violation) {
            Pelanggaran::create($violation);
        }

        // Create sanctions for some violations
        $sanctions = [
            [
                'pelanggaran_id' => 1,
                'jenis_sanksi' => 'peringatan',
                'tanggal_sanksi' => '2024-01-16',
                'keterangan_sanksi' => 'Peringatan tertulis pertama karena terlambat masuk kerja. Karyawan diharapkan lebih disiplin dalam hal waktu kedatangan.',
            ],
            [
                'pelanggaran_id' => 2,
                'jenis_sanksi' => 'skorsing',
                'tanggal_sanksi' => '2024-01-22',
                'keterangan_sanksi' => 'Skorsing selama 3 hari kerja karena tidak hadir tanpa keterangan. Potongan gaji sebesar 30% dari gaji pokok.',
            ],
            [
                'pelanggaran_id' => 3,
                'jenis_sanksi' => 'peringatan',
                'tanggal_sanksi' => '2024-02-02',
                'keterangan_sanksi' => 'Peringatan lisan karena penggunaan fasilitas perusahaan untuk kepentingan pribadi. Karyawan diingatkan untuk menggunakan fasilitas sesuai dengan ketentuan perusahaan.',
            ],
        ];

        foreach ($sanctions as $sanction) {
            Sanksi::create($sanction);
        }

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

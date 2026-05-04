<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Karyawan;
use App\Models\JenisPelanggaran;
use App\Models\User;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran';

    protected $fillable = [
        'karyawan_id',
        'jenis_pelanggaran_id',
        'tanggal_pelanggaran',
        'keterangan_pelanggaran',
        'bukti_pelanggaran',
        'reported_by',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class, 'jenis_pelanggaran_id');
    }

    public function sanksi()
    {
        return $this->hasMany(Sanksi::class, 'pelanggaran_id');
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}

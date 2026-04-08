<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departemen;
use App\Models\Pelanggaran;
class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'nama_karyawan',
        'alamat_karyawan',
        'departemen_id',
        'email_karyawan',
        'jabatan_karyawan',
        'foto_karyawan',
        'status',
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id');
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'karyawan_id');
    }
}
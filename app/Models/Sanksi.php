<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanksi extends Model
{
    use HasFactory;

    protected $table = 'sanksi';

    protected $fillable = [
        'pelanggaran_id',
        'jenis_sanksi',
        'tanggal_sanksi',
        'keterangan_sanksi',
        'status',
    ];

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id');
    }
}
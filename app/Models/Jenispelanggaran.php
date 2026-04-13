<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
class Jenispelanggaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelanggaran';

    protected $fillable = [
        'nama_pelanggaran',
        'deskripsi_pelanggaran',
        'tingkat_pelanggaran',
    ];

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'jenis_pelanggaran_id');
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
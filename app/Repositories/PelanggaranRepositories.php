<?php

namespace App\Repositories;

use App\Interface\PelanggaranInterface;
use App\Models\Pelanggaran;

class PelanggaranRepositories implements PelanggaranInterface
{
    public function all()
    {
        return Pelanggaran::with(['karyawan', 'jenisPelanggaran', 'sanksi'])->get();
    }

    public function find($id)
    {
        return Pelanggaran::with(['karyawan', 'jenisPelanggaran', 'sanksi'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Pelanggaran::create($data);
    }

    public function update($id, array $data)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->update($data);
        return $pelanggaran;
    }

    public function delete($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->delete();
        return true;
    }
}
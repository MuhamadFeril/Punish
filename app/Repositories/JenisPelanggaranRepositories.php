<?php

namespace App\Repositories;

use App\Interface\JenisPelanggaranInterface;
use App\Models\Jenispelanggaran;

class JenisPelanggaranRepositories implements JenisPelanggaranInterface
{
    public function all()
    {
        return Jenispelanggaran::all();
    }

    public function find($id)
    {
        return Jenispelanggaran::findOrFail($id);
    }

    public function create(array $data)
    {
        return Jenispelanggaran::create($data);
    }

    public function update($id, array $data)
    {
        $jenisPelanggaran = Jenispelanggaran::findOrFail($id);
        $jenisPelanggaran->update($data);
        return $jenisPelanggaran;
    }

    public function delete($id)
    {
        $jenisPelanggaran = Jenispelanggaran::findOrFail($id);
        $jenisPelanggaran->delete();
        return true;
    }
}
<?php

namespace App\Handlers;

use App\Repositories\KaryawanRepositories;
use Illuminate\Support\Facades\Storage;

class KaryawanHandler
{
    protected $karyawanRepo;

    public function __construct(KaryawanRepositories $karyawanRepo)
    {
        $this->karyawanRepo = $karyawanRepo;
    }

    public function all()
    {
        return $this->karyawanRepo->all();
    }

    public function find($id)
    {
        return $this->karyawanRepo->find($id);
    }

    public function create(array $data)
    {
        // Handle file upload jika ada
        if (isset($data['foto_karyawan']) && $data['foto_karyawan']) {
            $file = $data['foto_karyawan'];
            $path = $file->store('karyawan', 'public');
            $data['foto_karyawan'] = $path;
        }
        return $this->karyawanRepo->create($data);
    }

    public function update($id, array $data)
    {
        // Handle file upload jika ada
        if (isset($data['foto_karyawan']) && $data['foto_karyawan']) {
            $file = $data['foto_karyawan'];
            $path = $file->store('karyawan', 'public');
            $data['foto_karyawan'] = $path;
        }
        return $this->karyawanRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->karyawanRepo->delete($id);
    }
}
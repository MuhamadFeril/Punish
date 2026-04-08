<?php

namespace App\Handlers;

use App\Repositories\PelanggaranRepositories;
use Illuminate\Support\Facades\Storage;

class PelanggaranHandler
{
    protected $pelanggaranRepo;

    public function __construct(PelanggaranRepositories $pelanggaranRepo)
    {
        $this->pelanggaranRepo = $pelanggaranRepo;
    }

    public function all()
    {
        return $this->pelanggaranRepo->all();
    }

    public function find($id)
    {
        return $this->pelanggaranRepo->find($id);
    }

    public function create(array $data)
    {
        // Handle file upload jika ada
        if (isset($data['bukti_pelanggaran']) && $data['bukti_pelanggaran']) {
            $file = $data['bukti_pelanggaran'];
            $path = $file->store('pelanggaran', 'public');
            $data['bukti_pelanggaran'] = $path;
        }
        return $this->pelanggaranRepo->create($data);
    }

    public function update($id, array $data)
    {
        // Handle file upload jika ada
        if (isset($data['bukti_pelanggaran']) && $data['bukti_pelanggaran']) {
            $file = $data['bukti_pelanggaran'];
            $path = $file->store('pelanggaran', 'public');
            $data['bukti_pelanggaran'] = $path;
        }
        return $this->pelanggaranRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->pelanggaranRepo->delete($id);
    }
}
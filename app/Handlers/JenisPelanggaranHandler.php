<?php

namespace App\Handlers;


use App\Repositories\JenisPelanggaranRepositories;

class JenisPelanggaranHandler
{
    protected $pelanggaranRepo;

    public function __construct(JenisPelanggaranRepositories $pelanggaranRepo)
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
        return $this->pelanggaranRepo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->pelanggaranRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->pelanggaranRepo->delete($id);
    }
}
<?php

namespace App\Repositories;

use App\Interface\KaryawanInterface;
use App\Models\Karyawan;
class KaryawanRepositories implements KaryawanInterface
{
    protected $model;
    public function __construct(Karyawan $model){
        $this->model = $model;
    }
    public function all()
    {
        return $this->model->query();
    }

    public function find($id)
    {
        return Karyawan::findOrFail($id);
    }

    public function create(array $data)
    {
        return Karyawan::create($data);
    }

    public function update($id, array $data)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($data);
        return $karyawan;
    }

    public function delete($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();
        return true;
    }
}
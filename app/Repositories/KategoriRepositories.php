<?php

namespace App\Repositories;

use App\Interface\KategoriInterface;
use App\Models\Kategori;

class KategoriRepositories implements KategoriInterface
{
    protected $model;
    public function __construct(Kategori $model){
        $this->model = $model;
    }
    public function all()
    {
        return $this->model->query();
    }

    public function find($id)
    {
        return Kategori::findOrFail($id);
    }

    public function create(array $data)
    {
        return Kategori::create($data);
    }

    public function update($id, array $data)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->update($data);
        return $kategori;
    }

    public function delete($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return true;
    }

    public function trashed()
    {
        return Kategori::onlyTrashed();
    }

    public function restore($id)
    {
        $kategori = Kategori::withTrashed()->findOrFail($id);
        if ($kategori->trashed()) {
            $kategori->restore();
        }
        return $kategori;
    }

    public function forceDelete($id)
    {
        $kategori = Kategori::withTrashed()->findOrFail($id);
        $kategori->forceDelete();
        return true;
    }
}
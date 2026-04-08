<?php
namespace App\Repositories;
use App\Interface\DepartemenInterface;
use App\Models\Departemen;

class DepartemenRepositories implements DepartemenInterface
{
    public function all()
    {
        return Departemen::all();
    }

    public function find($id)
    {
        return Departemen::findOrFail($id);
    }   
    public function create(array $data)
    {
        return Departemen::create($data);
    }
    public function update($id, array $data)
    {
        $departemen = Departemen::findOrFail($id);
        $departemen->update($data);
        return $departemen;
    }
    public function delete($id)
    {
        $departemen = Departemen::findOrFail($id);
        $departemen->delete();
        return true;
    }
}

<?php

namespace App\Handlers;

use App\Repositories\KategoriRepositories;

class KategoriHandler
{
    protected $kategoriRepostory;  
    public function __construct(KategoriRepositories $kategoriRepostory)
    {
        $this->kategoriRepostory = $kategoriRepostory;
    }
    public function all()
    {
        return $this->kategoriRepostory->all();
    }
    public function find($id)
    {
        return $this->kategoriRepostory->find($id);
    }   
    public function create(array $data)
    {
        return $this->kategoriRepostory->create($data);
    }
    public function update($id, array $data)
    {
        return $this->kategoriRepostory->update($id, $data);
    }
    public function delete($id)
    {
        return $this->kategoriRepostory->delete($id);
    }
}
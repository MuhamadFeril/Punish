<?php

namespace App\Handlers;

use App\Repositories\DepartemenRepositories;
class DepartemenHandler
{
    protected $departemenRepo;

    public function __construct(DepartemenRepositories $departemenRepo)
    {
        $this->departemenRepo = $departemenRepo;
    }

    public function all()
    {
        return $this->departemenRepo->all();
    }

    public function find($id)
    {
        return $this->departemenRepo->find($id);
    }

    public function create(array $data)
    {
        return $this->departemenRepo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->departemenRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->departemenRepo->delete($id);
    }
}
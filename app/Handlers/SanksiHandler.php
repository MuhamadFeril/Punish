<?php

namespace App\Handlers;

use App\Repositories\SanksiRepositories;

class SanksiHandler
{
    protected $sanksiRepo;

    public function __construct(SanksiRepositories $sanksiRepo)
    {
        $this->sanksiRepo = $sanksiRepo;
    }

    public function all()
    {
        return $this->sanksiRepo->all();
    }

    public function find($id)
    {
        return $this->sanksiRepo->find($id);
    }

    public function create(array $data)
    {
        return $this->sanksiRepo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->sanksiRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->sanksiRepo->delete($id);
    }
}
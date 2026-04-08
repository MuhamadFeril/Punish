<?php

namespace App\Repositories;

use App\Interface\SanksiInterface;
use App\Models\Sanksi;

class SanksiRepositories implements SanksiInterface
{
    public function all()
    {
        return Sanksi::with('pelanggaran')->get();
    }

    public function find($id)
    {
        return Sanksi::with('pelanggaran')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Sanksi::create($data);
    }

    public function update($id, array $data)
    {
        $sanksi = Sanksi::findOrFail($id);
        $sanksi->update($data);
        return $sanksi;
    }

    public function delete($id)
    {
        $sanksi = Sanksi::findOrFail($id);
        $sanksi->delete();
        return true;
    }
}
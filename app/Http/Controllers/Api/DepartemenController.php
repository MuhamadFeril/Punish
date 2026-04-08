<?php

namespace App\Http\Controllers\Api;

use App\Handlers\DepartemenHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Resources\DepartemenResource;
use App\Http\Requests\DepartemenRequest;
use App\Helpers\ResponsHelper;
use Illuminate\Support\Facades\Log;
use App\Jobs\Divisi;
use App\Models\Departemen;
use App\Helpers\SearchHelper;


class DepartemenController extends Controller
{
    protected $departemenHandler;

    public function __construct(DepartemenHandler $departemenHandler)
    {
        $this->departemenHandler = $departemenHandler;
    }

    public function index(Request $request)
    {
       try {
            return SearchHelper::search($request, Departemen::class, ['nama_departemen'], [], DepartemenResource::class);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data departemen: ' . $e->getMessage());                 

            return ResponsHelper::error('Gagal mengambil data departemen', 500);
        }
    }

    public function show($id)
    { 
        try {
            $departemen = $this->departemenHandler->find($id);
            if (!$departemen) {
                return ResponsHelper::error('Departemen Tidak Ditemukan', 404);
            }
            return ResponsHelper::success(new DepartemenResource($departemen));
        } catch (\Exception $e) {
            return ResponsHelper::error('Gagal mengambil data departemen', 500);
        }
    }
    public function store(DepartemenRequest $request)
    { 
       try {
            $data = $request->validated();
            $departemen = $this->departemenHandler->create($data);
            Divisi::dispatch($departemen->id);
             return ResponsHelper::success(new DepartemenResource($departemen), 'Departemen created successfully');
        } catch (\Exception $e) {
            return ResponsHelper::error('Gagal membuat departemen', 500);
        }
    }
    public function update(DepartemenRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $departemen = $this->departemenHandler->update($id, $data);
            if (!$departemen) {
                return ResponsHelper::error('Departemen Tidak Ditemukan', 404);
            }
            return ResponsHelper::success(new DepartemenResource($departemen), 'Departemen updated successfully');
        } catch (\Exception $e) {
            return ResponsHelper::error('Gagal mengupdate departemen', 500);
        }   
    }
    public function destroy($id)
    {
        try {
            $deleted = $this->departemenHandler->delete($id);
            if (!$deleted) {
                return ResponsHelper::error('Departemen Tidak Ditemukan', 404);
            }
            return ResponsHelper::success(null, 'Departemen berhasil dihapus');
        } catch (\Exception $e) {
            return ResponsHelper::error('Gagal menghapus departemen', 500);
        }
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Handlers\KaryawanHandler;
use App\Resources\KaryawanResource;
use App\Http\Requests\KaryawanRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Helpers\ResponsHelper;
use Illuminate\Support\Facades\Log;
use App\Jobs\KaryawanJob;
use App\Helpers\SearchHelper;
use App\Models\Karyawan;
use App\Repositories\KaryawanRepositories;

class KaryawanController extends Controller
{
    protected $karyawanHandler,
              $repo;

    public function __construct(KaryawanHandler $karyawanHandler, KaryawanRepositories $repo)
    {
        $this->karyawanHandler = $karyawanHandler;
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        try {
           $perPage = (int) $request->query('per_page', 3);
           if ($perPage < 1) $perPage = 1;
           $perPage = min(5, $perPage);  // cap per_page to 5
           $data = $this->repo->all()->paginate($perPage)->appends($request->query());
           return $data;
        } catch (\Exception $e) {
            return ResponsHelper::error('Gagal mengambil data karyawan', 500);
        }
    }

    public function store(KaryawanRequest $request)
    {
        try {
            $data = $request->validated();
            $karyawan = $this->karyawanHandler->create($data);
            KaryawanJob::dispatch($karyawan->id);
            return ResponsHelper::success(new KaryawanResource($karyawan), 'Karyawan created successfully');
        } catch (\Exception $e) {
            Log::error('Gagal membuat karyawan: ' . $e->getMessage());
            return ResponsHelper::error('Gagal membuat karyawan: ' . $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $karyawan = $this->karyawanHandler->find($id);
            if (!$karyawan) {
                return ResponsHelper::error('Karyawan not found', 404);
            }
            return ResponsHelper::success(new KaryawanResource($karyawan));
        } catch (\Exception $e) {
            return ResponsHelper::error('Gagal mengambil data karyawan', 500);
        }   
    }

    public function update(KaryawanRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $karyawan = $this->karyawanHandler->update($id, $data);
            if (!$karyawan) {
                return ResponsHelper::error('Karyawan not found', 404);
            }
            return ResponsHelper::success(new KaryawanResource($karyawan), 'Karyawan updated successfully');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui karyawan: ' . $e->getMessage());
            return ResponsHelper::error('Gagal memperbarui karyawan: ' . $e->getMessage(), 500);
        }
            
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->karyawanHandler->delete($id);
            if (!$deleted) {
                return ResponsHelper::error('Karyawan not found', 404);
            }
            return ResponsHelper::success(null, 'Karyawan deleted successfully');
        } catch (\Exception $e) {
            return ResponsHelper::error('Gagal menghapus karyawan', 500);
        }
    }
}
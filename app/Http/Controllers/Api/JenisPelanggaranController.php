<?php

namespace App\Http\Controllers\Api;

use App\Handlers\JenisPelanggaranHandler;
use App\Helpers\ResponsHelper;
use App\Http\Controllers\Controller;
use App\Resources\JenisPelanggaranResource;
use App\Http\Requests\JenisPelanggaranRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Jobs\JenisPelanggaranJob;
use App\Helpers\SearchHelper;
use App\Models\JenisPelanggaran;
use Illuminate\Http\Request;

class JenisPelanggaranController extends Controller
{
    protected $jenisPelanggaranHandler;

    public function __construct(JenisPelanggaranHandler $jenisPelanggaranHandler)
    {
        $this->jenisPelanggaranHandler = $jenisPelanggaranHandler;
    }

    public function index(Request $request)
    {
        try {
            return SearchHelper::search($request, JenisPelanggaran::class, ['nama_pelanggaran', 'deskripsi_pelanggaran'], [], JenisPelanggaranResource::class);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data jenis pelanggaran: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return ResponsHelper::error('Gagal mengambil data jenis pelanggaran', 500);
        }
    }

    public function show($id)
    {
        try {
            $jenisPelanggaran = $this->jenisPelanggaranHandler->find($id);
            if (!$jenisPelanggaran) {
                throw new ModelNotFoundException();
            }
            return new JenisPelanggaranResource($jenisPelanggaran);
        } catch (ModelNotFoundException $e) {
                return ResponsHelper::error('Jenis Pelanggaran not found', 404);
        }
    }
    public function store(JenisPelanggaranRequest  $request)
    { 
        try {
            $data = $request->validated();
            if ($request->filled('deskripsi') && empty($data['deskripsi_pelanggaran'])) {
              
                $data['deskripsi_pelanggaran'] = $request->input('deskripsi');
            }
            $jenisPelanggaran = $this->jenisPelanggaranHandler->create($data);
            JenisPelanggaranJob::dispatch($jenisPelanggaran->getKey());
            return new JenisPelanggaranResource($jenisPelanggaran);
        } catch (\Exception $e) {
            Log::error('Gagal membuat jenis pelanggaran: ' . $e->getMessage());
            return ResponsHelper::error('Gagal membuat jenis pelanggaran: ' . $e->getMessage(), 500);
        }
    }
    public function update(JenisPelanggaranRequest $request, $id)
    {
        try {
            $data = $request->validated();
            // accept `deskripsi` as an alias for updates as well
            if ($request->filled('deskripsi') && empty($data['deskripsi_pelanggaran'])) {
                $data['deskripsi_pelanggaran'] = $request->input('deskripsi');
            }
            $jenisPelanggaran = $this->jenisPelanggaranHandler->update($id, $data);
            if (!$jenisPelanggaran) {
return ResponsHelper::error('Jenis Pelanggaran not found', 404);
            }
            return new JenisPelanggaranResource($jenisPelanggaran);
        } catch (\Exception $e) {
            return ResponsHelper::error('Gagal mengupdate jenis pelanggaran', 500);
        }
    }
    public function destroy($id)
    {
        try {
            $deleted = $this->jenisPelanggaranHandler->delete($id);
            if (!$deleted) {
                return ResponsHelper::error('Jenis Pelanggaran not found', 404);
            }
            return ResponsHelper::success(null, 'Jenis Pelanggaran deleted successfully');
        } catch (\Exception $e) {
            return ResponsHelper::error('Gagal menghapus jenis pelanggaran', 500);
        }
    }
}
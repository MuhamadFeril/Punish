<?php 

namespace App\Http\Controllers\Api;

use App\Handlers\PelanggaranHandler;
use App\Helpers\ResponsHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Resources\PelanggaranResource;
use App\Http\Requests\PelanggaranRequest;
use Illuminate\Support\Facades\Log;
use App\Jobs\PelanggaranJob;
use App\Helpers\SearchHelper;
use App\Models\Pelanggaran;

class PelanggaranController extends Controller
{
    protected $pelanggaranHandler;

    public function __construct(PelanggaranHandler $pelanggaranHandler)
    {
        $this->pelanggaranHandler = $pelanggaranHandler;
    }

    public function index(Request $request)
    {
        try {
            return SearchHelper::search($request, Pelanggaran::class, ['keterangan_pelanggaran', 'bukti_pelanggaran'], ['karyawan', 'jenisPelanggaran', 'sanksi'], PelanggaranResource::class);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data pelanggaran: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return ResponsHelper::error('Gagal mengambil data pelanggaran', 500);            
        }
    }

    public function show($id)
    {
        try {
            $pelanggaran = $this->pelanggaranHandler->find($id);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data pelanggaran: ' . $e->getMessage());
            return ResponsHelper::error('Gagal mengambil data pelanggaran', 500);
        }
        if (!$pelanggaran) {
                return ResponsHelper::error('Pelanggaran not found', 404);
        }
        return new PelanggaranResource($pelanggaran);
    }
    public function store(PelanggaranRequest $request)
    { 
        try {
            $data = $request->validated();
            $pelanggaran = $this->pelanggaranHandler->create($data);
                PelanggaranJob::dispatch($pelanggaran->id);
            return new PelanggaranResource($pelanggaran);
        } catch (\Exception $e) {
            Log::error('Gagal membuat pelanggaran: ' . $e->getMessage());
            return ResponsHelper::error('Gagal membuat pelanggaran: ' . $e->getMessage(), 500);
        }

    }
    public function update(PelanggaranRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $pelanggaran = $this->pelanggaranHandler->update($id, $data);
            if (!$pelanggaran) {
                return ResponsHelper::error('Pelanggaran not found', 404);
            }
            return new PelanggaranResource($pelanggaran);
        } catch (\Exception $e) {
            Log::error('Gagal mengupdate pelanggaran: ' . $e->getMessage());
            return ResponsHelper::error('Gagal mengupdate pelanggaran: ' . $e->getMessage(), 500);
        }
    }
    public function destroy($id)
    {
        try {
            $deleted = $this->pelanggaranHandler->delete($id);
            if (!$deleted) {
                return ResponsHelper::error('Pelanggaran not found', 404);
            }
            return ResponsHelper::success(null, 'Pelanggaran deleted successfully');
        } catch (\Exception $e) {
            return ResponsHelper::error('Gagal menghapus pelanggaran', 500);
        }
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Handlers\SanksiHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Resources\SanksiResource;
use App\Http\Requests\SanksiRequest;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sanksi;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Jobs\ProcessSanksi;
use Symfony\Component\Process\Process;
use App\Helpers\SearchHelper;

class SanksiController extends Controller
{
    protected $sanksiHandler;

    public function __construct(SanksiHandler $sanksiHandler)
    {
        $this->sanksiHandler = $sanksiHandler;
    }

    public function index(Request $request)
    {
        try {
            return SearchHelper::search($request, Sanksi::class, [], ['pelanggaran.karyawan', 'pelanggaran.jenisPelanggaran'], SanksiResource::class);
        } catch (\Exception $e) {
            Log::error('Error fetching sanksi: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil data sanksi: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $sanksi = $this->sanksiHandler->find($id);
        } catch (\Exception $e) {
            Log::error('Error fetching sanksi: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil data sanksi: ' . $e->getMessage()], 500);
        }
        if (!$sanksi) {
            return response()->json(['message' => 'Sanksi not found'], 404);
        }
        return new SanksiResource($sanksi);
    }
    public function store(SanksiRequest $request)
    { 
        try {
            $data = $request->validated();
            $sanksi = $this->sanksiHandler->create($data);
            ProcessSanksi::dispatch($sanksi->id);
            return new SanksiResource($sanksi);
        } catch (\Exception $e) {
            Log::error('Error creating sanksi: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menambahkan sanksi: ' . $e->getMessage()], 500);
        }
    }
    public function update(SanksiRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $sanksi = $this->sanksiHandler->update($id, $data);
            if (!$sanksi) {
                return response()->json(['message' => 'Sanksi not found'], 404);
            }
            return new SanksiResource($sanksi);
        } catch (\Exception $e) {
            Log::error('Error updating sanksi: ' . $e->getMessage());

            return response()->json(['message' => 'Gagal mengupdate sanksi'], 500);
        }
    }
    public function destroy($id)
    {
        
        try {
            $deleted = $this->sanksiHandler->delete($id);
            if (!$deleted) {
                return response()->json(['message' => 'Sanksi not found'], 404);
            }
            return response()->json(['message' => 'Sanksi deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting sanksi: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menghapus sanksi'], 500);
        }
    }

    public function exportPdf()
    {
        try {
            // eager-load nested relations so the view can read karyawan, departemen, jenisPelanggaran and sanksi
            $sanksis = Sanksi::with([
                'pelanggaran.karyawan.departemen',
                'pelanggaran.jenisPelanggaran',
                'pelanggaran.sanksi'
            ])->get();

            if ($sanksis->isEmpty()) {
                return response()->json(['message' => 'Tidak ada data sanksi untuk diekspor'], 404);
            }

            // For the current template which renders a single letter, pass the first
            // pelanggaran related to the first sanksi as `pelanggaran` so the view
            // variable expected in the blade exists.
            $firstSanksi = $sanksis->first();

            if (!$firstSanksi || !$firstSanksi->pelanggaran) {
                Log::warning('Export PDF: first sanksi or related pelanggaran missing');
                return response()->json(['message' => 'Data pelanggaran terkait tidak ditemukan untuk ekspor'], 404);
            }

            $pelanggaran = $firstSanksi->pelanggaran;

            $pdf = Pdf::loadView('pdf.sanksi', [
                'sanksi' => $firstSanksi,
                'pelanggaran' => $pelanggaran,
            ])->setPaper('a4', 'landscape');

            return $pdf->download('sanksi-' . $firstSanksi->id . '.pdf');
        } catch (ModelNotFoundException $e) {
            Log::error('Model not found when exporting sanksi PDF: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil data sanksi: data tidak ditemukan'], 404);
        } catch (\Exception $e) {
            Log::error('Error exporting sanksi PDF: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengekspor sanksi: ' . $e->getMessage()], 500);
        }
    }
}

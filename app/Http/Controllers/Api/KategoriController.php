<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Resources\KategoriResource;
use App\Handlers\KategoriHandler;
use App\Helpers\ResponsHelper;
use App\Helpers\SearchHelper;
use App\Http\Requests\KaryawanRequest;
use App\Http\Requests\KategoriRequest;
use App\Models\Kategori;
use Illuminate\Support\Facades\Log;


class KategoriController extends Controller
{
    protected $kategoriHandler,
              $repo;

    public function __construct(KategoriHandler $kategoriHandler)
    {
        $this->kategoriHandler = $kategoriHandler;
    }

    public function index()
    {
       try{
        $per_page = (int) request()->query('per_page', 3);
        if ($per_page < 1) $per_page = 1;
        $data = $this->kategoriHandler->all()->paginate($per_page)->appends(request()->query());
        return $data;
      
       }catch(\Exception $e){
        Log::error('Gagal mengambil data kategori: ' . $e->getMessage());
        return ResponsHelper::error('Gagal mengambil data kategori: ' . $e->getMessage(), 500);}
    }
    public function show($id)
    {
        try{
            $kategori = $this->kategoriHandler->find($id);
            if (!$kategori) {
                return ResponsHelper::error('Kategori not found', 404);
            }
            return ResponsHelper::success(new KategoriResource($kategori));
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data kategori: ' . $e->getMessage());
             return ResponsHelper::error('Gagal mengambil data kategori: ' . $e->getMessage(), 500);
   
        }
    }
    public function store(KategoriRequest  $request)
    {
        try {
            $data = $request->validated();
            $kategori = $this->kategoriHandler->create($data);
            return ResponsHelper::success(new KategoriResource($kategori), 'Kategori created successfully');
            
        } catch (\Exception $e) {
            return ResponsHelper::error('Gagal membuat kategori: ' . $e->getMessage(),  );
        }
    }
    
      
    public function update(KategoriRequest $request, $id)
    {
     try{
        $data = $request->validated();
        $kategori = $this->kategoriHandler->update($id, $data);
        if (!$kategori) {
            return ResponsHelper::error('Kategori not found', 404);
        }
        return ResponsHelper::success(new KategoriResource($kategori), 'berhasil di update');
     }catch(\Exception $e){
        return ResponsHelper::error('Gagal mengupdate kategori: ' . $e->getMessage(), 500);
     }
     
    }
    public function destroy($id)
    {
        try {
            $deleted = $this->kategoriHandler->delete($id);
            if (!$deleted) {
                return ResponsHelper::error('Kategori not found', 404);
            }
            return ResponsHelper::success(null, 'Kategori deleted successfully');
        } catch (\Exception $e) {
            return ResponsHelper::error('Gagal menghapus kategori: ' . $e->getMessage(), 500);
        }
    }

}
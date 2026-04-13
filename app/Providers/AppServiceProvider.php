<?php

namespace App\Providers;

use App\Interface\DepartemenInterface;
use App\Interface\JenisPelanggaranInterface;
use App\Interface\KaryawanInterface;
use App\Interface\KategoriInterface;
use App\Interface\PelanggaranInterface;
use App\Interface\SanksiInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\DepartemenRepositories;
use App\Repositories\JenisPelanggaranRepositories;
use App\Repositories\KaryawanRepositories;
use App\Repositories\KategoriRepositories;
use App\Repositories\PelanggaranRepositories;
use App\Repositories\SanksiRepositories;
use Illuminate\Support\Facades\App;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $bindings = [
         KategoriInterface::class => KategoriRepositories::class,
         DepartemenInterface::class => DepartemenRepositories::class,
         KaryawanInterface::class => KaryawanRepositories::class,
         PelanggaranInterface::class => PelanggaranRepositories::class,
            SanksiInterface::class => SanksiRepositories::class,
            JenisPelanggaranInterface::class => JenisPelanggaranRepositories::class,
        ];
       foreach ($bindings as $interface => $implementation){
    App::bind($interface, $implementation);
       
       }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // No observers registered here
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();

            $table->string('nama_karyawan');
            $table->string('alamat_karyawan');
            $table->ForeignId('departemen_id')->constrained('departemens')->onDelete('cascade');
            $table->string('email_karyawan')->unique();
            $table->string('jabatan_karyawan');
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->string('foto_karyawan')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};

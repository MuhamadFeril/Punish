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
        Schema::create('sanksi', function (Blueprint $table) {
            $table->id();
            $table->ForeignId('pelanggaran_id')->constrained('pelanggaran')->onDelete('cascade');
            $table->enum('jenis_sanksi', ['peringatan','SP1','SP2', 'denda', 'skorsing', 'pemecatan']);
            $table->date('tanggal_sanksi');
            $table->text('keterangan_sanksi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanksi');
    }
};

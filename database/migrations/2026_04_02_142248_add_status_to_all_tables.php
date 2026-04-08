<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    if (Schema::hasTable('karyawan') && !Schema::hasColumn('karyawan', 'status')) {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->string('status')->default('active')->after('foto_karyawan');
        });
    }

    if (Schema::hasTable('sanksi') && !Schema::hasColumn('sanksi', 'status')) {
        Schema::table('sanksi', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('keterangan_sanksi');
        });
    }

    if (Schema::hasTable('pelanggaran') && !Schema::hasColumn('pelanggaran', 'status')) {
        Schema::table('pelanggaran', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('bukti_pelanggaran');
        });
    }

    if (Schema::hasTable('jenis_pelanggaran') && !Schema::hasColumn('jenis_pelanggaran', 'status')) {
        Schema::table('jenis_pelanggaran', function (Blueprint $table) {
            $table->string('status')->default('active')->after('deskripsi_pelanggaran');
        });
    }
}

public function down()
{
    if (Schema::hasTable('karyawan') && Schema::hasColumn('karyawan', 'status')) {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    if (Schema::hasTable('sanksi') && Schema::hasColumn('sanksi', 'status')) {
        Schema::table('sanksi', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    if (Schema::hasTable('pelanggaran') && Schema::hasColumn('pelanggaran', 'status')) {
        Schema::table('pelanggaran', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    if (Schema::hasTable('jenis_pelanggaran') && Schema::hasColumn('jenis_pelanggaran', 'status')) {
        Schema::table('jenis_pelanggaran', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
};

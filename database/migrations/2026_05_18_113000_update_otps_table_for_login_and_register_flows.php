<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('otps', function (Blueprint $table) {
            $table->uuid('user_id')->nullable()->change();
            $table->string('email')->nullable()->after('user_id');
            $table->string('type')->default('login')->after('email');
            $table->string('otp', 255)->change();
            $table->index(['email', 'type']);
            $table->index(['user_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::table('otps', function (Blueprint $table) {
            $table->dropIndex(['email', 'type']);
            $table->dropIndex(['user_id', 'type']);
            $table->dropColumn(['email', 'type']);
            $table->string('otp', 6)->change();
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};

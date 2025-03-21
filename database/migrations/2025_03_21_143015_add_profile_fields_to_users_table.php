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
        Schema::table('users', function (Blueprint $table) {
            $table->string('bidang_pekerjaan')->nullable();
            $table->string('prestasi')->nullable();
            $table->text('pelatihan_training')->nullable();
            $table->text('hobi')->nullable();
            $table->string('surat_rekomendasi')->nullable();
            $table->string('pasfoto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};

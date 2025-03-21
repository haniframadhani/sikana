<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('wilayah')->nullable();
            $table->string('cabang')->nullable();
            $table->string('ranting')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('sekolah_universitas')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_lahir',
                'alamat',
                'wilayah',
                'cabang',
                'ranting',
                'pendidikan_terakhir',
                'sekolah_universitas',
            ]);
        });
    }
};

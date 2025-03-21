<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, HasRoles, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'tanggal_lahir',
        'alamat',
        'wilayah',
        'cabang',
        'ranting',
        'pendidikan_terakhir',
        'sekolah_universitas',
        'bidang_pekerjaan',
        'prestasi',
        'pelatihan_training',
        'hobi',
        'surat_rekomendasi',
        'pasfoto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Menentukan apakah pengguna dapat mengakses Filament.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
        // return $this->hasAnyRole(['admin', 'anggota', 'pimpinan-pusat', 'pimpinan-wilayah']);
    }
}

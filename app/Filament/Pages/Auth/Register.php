<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Textarea;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Register extends BaseRegister
{
  public function getMaxWidth(): MaxWidth
  {
    return MaxWidth::FiveExtraLarge;
  }

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Wizard::make([
          Wizard\Step::make('Informasi Dasar')
            ->icon('heroicon-o-user')
            ->schema([
              TextInput::make('name')
                ->label('Nama Lengkap')
                ->required(),

              TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique(table: User::class),

              TextInput::make('password')
                ->label('Password')
                ->password()
                ->required()
                ->minLength(8)
                ->same('passwordConfirmation'),

              TextInput::make('passwordConfirmation')
                ->label('Konfirmasi Password')
                ->password()
                ->required()
                ->dehydrated(false),

              DatePicker::make('tanggal_lahir')
                ->label('Tanggal Lahir')
                ->required(),

              TextInput::make('alamat')
                ->label('Alamat')
                ->required(),

              Select::make('wilayah')
                ->label('Wilayah')
                ->options([
                  'wilayah_1' => 'Wilayah 1',
                  'wilayah_2' => 'Wilayah 2',
                ])
                ->required()
                ->live()
                ->afterStateUpdated(fn(callable $set) => $set('cabang', null)),

              Select::make('cabang')
                ->label('Cabang')
                ->options(function (callable $get) {
                  $wilayah = $get('wilayah');
                  if (!$wilayah) {
                    return [];
                  }
                  return $this->getCabangOptions($wilayah);
                })
                ->required()
                ->live()
                ->afterStateUpdated(fn(callable $set) => $set('ranting', null)),

              Select::make('ranting')
                ->label('Ranting')
                ->options(function (callable $get) {
                  $cabang = $get('cabang');
                  if (!$cabang) {
                    return [];
                  }
                  return $this->getRantingOptions($cabang);
                })
                ->required(),

              Select::make('pendidikan_terakhir')
                ->label('Pendidikan Terakhir')
                ->options([
                  'sd' => 'SD',
                  'smp' => 'SMP',
                  'sma' => 'SMA/SMK',
                  'd3' => 'D3',
                  's1' => 'S1',
                  's2' => 'S2',
                  's3' => 'S3',
                ])
                ->required(),

              TextInput::make('sekolah_universitas')
                ->label('Sekolah / Universitas')
                ->required(),
            ]),

          Wizard\Step::make('Informasi Tambahan')
            ->icon('heroicon-o-clipboard-document-list')
            ->schema([
              Select::make('bidang_pekerjaan')
                ->label('Bidang Pekerjaan')
                ->options([
                  'pns' => 'PNS',
                  'swasta' => 'Karyawan Swasta',
                  'wirausaha' => 'Wirausaha',
                  'freelance' => 'Freelance',
                  'pelajar' => 'Pelajar/Mahasiswa',
                  'lainnya' => 'Lainnya',
                ])
                ->required(),

              Select::make('prestasi')
                ->label('Prestasi')
                ->options([
                  'akademik' => 'Akademik',
                  'non_akademik' => 'Non-Akademik',
                  'organisasi' => 'Organisasi',
                  'profesional' => 'Profesional',
                  'lainnya' => 'Lainnya',
                ])
                ->required(),

              Textarea::make('pelatihan_training')
                ->label('Pelatihan/Training')
                ->placeholder('Masukkan pelatihan/training yang pernah diikuti')
                ->helperText('Opsional')
                ->rows(3),

              Textarea::make('hobi')
                ->label('Hobi')
                ->placeholder('Masukkan hobi Anda')
                ->helperText('Opsional')
                ->rows(2),

              FileUpload::make('surat_rekomendasi')
                ->label('Surat Rekomendasi Pimpinan')
                ->required()
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(2048) // 2MB
                ->helperText('Format PDF, maksimal 2MB')
                ->directory('surat-rekomendasi'),

              FileUpload::make('pasfoto')
                ->label('Pas Foto')
                ->required()
                ->image()
                ->maxSize(1024) // 1MB
                ->helperText('Format JPG/PNG, maksimal 1MB')
                ->directory('pasfoto'),
            ]),
        ])
          ->skippable(false) // Prevent skipping steps
          ->persistStepInQueryString(), // Keep track of the current step in the URL
      ]);
  }

  protected function getCabangOptions(string $wilayah): array
  {
    $options = [
      'wilayah_1' => [
        'cabang_1_1' => 'Cabang 1.1',
        'cabang_1_2' => 'Cabang 1.2',
      ],
      'wilayah_2' => [
        'cabang_2_1' => 'Cabang 2.1',
        'cabang_2_2' => 'Cabang 2.2',
      ],
    ];

    return $options[$wilayah] ?? [];
  }

  protected function getRantingOptions(string $cabang): array
  {
    $options = [
      'cabang_1_1' => [
        'ranting_1_1_1' => 'Ranting 1.1.1',
        'ranting_1_1_2' => 'Ranting 1.1.2',
      ],
      'cabang_1_2' => [
        'ranting_1_2_1' => 'Ranting 1.2.1',
        'ranting_1_2_2' => 'Ranting 1.2.2',
      ],
    ];

    return $options[$cabang] ?? [];
  }

  protected function getCredentialsFromFormData(array $data): array
  {
    $additionalFields = [
      'tanggal_lahir' => $data['tanggal_lahir'],
      'alamat' => $data['alamat'],
      'wilayah' => $data['wilayah'],
      'cabang' => $data['cabang'],
      'ranting' => $data['ranting'],
      'pendidikan_terakhir' => $data['pendidikan_terakhir'],
      'sekolah_universitas' => $data['sekolah_universitas'],
      'bidang_pekerjaan' => $data['bidang_pekerjaan'],
      'prestasi' => $data['prestasi'],
      'pelatihan_training' => $data['pelatihan_training'] ?? null,
      'hobi' => $data['hobi'] ?? null,
    ];

    if (isset($data['surat_rekomendasi']) && $data['surat_rekomendasi'] instanceof TemporaryUploadedFile) {
      $additionalFields['surat_rekomendasi'] = $data['surat_rekomendasi']->store('surat-rekomendasi', 'public');
    }

    if (isset($data['pasfoto']) && $data['pasfoto'] instanceof TemporaryUploadedFile) {
      $additionalFields['pasfoto'] = $data['pasfoto']->store('pasfoto', 'public');
    }

    return [
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ] + $additionalFields;
  }
}

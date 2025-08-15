<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->profile_photo_path) {
            // Pastikan path yang disimpan di DB adalah relatif ke disk 'public'
            // Contoh: 'profile-photos/namafile.jpg'
            return Storage::url($this->profile_photo_path);
        }

        // Fallback ke UI Avatars jika tidak ada profile_photo_path
        // 'name' mengambil inisial dari nama pengguna
        // 'color=FFFFFF' untuk warna teks putih
        // 'background=random' untuk warna latar belakang acak
        // 'size=128' untuk ukuran gambar (piksel)
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=FFFFFF&background=random&size=128';
    }
    public function canAccessPanel(Panel $panel): bool
    {
        // Logika ini mengizinkan akses jika ID panel adalah 'admin'
        // DAN peran pengguna di database adalah 'admin'.
        return $panel->getId() === 'admin' && $this->role === 'admin';
    }
}

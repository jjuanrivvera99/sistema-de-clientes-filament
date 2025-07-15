<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasAvatar, MustVerifyEmail
{
    use HasFactory, HasRoles, Notifiable;

    // Conditionally use HasPanelShield trait methods
    use HasPanelShield {
        HasPanelShield::canAccessPanel as protected shieldCanAccessPanel;
        HasPanelShield::bootHasPanelShield as protected originalBootHasPanelShield;
    }

    protected static function bootHasPanelShield(): void
    {
        // Skip booting Shield in CI/testing environment
        if (env('DISABLE_SHIELD_TRAIT', false)) {
            return;
        }

        static::originalBootHasPanelShield();
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        // Skip Shield functionality in CI/testing environment
        if (env('DISABLE_SHIELD_TRAIT', false)) {
            return true;
        }

        return $this->shieldCanAccessPanel($panel);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
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

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url("$this->avatar_url") : null;
    }
}

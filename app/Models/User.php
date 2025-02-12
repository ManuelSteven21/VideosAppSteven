<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tests\Unit\UserTest;
use Tests\Unit\VideosTest;

/**
 * @property int $id
 * @property int|null $current_team_id
 * @property string $profile_photo_url
 * @property-read \App\Models\Team|null $team
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[] $ownedTeams
 * @method string getProfilePhotoUrl() Devuelve la URL de la foto de perfil
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, HasTeams, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'current_team_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
     * @var list<string>
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

    public function team()
    {
        return $this->belongsTo(Team::class, 'current_team_id');
    }

    public function ownedTeams()
    {
        return $this->hasMany(Team::class, 'user_id');
    }

    /**
     * Get the profile photo URL.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->getProfilePhotoUrl();
    }

    public function testedBy()
    {
        return UserTest::class;
    }

    public function isSuperAdmin(): bool
    {
        return (bool) $this->super_admin;
    }
}

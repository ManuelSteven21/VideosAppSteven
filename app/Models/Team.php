<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

/**
 * @property int $id
 * @property int $user_id
 * @property bool $personal_team
 * @property-read \App\Models\User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $members
 */


class Team extends JetstreamTeam
{

    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'personal_team',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
        ];
    }
    // En el modelo Team.php
//    public function users()
//    {
//        return $this->belongsTo(User::class);
//    }

    public function members()
    {
        return $this->hasMany(User::class, 'current_team_id');
    }

    /**
     * Obtener las invitaciones del equipo.
     */
    public function teamInvitations()
    {
        return $this->hasMany(TeamInvitation::class);
    }
}

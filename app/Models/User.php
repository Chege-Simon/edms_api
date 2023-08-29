<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'external_user_id'
    ];

    /**
     * Get the groups for the User.
     */
    // public function groupMemberships(): HasMany
    // {
    //     return $this->hasMany(GroupMembership::class);
    // }
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_memberships');
    }
}

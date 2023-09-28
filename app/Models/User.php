<?php

namespace App\Models;

  use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

use LdapRecord\Laravel\Auth\HasLdapUser;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements LdapAuthenticatable,JWTSubject

 {
    use HasApiTokens, HasFactory, Notifiable,AuthenticatesWithLdap,HasLdapUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username','name','email','guide',
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

    public function workstep_results(): HasMany
    {
        return $this->hasMany(WorkStepResult::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

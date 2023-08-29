<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_name', 'group_admin_id'
    ];

    /**
     * Get the permissions for the Groups.
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(GroupPermission::class);
    }

    /**
     * Get the users for the Groups.
     */
    // public function users(): HasMany
    // {
    //     return $this->hasMany(GroupMembership::class);
    // }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_memberships');
    }
}

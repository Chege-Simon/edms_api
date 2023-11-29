<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupMembership extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id', 'user_id'
    ];
    /**
     * Get the group that owns membership.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
    /**
     * Get the user that owns membership.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
    
    public function permissions(): HasMany
    {
        return $this->hasMany(GroupPermission::class);
    }
}

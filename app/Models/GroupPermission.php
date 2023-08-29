<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupPermission extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id', 'folder_id', 'add_user', 'edit_user',
        'delete_user', 'add_group', 'edit_group',
        'delete_group', 'add_permission', 'edit_permission',
        'delete_permission', 'assign_user_group','edit_user_group',
        'view_folder', 'open_folder', 'edit_folder',
        'delete_folder', 'create_nested_folder', 'edit_nested_folders',
        'delete_nested_folders', 'add_document', 'edit_document',
        'delete_document'
    ];
    /**
     * Get the Folder that owns permissions.
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
    /**
     * Get the Group that owns permissions.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}

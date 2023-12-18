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
//    protected $fillable = [
//        "group_id","folder_id","view_users","add_user","assign_user_group","view_user","update_user",
//        "delete_user","view_groups","add_group","view_group","update_group","delete_group","view_group_memberships",
//        "add_group_membership","view_group_membership","update_group_membership","delete_group_membership",
//        "view_group_permissions","add_group_permission","view_group_permission","update_group_permission",
//        "delete_group_permission","view_folders","create_folder","open_folder","update_folder","delete_folder",
//        "view_documents","add_document","view_document","update_document","delete_document","view_fields","add_field",
//        "view_field","update_field","delete_field","view_docfields","create_docfield","view_docfield","update_docfield",
//        "delete_docfield","view_worksteps","add_workstep","view_workstep","update_workstep","delete_workstep","view_possible_actions",
//        "add_possible_action","view_possible_action","update_possible_action","delete_possible_action","view_workstep_results",
//        "add_workstep_result","view_workstep_result","rewind_workstep_result","delete_workstep_result"
//    ];
    protected $guarded = [];
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

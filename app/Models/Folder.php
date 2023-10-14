<?php

namespace App\Models;

use App\Models\Field;
use App\Models\Document;
use App\Models\PossibleAction;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Folder extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name', 'path', 'parent_folder_id'
    ];
    
    /**
     * Get the parent_folder for the folder.
     */
    public function parent(): belongsTo
    {
        return $this->belongsTo(Field::class, 'parent_folder_id');
    }

    /**
     * Get the children folders for the folder.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_folder_id');
    }
    /**
     * Get the fields for the folder.
     */
    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }
    
    /**
     * Get the documents for the folder.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
    
    /**
     * Get the permissions for the Folder.
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(GroupPermission::class);
    }

       /**
     * Get the action for the folder.
     */
    public function action(): HasMany
    {
        return $this->hasMany(PossibleAction::class);
    }

      /**
     * Get the workstep for the folder.
     */
    public function workstep(): HasMany
    {
        return $this->hasMany(WorkStep::class);
    }
    
}

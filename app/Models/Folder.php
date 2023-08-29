<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Field;
use App\Models\Document;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Folder extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name', 'path'
    ];
    
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
}

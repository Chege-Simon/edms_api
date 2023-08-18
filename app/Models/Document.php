<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Folder;
use App\Models\DocField;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'folder_id', 'physical_path', 'document_name', 'file_size', 'created_by', 'updated_by'
    ];
    
    /**
     * Get the folder that owns field.
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
    /**
     * Get the doc_fields for the folder.
     */
    public function doc_fields(): HasMany
    {
        return $this->hasMany(DocField::class);
    }
}

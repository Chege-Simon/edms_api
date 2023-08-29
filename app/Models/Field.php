<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Folder;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Field extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'folder_id', 'field_name', 'field_datatype'
    ];

    /**
     * Get the folder that owns field.
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
    /**
     * Get the doc_fields for the field.
     */
    // public function doc_fields(): HasMany
    // {
    //     return $this->hasMany(DocField::class);
    // }

    /**
     * Get the documents for the field.
     */
    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'doc_fields');
    }
}

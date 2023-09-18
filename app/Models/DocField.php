<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocField extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_id', 'field_id', 'value'
    ];
    /**
     * Get the document that owns docfield.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
    /**
     * Get the field that owns docfield.
     */
    // public function field(): BelongsTo
    // {
    //     return $this->belongsTo(Field::class);
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Document;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * Get the document that owns field.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}

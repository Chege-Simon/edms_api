<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Folder;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}

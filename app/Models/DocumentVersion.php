<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentVersion extends Model
{
    use HasFactory;
    /**
    * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $fillable = [
        'document_id','physical_path','version_name', 'file_size', 'created_by', 'updated_by','main_file'
   ];
       /**
     * Get the created by for the document.
     */
    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

       /**
     * Get the updated by for the document.
     */
    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    /**
     * Get the document for the document Version.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}

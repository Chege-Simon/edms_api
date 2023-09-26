<?php

namespace App\Models;

use App\Models\Folder;
use App\Models\WorkStep;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PossibleAction extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'workstep_id',
        'next',
        'name',
     ];

     /**
     * Get the workstep that owns action.
     */
    public function workstep(): BelongsTo
    {
        return $this->belongsTo(WorkStep::class);
    }

    //  /**
    //  * Get the folder that owns action.
    //  */
    // public function folder(): BelongsTo
    // {
    //     return $this->belongsTo(Folder::class);
    // }

      /**
     * Get the workstep that owns action.
     */
    public function workstep_results(): HasMany
    {
        return $this->hasMany(WorkStepResult::class);
    }
}

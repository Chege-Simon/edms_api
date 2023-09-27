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
        'next_workstep_id',
        'name',
     ];

     /**
     * Get the workstep that owns action.
     */
    public function workstep(): BelongsTo
    {
        return $this->belongsTo(WorkStep::class, 'next_workstep_id');
    }

      /**
     * Get the workstep that owns action.
     */
    public function workstep_results(): HasMany
    {
        return $this->hasMany(WorkStepResult::class);
    }
}





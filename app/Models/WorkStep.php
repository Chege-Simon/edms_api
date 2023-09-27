<?php

namespace App\Models;

use App\Models\Folder;
use App\Models\PossibleAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkStep extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'workstep_id',
        'previous',
        'folder_id',
        'action',
        'workstep_type'
    ];

     /**
     * Get the folders that owns workstep.
     */
    public function folders(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
    
    public function worksteps_results():HasOne
    {
        return $this->hasOne(WorkStepResult::class);
    }

    public function possibleActions(): HasMany
    {
        return $this->hasMany(PossibleAction::class);
    }

}






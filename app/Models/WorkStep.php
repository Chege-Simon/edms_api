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
        'activity',
        'workstep_type'
    ];

     /**
     * Get the folder that owns workstep.
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
    
    public function worksteps_results():HasOne
    {
        return $this->hasOne(WorkStepResult::class);
    }

    public function possible_actions(): HasMany
    {
        return $this->hasMany(PossibleAction::class);
    }

}






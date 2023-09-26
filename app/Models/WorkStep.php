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
        'workstep_id',
        'previous',
        'folder_id',
        'action'
    ];

     /**
     * Get the folders in the workstep.
     */
    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class);
    }
    
    public function worksteps_results():HasOne
    {
        return $this->hasOne(WorkStepResult::class);
    }

}
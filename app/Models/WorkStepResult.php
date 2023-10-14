<?php

namespace App\Models;

 use App\Models\PossibleAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkStepResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'workstep_id',
        'document_id',
        'action_id',
        'user_id',
        'value',
    ];
            /**
     * Get the user for the workstep result.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function actions(): BelongsTo
    {
        return $this->belongsTo(PossibleAction::class);
    }

        /**
     * Get the document for the workstep result.
     */
    public function documents(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

              /**
     * Get the workstep for the workstep result.
     */
    public function workstep():BelongsTo
    {
        return $this->belongsTo(WorkStep::class);
    }
}


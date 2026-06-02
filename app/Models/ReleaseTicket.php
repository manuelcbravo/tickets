<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReleaseTicket extends Model
{
    use HasUuid;

    protected $fillable = [
        'release_id',
        'ticket_id',
        'development_task_id',
        'notas',
        'created_by_id',
    ];

    public function release(): BelongsTo
    {
        return $this->belongsTo(Release::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function developmentTask(): BelongsTo
    {
        return $this->belongsTo(TicketDevelopmentTask::class, 'development_task_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}

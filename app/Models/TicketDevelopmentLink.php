<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketDevelopmentLink extends Model
{
    use HasUuid, SoftDeletes;

    public const TIPOS = ['branch', 'commit', 'pull_request', 'merge_request', 'issue', 'documentacion', 'deploy', 'log', 'otro'];

    protected $fillable = [
        'ticket_id',
        'development_task_id',
        'tipo',
        'titulo',
        'url',
        'referencia',
        'metadata',
        'created_by_id',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(TicketDevelopmentTask::class, 'development_task_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}

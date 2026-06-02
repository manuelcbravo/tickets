<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketTestResult extends Model
{
    use HasUuid, SoftDeletes;

    public const STATUSES = ['pendiente', 'aprobado', 'fallido', 'bloqueado', 'no_aplica'];

    protected $fillable = [
        'ticket_id',
        'test_case_id',
        'development_task_id',
        'executed_by_id',
        'titulo',
        'pasos',
        'resultado_esperado',
        'resultado_obtenido',
        'status',
        'notas',
        'executed_at',
    ];

    protected $casts = [
        'executed_at' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function testCase(): BelongsTo
    {
        return $this->belongsTo(TestCase::class);
    }

    public function developmentTask(): BelongsTo
    {
        return $this->belongsTo(TicketDevelopmentTask::class, 'development_task_id');
    }

    public function executedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'executed_by_id');
    }

    public function evidences(): HasMany
    {
        return $this->hasMany(TicketTestEvidence::class, 'test_result_id');
    }
}

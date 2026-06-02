<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketTestEvidence extends Model
{
    use HasUuid;

    public const TIPOS = ['captura', 'video', 'documento', 'log', 'link', 'otro'];

    protected $table = 'ticket_test_evidences';

    protected $fillable = [
        'ticket_id',
        'test_result_id',
        'adjunto_id',
        'uploaded_by_id',
        'titulo',
        'descripcion',
        'tipo',
        'url',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function testResult(): BelongsTo
    {
        return $this->belongsTo(TicketTestResult::class, 'test_result_id');
    }

    public function adjunto(): BelongsTo
    {
        return $this->belongsTo(TicketAttachment::class, 'adjunto_id');
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by_id');
    }
}

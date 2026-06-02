<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KnowledgeArticleVersion extends Model
{
    use HasUuid;

    public $timestamps = false;

    protected $fillable = [
        'knowledge_article_id',
        'version',
        'titulo',
        'resumen',
        'contenido',
        'estatus',
        'visibilidad',
        'changed_by_id',
        'change_summary',
        'created_at',
    ];

    protected $casts = [
        'version' => 'integer',
        'created_at' => 'datetime',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(KnowledgeArticle::class, 'knowledge_article_id');
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by_id');
    }
}

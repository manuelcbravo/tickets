<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class KnowledgeArticle extends Model
{
    use HasUuid, SoftDeletes;

    public const TIPOS = [
        'procedimiento',
        'faq',
        'solucion_error',
        'guia_usuario',
        'guia_tecnica',
        'checklist',
        'respuesta_frecuente',
        'despliegue',
        'rollback',
        'interno',
    ];

    public const VISIBILIDADES = ['interna', 'publica', 'cliente', 'proyecto'];
    public const ESTATUS = ['borrador', 'en_revision', 'publicado', 'archivado'];

    protected $fillable = [
        'category_id',
        'cliente_id',
        'proyecto_id',
        'proyecto_modulo_id',
        'titulo',
        'slug',
        'resumen',
        'contenido',
        'tipo',
        'visibilidad',
        'estatus',
        'prioridad',
        'tags',
        'fuente_ticket_id',
        'creado_por_id',
        'actualizado_por_id',
        'revisado_por_id',
        'publicado_por_id',
        'reviewed_at',
        'published_at',
        'archived_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'prioridad' => 'integer',
        'reviewed_at' => 'datetime',
        'published_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(KnowledgeCategory::class, 'category_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function modulo(): BelongsTo
    {
        return $this->belongsTo(ProyectoModulo::class, 'proyecto_modulo_id');
    }

    public function fuenteTicket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'fuente_ticket_id');
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por_id');
    }

    public function actualizadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actualizado_por_id');
    }

    public function revisadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisado_por_id');
    }

    public function publicadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'publicado_por_id');
    }

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'ticket_knowledge_article')
            ->withPivot(['id', 'tipo_relacion', 'notas', 'created_by_id'])
            ->withTimestamps();
    }

    public function versions(): HasMany
    {
        return $this->hasMany(KnowledgeArticleVersion::class)->orderByDesc('version');
    }
}

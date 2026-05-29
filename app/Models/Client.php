<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Mattiverse\Userstamps\Traits\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\HasUuid;
use OwenIt\Auditing\Contracts\Auditable;

class Client extends Model implements Auditable
{
    use Userstamps, SoftDeletes, HasUuid;
    use \OwenIt\Auditing\Auditable;

    public const PUBLICO_GENERAL_UUID = '11111111-1111-4111-8111-111111111111';
    public const PUBLICO_GENERAL_RFC = 'XAXX010101000';

    // ===== MASS ASSIGNMENT =====
    protected $fillable = [
        'company_id',

        // datos personales
        'first_name',
        'middle_name',
        'last_name',
        'second_last_name',
        'birth_date',
        'age',
        'gender',

        //datos fiscales        
        'id_regimen_fiscal',
        'id_cliente_tipo',
        'id_uso_cfdi',

        // identificación
        'curp',
        'rfc',
        'tax_regime',

        // contacto
        'email',
        'email_verified_at',
        'phone',

        // dirección
        'street',
        'ext_number',
        'int_number',
        'neighborhood',
        'city',
        'state_id',
        'country_id',
        'postal_code',

        // perfil digital
        'avatar_path',

        // crm
        'source',
        'campaign',
        'sales_stage',
        'lifetime_value',
        'first_contact_at',
        'last_contact_at',
        'next_followup_at',

        // estado
        'is_active',
        'is_blacklisted',

        // json
        'documents',
        'extra_attributes',
    ];
    // ===== CASTS =====
    protected $casts = [
        'birth_date' => 'date',
        'first_contact_at' => 'date',
        'last_contact_at' => 'date',
        'next_followup_at' => 'date',

        'documents' => 'array',
        'extra_attributes' => 'array',

        'is_active' => 'boolean',
        'is_blacklisted' => 'boolean',

        'lifetime_value' => 'decimal:2',
    ];

    // ===== APPENDS =====
    protected $appends = [
        'full_name',
        'avatar_url',
    ];

    // =====================================================
    // ACCESSORS
    // =====================================================

    public function getFullNameAttribute()
    {
        return trim(implode(' ', array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
            $this->second_last_name
        ])));
    }

    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar_path) {
            return asset('assets/images/default_client.png');
        }

        // Si usas S3
        if (str_starts_with($this->avatar_path, 'http')) {
            return $this->avatar_path;
        }

        return \Storage::url($this->avatar_path);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeNotBlacklisted($query)
    {
        return $query->where('is_blacklisted', false);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('first_name', 'like', "%{$term}%")
                ->orWhere('last_name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%")
                ->orWhere('rfc', 'like', "%{$term}%");
        });
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isBlacklisted(): bool
    {
        return $this->is_blacklisted;
    }

    public function isPublicoEnGeneral(): bool
    {
        return $this->id === self::PUBLICO_GENERAL_UUID;
    }

    public function notes(): HasMany
    {
        return $this->hasMany(ClientNote::class)->latest();
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class)->latest('start_at');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class)->latest();
    }

    public function clinicalRecords(): HasMany
    {
        return $this->hasMany(ClinicalRecord::class, 'patient_id')->latest();
    }

    public function regimenFiscal(): BelongsTo
    {
        return $this->belongsTo(CatRegimenFiscale::class, 'id_regimen_fiscal', 'id');
    }

    public function clienteTipo(): BelongsTo
    {
        return $this->belongsTo(CatClienteTipo::class, 'id_cliente_tipo', 'id');
    }

    public function usoCfdi(): BelongsTo
    {
        return $this->belongsTo(CatUsoCfdi::class, 'id_uso_cfdi', 'id');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(CatEstado::class, 'state_id', 'id');
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(CatMunicipio::class, 'country_id', 'id');
    }
}

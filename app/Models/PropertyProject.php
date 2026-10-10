<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyProject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'agency_partner_id',
        'title',
        'slug',
        'developer_name',
        'property_type',
        'syariah_scheme',
        'price',
        'commission_rate',
        'province',
        'city',
        'district',
        'address_detail',
        'bedroom',
        'bathroom',
        'building_area',
        'land_area',
        'description',
        'halal_guarantee_notes',
        'status',
        'is_verified',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'commission_rate' => 'decimal:2',
            'bedroom' => 'integer',
            'bathroom' => 'integer',
            'building_area' => 'integer',
            'land_area' => 'integer',
            'is_verified' => 'boolean',
        ];
    }

    public function agencyPartner(): BelongsTo
    {
        return $this->belongsTo(AgencyPartner::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(PropertyFile::class);
    }

    public function primaryPhoto(): HasOne
    {
        return $this->hasOne(PropertyFile::class)->where('is_primary', true);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PropertyFile::class)->where('file_type', 'photo');
    }

    public function buyerLeads(): HasMany
    {
        return $this->hasMany(BuyerLead::class);
    }

    public function digitalAkads(): HasMany
    {
        return $this->hasMany(DigitalAkad::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_number',
        'description',
        'component_type_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // === Relaciones ===
    public function componentType()
    {
        return $this->belongsTo(ComponentType::class);
    }

    public function fgModels()
    {
        return $this->belongsToMany(FGModel::class, 'fg_bom')
            ->withPivot('qty_expected')
            ->withTimestamps();
    }

    public function componentScans()
    {
        return $this->hasMany(ComponentScan::class);
    }
}

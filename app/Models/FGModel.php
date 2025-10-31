<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FGModel extends Model
{
    use HasFactory;

    protected $table = 'fg_models';

    protected $fillable = [
        'fg_code',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function fgBoms()
    {
        return $this->hasMany(FGBom::class);
    }

    public function components()
    {
        return $this->belongsToMany(Component::class, 'fg_bom')
        ->withPivot('qty_expected')
        ->withTimestamps();
    }

    public function tracePlans()
    {
        return $this->hasMany(TracePlan::class);
    }

    public function productionRuns()
    {
        return $this->hasMany(ProductionRun::class);
    }
}

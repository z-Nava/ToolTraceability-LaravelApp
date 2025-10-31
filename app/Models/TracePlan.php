<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'fg_model_id',
        'version',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'version' => 'integer',
    ];

    // === Relaciones ===
    public function fgModel()
    {
        return $this->belongsTo(FGModel::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function requirements()
    {
        return $this->hasMany(TracePlanRequirement::class);
    }

    public function productionRuns()
    {
        return $this->hasMany(ProductionRun::class);
    }
}

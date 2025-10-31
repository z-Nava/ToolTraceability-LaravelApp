<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_run_id',
        'station_id',
        'dummy_tag_id',
        'scanned_raw',
        'part_number_detected',
        'component_id',
        'component_type_id',
        'is_valid',
        'validation_error',
        'scanned_by',
        'scanned_at',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
        'scanned_at' => 'datetime',
    ];

    // === Relaciones ===
    public function productionRun()
    {
        return $this->belongsTo(ProductionRun::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function dummyTag()
    {
        return $this->belongsTo(DummyTag::class);
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function componentType()
    {
        return $this->belongsTo(ComponentType::class);
    }

    public function scannedBy()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}

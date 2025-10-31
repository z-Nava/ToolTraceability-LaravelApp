<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DummyTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_run_id',
        'dummy_code',
        'status',
        'current_station_id',
        'opened_at',
        'closed_at',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    // === Relaciones ===
    public function productionRun()
    {
        return $this->belongsTo(ProductionRun::class);
    }

    public function currentStation()
    {
        return $this->belongsTo(Station::class, 'current_station_id');
    }

    public function componentScans()
    {
        return $this->hasMany(ComponentScan::class);
    }

    public function stationClosures()
    {
        return $this->hasMany(StationClosure::class);
    }
}

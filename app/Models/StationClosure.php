<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationClosure extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_run_id',
        'station_id',
        'dummy_tag_id',
        'closed_by',
        'closed_at',
        'is_complete',
        'validation_summary',
    ];

    protected $casts = [
        'closed_at' => 'datetime',
        'is_complete' => 'boolean',
        'validation_summary' => 'array',
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

    public function closedByUser()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }
}

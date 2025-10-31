<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_run_id',
        'station_id',
        'leader_user_id',
        'opened_at',
        'closed_at',
        'is_active',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'is_active' => 'boolean',
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

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'line_id',
        'code',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function tracePlanRequirements()
    {
        return $this->hasMany(TracePlanRequirement::class);
    }

    public function stationSessions()
    {
        return $this->hasMany(StationSession::class);
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'fg_model_id',
        'line_id',
        'started_by',
        'started_at',
        'ended_at',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function fgModel()
    {
        return $this->belongsTo(FGModel::class);
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function startedBy()
    {
        return $this->belongsTo(User::class, 'started_by');
    }

    public function stationSessions()
    {
        return $this->hasMany(StationSession::class);
    }

    public function dummyTags()
    {
        return $this->hasMany(DummyTag::class);
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

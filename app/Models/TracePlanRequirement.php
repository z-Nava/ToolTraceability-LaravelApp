<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracePlanRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'trace_plan_id',
        'station_id',
        'requirement_mode',
        'component_type_id',
        'part_number',
        'min_qty',
        'max_qty',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'min_qty' => 'integer',
        'max_qty' => 'integer',
    ];

    public function tracePlan()
    {
        return $this->belongsTo(TracePlan::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function componentType()
    {
        return $this->belongsTo(ComponentType::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function stations()
    {
        return $this->hasMany(Station::class);
    }

    public function productionRuns()
    {
        return $this->hasMany(ProductionRun::class);
    }
}

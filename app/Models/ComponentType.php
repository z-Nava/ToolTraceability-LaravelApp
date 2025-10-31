<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function components()
    {
        return $this->hasMany(Component::class);
    }

    public function tracePlanRequirements()
    {
        return $this->hasMany(TracePlanRequirement::class);
    }

    public function parsingRules()
    {
        return $this->hasMany(ParsingRule::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParsingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'regex_pattern',
        'part_number_group',
        'is_active',
        'component_type_id',
        'fg_model_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'part_number_group' => 'integer',
    ];

    public function componentType()
    {
        return $this->belongsTo(ComponentType::class);
    }

    public function fgModel()
    {
        return $this->belongsTo(FGModel::class);
    }
}

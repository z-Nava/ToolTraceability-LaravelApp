<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FGBom extends Model
{
    use HasFactory;

    protected $table = 'fg_bom';

    protected $fillable = [
        'fg_model_id',
        'component_id',
        'qty_expected',
    ];

    // === Relaciones ===
    public function fgModel()
    {
        return $this->belongsTo(FGModel::class);
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }
}

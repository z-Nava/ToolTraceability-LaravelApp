<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

     use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    // === Relaciones ===
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

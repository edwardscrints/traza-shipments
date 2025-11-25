<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchandise extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'merchandises';

    protected $fillable = [
        "mercan_name",
        "mercan_type",
        "mercan_rndc_id",
        "is_active",
    ];

    protected $casts = [
        "is_active" => "boolean",
    ];

    public function envios()
    {   // Relación: Estas mercancías están en muchos envíos
        return $this->hasMany(Shipment::class, 'merchandise_id');
    }
}

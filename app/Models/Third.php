<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// SoftDeletes
use Illuminate\Database\Eloquent\SoftDeletes;

class Third extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'thirds';

    protected $fillable = [
        "third_name",
        "document_type",
        "document_number",
        "third_type",
        "third_address",
        "is_active",
    ];
    
    protected $casts = [
        "is_active" => "boolean",
    ];
    
    protected $hidden = [
        "document_number",
    ];

    // Relaciones: Un tercero puede ser remitente en muchos envíos
    public function enviosComoRemitente()
    {
        return $this->hasMany(Shipment::class, 'third_id_remite');
    }

    // Relación: Un tercero puede ser destinatario en muchos envíos
    public function enviosComoDestinatario()
    {
        return $this->hasMany(Shipment::class, 'third_id_destin');
    }

    // Relación: Un tercero puede ser conductor en muchos envíos
    public function enviosConductor()
    {
        return $this->hasMany(Shipment::class, 'third_id_driver');
    }
}

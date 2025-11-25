<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// SoftDeletes
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'shipments';

    protected $fillable = [
        "tracking_number",
        "origin",
        "destination",
        "status",
        "remesa",
        "manifiesto",
        "date_manifiesto",
        "plate",
        "weight",
        "declared_price",
        "is_active",
        "observation",
        "third_id_driver",
        "third_id_remite",
        "third_id_destin",
        "merchandise_id",
        "created_by",
        "updated_by",
    ];

    protected $casts = [
        "is_active" => "boolean",
        "date_manifiesto" => "date",
        "weight" => "decimal:2",
        "declared_price" => "decimal:2",
    ];

    /* Constantes para estados del envío
    *  - Tipeo definido basado en avansat TMS
    */
    const STATUS_ALISTAMIENTO = 'En Alistamiento';
    const STATUS_ASIGNADO = 'Asignado a Vehiculo';
    const STATUS_TRANSITO = 'En Transito';
    const STATUS_FINALIZADO = 'Despacho Finalizado';
    const STATUS_CANCELADO = 'Cancelado';
    const STATUS_DEVUELTO = 'Devuelto';

    // Relación: Este envío pertenece a un remitente 
    public function remitente()
    {
        return $this->belongsTo(Third::class, 'third_id_remite');
    }

    // Relación: Este envío pertenece a un destinatario 
    public function destinatario()
    {
        return $this->belongsTo(Third::class, 'third_id_destin');
    }

    // Relación: Este envío pertenece a un conductor
    public function conductor()
    {
        return $this->belongsTo(Third::class, 'third_id_driver');
    }

    // Relación: Este envío pertenece a una mercancía
    public function mercancia()
    {
        return $this->belongsTo(Merchandise::class, 'merchandise_id');
    }

    // Relación: Este envío fue creado por un usuario
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relación: Este envío fue actualizado por un usuario
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

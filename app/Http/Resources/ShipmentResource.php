<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'tracking_number' =>  $this->tracking_number,
            'origin' => $this->origin ?? 'Origen no especificado',
            'destination' => $this->destination ?? 'Destino no especificado',
            'status' => $this->status,
            'remesa' => $this->remesa ?? 'Remesa no especificada',
            'manifiesto' => $this->manifiesto ?? 'Manifiesto no especificado',
            'date_manifiesto' => $this->date_manifiesto ?? 'Fecha de manifiesto no especificada',
            'plate' => $this->plate ?? 'Placa no especificada',
            'weight' => $this->weight ?? 'Peso no especificado',
            'declared_price' => $this->declared_price ?? 'Precio declarado no especificado',
            'is_active' => $this->is_active ?? true,
            'observation' => $this->observation ?? 'Sin observaciones',
            'third_id_driver' => $this->third_id_driver ?? 'Conductor no especificado',
            'third_id_remite' => $this->third_id_remite ?? 'Remitente no especificado',
            'third_id_destin' => $this->third_id_destin ?? 'Destinatario no especificado',
            'merchandise_id' => $this->merchandise_id ?? 'Mercancía no especificada',
            'id' => $this->id,
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tracking_number' => 'required|string|unique:shipments,tracking_number,' . $this->route('shipment'),
            'origin' => 'sometimes|string|max:255',
            'destination' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:En Alistamiento,Asignado a Vehiculo,En Transito,Despacho Finalizado,Cancelado,Devuelto',
            'remesa' => 'sometimes|nullable|string|max:255',
            'manifiesto' => 'sometimes|nullable|string|max:255',
            'date_manifiesto' => 'sometimes|nullable|date',
            'plate' => 'sometimes|nullable|string|max:20',
            'weight' => 'sometimes|nullable|numeric|min:0',
            'declared_price' => 'sometimes|nullable|numeric|min:0',
            'is_active' => 'sometimes|boolean',
            'observation' => 'sometimes|nullable|string',
            'third_id_driver' => 'sometimes|exists:thirds,id',
            'third_id_remite' => 'sometimes|exists:thirds,id',
            'third_id_destin' => 'sometimes|exists:thirds,id',
            'merchandise_id' => 'sometimes|exists:merchandises,id',   
        ];
    }
}

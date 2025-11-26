<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment; 
use App\Models\Third; 
use App\Models\Merchandise;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipments = Shipment::with([
            'conductor',
            'remitente',
            'destinatario',
            'mercancia',
            'creator',
            'updater',
        
        ])->paginate(10);
        return response()->json($shipments, 200);
        return Third::where('is_active', true)
        ->select('id', 'third_name', 'third_type')
        ->get();
        return Merchandise::where('is_active', true)
        ->select('id', 'mercan_name', 'mercan_type')
        ->get();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
              //Validaciones a partir de Fk y existencia en $request
            'tracking_number' => 'sometimes|string|unique:shipments,tracking_number',
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
        ]);


        $shipment = Shipment::create([
            'tracking_number' => $request->tracking_number,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'status' => $request->status,
            'remesa' => $request->remesa,
            'manifiesto' => $request->manifiesto,
            'date_manifiesto' => $request->date_manifiesto,
            'plate' => $request->plate,
            'weight' => $request->weight,
            'declared_price' => $request->declared_price,
            'is_active' => $request->is_active,
            'observation' => $request->observation,
            'third_id_driver' => $request->third_id_driver,
            'third_id_remite' => $request->third_id_remite,
            'third_id_destin' => $request->third_id_destin,
            'merchandise_id' => $request->merchandise_id,
            'created_by' => auth()->id(),
        ], 201);

        return response()->json($shipment, 201);

        if (!$shipment) {
            return response()->json(['message' => 'Error al crear el envío'], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipment = Shipment::with([
            'conductor',
            'remitente',
            'destinatario',
            'mercancia',
            'creator',
            'updater',
        ])->findOrFail($id);

        return response()->json($shipment, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'sometimes|string|unique:shipments,tracking_number,' . $id,
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
        ]);

        $shipment = Shipment::findOrFail($id);
        if (!$shipment) {
            return response()->json(['message' => 'Envío no encontrado'], 404);
        }

        $shipment->update([
            'tracking_number' => $request->tracking_number,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'status' => $request->status,
            'remesa' => $request->remesa,
            'manifiesto' => $request->manifiesto,
            'date_manifiesto' => $request->date_manifiesto,
            'plate' => $request->plate,
            'weight' => $request->weight,
            'declared_price' => $request->declared_price,
            'is_active' => $request->is_active,
            'observation' => $request->observation,
            'third_id_driver' => $request->third_id_driver,
            'third_id_remite' => $request->third_id_remite,
            'third_id_destin' => $request->third_id_destin,
            'merchandise_id' => $request->merchandise_id,
            'updated_by' => auth()->id(),
        ]);

        return response()->json($shipment, 200);
        
        if(!$shipment) {
            return response()->json(['message' => 'Error al actualizar el envío'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->delete();

        return response()->json([
            'message' => 'Envío eliminado exitosamente'
        ], 200);
    }

    /**
     * Activate Shipment (is_active = true)
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->update(['is_active' => true]);

        return response()->json($shipment, 200);
        
    }

     /**
     * Desactivate Shipment (is_active = false)
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function desactivate($id) 
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->update(['is_active' => false]);

        return response()->json($shipment, 200);
    }
}

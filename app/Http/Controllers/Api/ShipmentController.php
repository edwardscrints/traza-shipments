<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment; 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\ShipmentRequest;
use App\Http\Resources\ShipmentResource;

class ShipmentController extends Controller
{
    /*
     * Mostrar lista de envíos.
     *
     * @param  string  $tracking_number
     */
    
    public function index():JsonResource
    {
        $shipments = Shipment::with([
            'conductor',
            'remitente',
            'destinatario',
            'mercancia',
            'creator',
            'updater',
        
        ])->paginate(10);
        //return response()->json($shipments, 200);
        return ShipmentResource::collection($shipments);

    }

    /**
     * Almacenar un nuevo envío en el almacenamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(ShipmentRequest $request):JsonResponse
    {
        
        $shipment = Shipment::create($request->all() + [
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'data' => new ShipmentResource($shipment)], 201);

    }

    /**
     * Mostrar envio especifico
     *
     * @param  int  $id
     */
    public function show($id):JsonResource
    {
        $shipment = Shipment::with([
            'conductor',
            'remitente',
            'destinatario',
            'mercancia',
            'creator',
            'updater',
        ])->findOrFail($id);

        //return response()->json($shipment, 200);
        return new ShipmentResource($shipment);
    }

    /**
     * Actualizar envio existente
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(ShipmentRequest $request, $id):JsonResponse
    {
      
        $shipment = Shipment::findOrFail($id);

        $shipment->update($request->all() + [
            'updated_by' => auth()->id(),
        ]);
        $shipment->save();

        return response()->json([
            'success' => true, 
            'data' => new ShipmentResource($shipment)], 200);
    }

    /**
     * Eliminar envío especificado
     *
     * @param  int  $id
     */
    public function destroy($id):JsonResponse
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->delete();

        return response()->json([
            'message' => 'Envío eliminado exitosamente'
        ], 200);
    }

    /**
     * Activar envío (is_active = true)
     * @param  int  $id
     */
    public function activate($id):JsonResponse
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->update(['is_active' => true]);

        return response()->json([
            'success' => true,
            'data' => $shipment], 200);
        
    }

     /**
     * Desactivar envío (is_active = false)
     * @param  int  $id
     */
    public function desactivate($id):JsonResponse
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'data' => $shipment], 200);
    }

    /**
     * Obtener envío por número de seguimiento 
     *
     * @param  string  $tracking_number
     */
    public function getByTrackingNumber($tracking_number):JsonResponse
    {
        $shipment = Shipment::with([
            'conductor',
            'remitente',
            'destinatario',
            'mercancia',
        ])->where('tracking_number', $tracking_number)->first();

        if (!$shipment) {
            return response()->json([
                'message' => 'Envío no encontrado'
            ], 404);
        }

        //return response()->json($shipment, 200);
        return response()->json(new ShipmentResource($shipment), 200);
    }

    /**
     * Mostrar una lista de envíos.
     *
     * @return \Illuminate\Http\Response
     */
}

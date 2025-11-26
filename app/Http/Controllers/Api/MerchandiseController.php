<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Merchandise;
use Illuminate\Http\Request;

class MerchandiseController extends Controller
{
    /**
     * Obtener lista de mercancías activas para dropdowns
     */
    public function index()
    {
        $merchandises = Merchandise::where('is_active', true)
            ->select('id', 'mercan_name', 'mercan_type')
            ->orderBy('mercan_name')
            ->get();

        return response()->json($merchandises);
    }
}

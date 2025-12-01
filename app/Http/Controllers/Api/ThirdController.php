<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Third;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ThirdController extends Controller
{
    /**
     * Obtener lista de terceros activos para dropdowns
     */
    public function index():JsonResponse
    {
        $thirds = Third::where('is_active', true)
            ->select('id', 'third_name', 'third_type')
            ->orderBy('third_name')
            ->get();

        return response()->json($thirds);
    }
}

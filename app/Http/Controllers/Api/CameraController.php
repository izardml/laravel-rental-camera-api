<?php

namespace App\Http\Controllers\Api;

use App\Models\Camera;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CameraController extends Controller
{
    public function index()
    {
        $camera = Camera::whereNot('stock', 0)->get();

        return response()->json([
            'success' => true,
            'data' => $camera
        ], 200);
    }
    
    public function show($id)
    {
        $camera = Camera::find($id);

        if($camera){
            return response()->json([
                'success' => true,
                'message' => 'Fetching Camera Data Successfully',
                'data' => $camera,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Camera Not Found',
        ], 404);
    }
}

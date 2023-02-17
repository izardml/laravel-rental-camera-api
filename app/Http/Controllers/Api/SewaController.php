<?php

namespace App\Http\Controllers\Api;

use App\Models\Sewa;
use App\Models\Camera;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SewaController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'camera_id' => 'required',
            'customer_id' => 'required',
            'tgl_pinjam' => 'required',
            'tgl_kembali' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Form kosong wajib diisi.'
            ], 400);
        }
        $tgl_pinjam = Carbon::parse($request->tgl_pinjam);
        $tgl_kembali = Carbon::parse($request->tgl_kembali);
        
        $hari = $tgl_kembali->diffInDays($tgl_pinjam) + 1;
        $camera = Camera::find($request->camera_id);
        $total_sewa = $camera->tarif * $hari;
        $sewa = Sewa::create([
            'camera_id' => $request->camera_id,
            'customer_id' => $request->customer_id,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_kembali' => $request->tgl_kembali,
            'total_sewa' => $total_sewa,
        ]);
        if($sewa){
            $camera->update([
                'stock' => $camera->stock - 1
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Sewa Data Sent Successfully',
                'data' => $sewa
            ], 201);
        }
        return response()->json([
            'success' => false,
            'message' => 'Failed to Sent Sewa Data'
        ], 409);
    }

    public function show($id)
    {
        $sewas = Sewa::where('customer_id', $id)->with('camera')->latest()->get();

        if($sewas){
            return response()->json([
                'success' => true,
                'message' => 'Fetching Sewa Data Successfully',
                'data' => $sewas
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sewa Not Found',
        ], 404);
    }

    public function edit($id)
    {
        $sewa = Sewa::with('camera')->find($id);
        
        if($sewa){
            return response()->json([
                'success' => true,
                'message' => 'Fetching Sewa Data Successfully',
                'data' => $sewa,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sewa Not Found',
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'camera_id' => 'required',
            'customer_id' => 'required',
            'tgl_pinjam' => 'required',
            'tgl_kembali' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Form kosong wajib diisi.'
            ], 400);
        }

        $sewa = Sewa::find($id);

        $tgl_pinjam = Carbon::parse($request->tgl_pinjam);
        $tgl_kembali = Carbon::parse($request->tgl_kembali);
        
        $hari = $tgl_kembali->diffInDays($tgl_pinjam) + 1;

        $camera = Camera::find($request->camera_id);
        $total_sewa = $camera->tarif * $hari;

        if($sewa){
            if($sewa->camera_id != $request->camera_id){
                $camera_lama = Camera::find($sewa->camera_id);
                $camera_lama->update([
                    'stock' => $camera_lama->stock + 1
                ]);

                $camera->update([
                    'stock' => $camera->stock - 1
                ]);
            }

            $sewa->update([
                'camera_id' => $request->camera_id,
                'customer_id' => $request->customer_id,
                'tgl_pinjam' => $request->tgl_pinjam,
                'tgl_kembali' => $request->tgl_kembali,
                'total_sewa' => $total_sewa,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sewa Data Update Successfully',
                'data' => $sewa,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sewa Not Found',
        ], 404);
    }

    public function destroy($id)
    {
        $sewa = Sewa::find($id);
        $camera = Camera::find($sewa->camera_id);
        if($sewa){
            $sewa->delete();
            $camera->update([
                'stock' => $camera->stock + 1
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Sewa Data Delete Successfully',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Sewa Not Found',
        ], 404);
    }
}

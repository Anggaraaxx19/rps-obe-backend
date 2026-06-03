<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MappingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'cpl_id' => 'required',
                'cpmk_id' => 'required',
            ]);

            // Cegah duplikasi hubungan pemetaan yang sama persis di database
            $isDuplicate = DB::table('mappings')
                ->where('cpl_id', $request->cpl_id)
                ->where('cpmk_id', $request->cpmk_id)
                ->exists();

            if ($isDuplicate) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Hubungan pemetaan kompetensi ini sudah pernah dibuat!'
                ], 422);
            }

            DB::table('mappings')->insert([
                'cpl_id' => $request->cpl_id,
                'cpmk_id' => $request->cpmk_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => '✓ Sukses memetakan hubungan CPL ke CPMK!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengunci relasi data: ' . $e->getMessage()
            ], 500);
        }
    }
}
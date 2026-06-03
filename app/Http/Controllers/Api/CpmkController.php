<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CpmkController extends Controller
{
    public function index()
    {
        try {
            // Kita join ke mata kuliah agar di tabel CPMK bisa muncul nama matkulnya
            $data = DB::table('cpmks')
                ->join('mata_kuliahs', 'cpmks.mata_kuliah_id', '=', 'mata_kuliahs.id')
                ->select('cpmks.*', 'mata_kuliahs.nama_mk', 'mata_kuliahs.kode_mk')
                ->get();
            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'mata_kuliah_id' => 'required',
                'kode_cpmk' => 'required',
                'deskripsi' => 'required',
            ]);

            DB::table('cpmks')->insert([
                'mata_kuliah_id' => $request->mata_kuliah_id,
                'kode_cpmk' => $request->kode_cpmk,
                'deskripsi' => $request->deskripsi,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json(['status' => 'success', 'message' => 'CPMK Berhasil ditambah!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    public function destroy(string $id)
{
    try {
        DB::table('cpmks')->where('id', $id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data CPMK berhasil dihapus!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menghapus data: ' . $e->getMessage()
        ], 500);
    }
}
}
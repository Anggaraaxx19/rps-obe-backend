<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CplController extends Controller
{
    public function index()
    {
        try {
            $data = DB::table('cpls')->get();
            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kode_cpl' => 'required',
                'deskripsi' => 'required',
            ]);

            $cek = DB::table('cpls')->where('kode_cpl', $request->kode_cpl)->exists();
            if ($cek) {
                return response()->json(['status' => 'error', 'message' => 'Kode CPL sudah ada!'], 422);
            }

            DB::table('cpls')->insert([
                'kode_cpl' => $request->kode_cpl,
                'deskripsi' => $request->deskripsi,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json(['status' => 'success', 'message' => 'CPL Berhasil ditambah!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // Perbaikan utama ada di penambahan tipe data 'string' sebelum variabel $id
    public function destroy(string $id)
    {
        try {
            DB::table('cpls')->where('id', $id)->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data CPL berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }
}
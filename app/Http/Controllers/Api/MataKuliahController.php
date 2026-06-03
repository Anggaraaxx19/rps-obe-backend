<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MataKuliahController extends Controller
{
    public function index()
    {
        try {
            $data = DB::table('mata_kuliahs')->get();
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kode_mk' => 'required',
                'nama_mk' => 'required',
                'sks' => 'required|numeric',
                'semester' => 'required|numeric',
            ]);

            // Cek manual kode MK biar responnya rapi
            $cekDuplikat = DB::table('mata_kuliahs')->where('kode_mk', $request->input('kode_mk'))->exists();
            if ($cekDuplikat) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kode Mata Kuliah ini sudah terdaftar di database!'
                ], 422);
            }

            DB::table('mata_kuliahs')->insert([
                'kode_mk' => $request->input('kode_mk'),
                'nama_mk' => $request->input('nama_mk'),
                'sks' => $request->input('sks'),
                'semester' => $request->input('semester'),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Mata Kuliah berhasil ditambahkan!'
            ]);

        } catch (\Exception $e) {
            // Jika ada error database (tabel belum ada/kolom salah), pesan aslinya akan dikirim ke React
            return response()->json([
                'status' => 'error',
                'message' => 'Masalah Server/Database: ' . $e->getMessage()
            ], 500);
        }
    }
    public function destroy(string $id)
{
    try {
        DB::table('mata_kuliahs')->where('id', $id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Mata kuliah berhasil dihapus!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menghapus data: ' . $e->getMessage()
        ], 500);
    }
}
}
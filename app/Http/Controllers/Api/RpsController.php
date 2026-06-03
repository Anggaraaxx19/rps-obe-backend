<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RpsController extends Controller
{
    // Mengambil semua dokumen RPS aktif digabung dengan data Mata Kuliah
    public function index()
    {
        $data = DB::table('rps')
            ->join('mata_kuliahs', 'rps.mata_kuliah_id', '=', 'mata_kuliahs.id')
            ->select('rps.*', 'mata_kuliahs.nama_mk', 'mata_kuliahs.kode_mk', 'mata_kuliahs.sks', 'mata_kuliahs.semester')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // Otomatis generate dokumen draft RPS baru
    public function store(Request $request)
    {
        $request->validate([
            'mata_kuliah_id' => 'required',
            'dosen_pengembang' => 'required',
            'tahun_akademik' => 'required',
        ]);

        // Cek apakah mata kuliah ini sudah dibuatkan RPS-nya
        $cekRps = DB::table('rps')->where('mata_kuliah_id', $request->mata_kuliah_id)->exists();
        if ($cekRps) {
            return response()->json([
                'status' => 'error',
                'message' => 'RPS untuk Mata Kuliah ini sudah pernah dibuat!'
            ], 400);
        }

        DB::table('rps')->insert([
            'mata_kuliah_id' => $request->mata_kuliah_id,
            'dosen_pengembang' => $request->dosen_pengembang,
            'tahun_akademik' => $request->tahun_akademik,
            'status' => 'Draft',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen format RPS berhasil digenerate!'
        ]);
    }
    // Tambahkan baris insert ke tabel revisis di dalam fungsi validasi kamu
public function validasi(Request $request, string $id)
{
    $request->validate([
        'status' => 'required|in:Draft,Review,Disetujui'
    ]);

    // 1. Ambil data nama mata kuliah terlebih dahulu untuk keperluan log
    $rpsData = DB::table('rps')
        ->join('mata_kuliahs', 'rps.mata_kuliah_id', '=', 'mata_kuliahs.id')
        ->where('rps.id', $id)
        ->select('mata_kuliahs.nama_mk')
        ->first();

    // 2. Update status RPS
    DB::table('rps')
        ->where('id', $id)
        ->update([
            'status' => $request->status,
            'updated_at' => now()
        ]);

    // 3. Otomatis catat perubahan ke tabel riwayat revisi
    DB::table('revisis')->insert([
        'rps_id' => $id,
        'nama_matkul' => $rpsData->nama_mk,
        'aktivitas' => "Mengubah status dokumen menjadi [" . $request->status . "]",
        'aktor' => "KAPRODI JURUSAN",
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Status validasi berhasil diperbarui dan tercatat di riwayat!'
    ]);
}

// Fungsi baru untuk mengambil data log riwayat perubahan
public function riwayatRevisi()
{
    $log = DB::table('revisis')->orderBy('created_at', 'desc')->get();
    return response()->json([
        'status' => 'success',
        'data' => $log
    ]);
}
}

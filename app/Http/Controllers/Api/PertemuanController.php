<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PertemuanController extends Controller
{
    public function getByRps(string $rps_id)
    {
        $data = DB::table('pertemuan_kuliahs')
            ->where('rps_id', $rps_id)
            ->orderBy('minggu_ke', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rps_id' => 'required',
            'minggu_ke' => 'required|numeric|min:1|max:16',
            'materi' => 'required',
            'metode' => 'required',
            'bobot_penilaian' => 'required|numeric',
        ]);

        DB::table('pertemuan_kuliahs')->insert([
            'rps_id' => $request->rps_id,
            'minggu_ke' => $request->minggu_ke,
            'materi' => $request->materi,
            'metode' => $request->metode,
            'tugas' => $request->tugas,
            'bobot_penilaian' => $request->bobot_penilaian,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Detail pertemuan mingguan berhasil disimpan!'
        ]);
    }
}
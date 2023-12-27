<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::all();
        return response()->json([
            'data' => $mahasiswas, // Ubah 'mahasiswas' menjadi 'data' untuk konsistensi
        ]);
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        return response()->json(['data' => $mahasiswa]);
    }

    public function store(Request $request)
    {
        $rules = [
            'nama'   => ['required'],
            'alamat' => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        }

        $mahasiswa = Mahasiswa::create([
            'nama'   => $request->input('nama'),
            'alamat' => $request->input('alamat'),
        ]);

        return response()->json([
            'message'  => 'Mahasiswa berhasil dibuat',
            'mahasiswa' => $mahasiswa,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        }

        $mahasiswa->update([
            'nama'   => $request->input('nama'),
            'alamat' => $request->input('alamat'),
        ]);

        return response()->json([
            'message'  => 'Mahasiswa berhasil diperbarui',
            'mahasiswa' => $mahasiswa,
        ], 200);
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        $mahasiswa->delete();

        return response()->json([
            'message' => 'Mahasiswa berhasil dihapus'
        ], 200);
    }
}

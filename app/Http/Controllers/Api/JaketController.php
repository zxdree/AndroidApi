<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jaket;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Log;

class JaketController extends Controller
{
    public function create()
    {
        return view('jakets.create');
    }
    public function index(Request $request)
    {
        $userId = $request->header('Authorization');

        if ($userId == null) {
            $jakets = Jaket::all();
        }else{
            $jakets = Jaket::where('Authorization', $userId)
                ->get();
        }

        return response()->json($jakets);
    }
    public function edit($id)
    {
        return view('jakets.edit', [
            'jaket' => Jaket::findOrFail($id),
        ]);

    }


    public function all()
    {
        $jakets = Jaket::all();
        return response()->json($jakets);
    }


    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'status' => 'required|string',
            'gambar' => 'required|image|max:2048',
            'Authorization'=> 'nullable|string',

        ]);

        Log::info('data', [$request->all()]);
        $path = $request->file('gambar')->store('jaket_images', 'public');
        $fileName = basename($path);


        $jaket = Jaket::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'status' => $request->status,
            'gambar' => $fileName,
            'Authorization' => $request->header('Authorization'),


        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Jaket berhasil disimpan!',
            'data' => $jaket
        ], 201);
    }


    public function show($id)
    {
        $jaket = Jaket::find($id);

        if (!$jaket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($jaket);
    }


    public function destroy($id)
    {
        $jaket = Jaket::find($id);

        if (!$jaket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        if ($jaket->gambar) {
            Storage::delete('jaket_images/' . $jaket->gambar);
        }

        $jaket->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'nama' => 'nullable|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $jaket = Jaket::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($jaket->gambar) {
                Storage::delete('jaket_images/' . $jaket->gambar);
            }
            $path = $request->file('gambar')->store('jaket_images');
            $jaket->gambar = basename($path);
        }

        if ($request->has('nama')) {
            $jaket->nama = $request->input('nama'); //
        }
        if ($request->has('jenis')) {
            $jaket->jenis = $request->input('jenis');
        }
        if ($request->has('status')) {
            $jaket->status = $request->input('status');
        }


        if ($request->hasHeader('Authorization')) {
            $jaket->Authorization = $request->header('Authorization');
        }

        $jaket->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diupdate!',
            'data' => $jaket
        ]);
    }
}

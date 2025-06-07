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
        // Karena tidak ada lagi filter UID, cukup tampilkan semua jaket
        return response()->json($jakets);
    }
    public function edit($id)
    {
        return view('jakets.edit', [
            'jaket' => Jaket::findOrFail($id),
        ]);

    }

    /**
     * Tampilkan daftar semua jaket. Ini akan sama dengan index() sekarang.
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $jakets = Jaket::all();
        return response()->json($jakets);
    }

    /**
     * Tambahkan jaket baru.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            // 'id' => 'required|string|unique:jakets,id|max:255',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'status' => 'required|string',
            'gambar' => 'required|image|max:2048',
            'Authorization'=> 'nullable|string', // Jika ada header Authorization, bisa diabaikan
            // 'uid' tidak perlu lagi
        ]);

        Log::info('data', [$request->all()]);
        $path = $request->file('gambar')->store('jaket_images'); // Simpan gambar di storage/app/public/jaket_images
        $fileName = basename($path);
        // $mine = !empty($request->header('Authorization'));

        $jaket = Jaket::create([
            // 'id' => $request->id,
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'status' => $request->status,
            'Authorization' => $request->header('Authorization'), // Ambil dari header Authorization jika ada
            // 'email' => $request->user() ? $request->user()->email : null, // Ambil email dari user yang terautentikasi
            'gambar' => $fileName,
            // 'uid' tidak perlu lagi
            // 'mine' => $mine,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Jaket berhasil disimpan!',
            'data' => $jaket
        ], 201);
    }

    /**
     * Tampilkan detail satu jaket berdasarkan ID (string).
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $jaket = Jaket::find($id);

        if (!$jaket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($jaket);
    }

    /**
     * Hapus jaket berdasarkan ID (string).
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**

     */
    public function update(Request $request, $id)
    {
        // Validasi input
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

        // U pdate hanya field yang diinput user
        // Gunakan has() untuk mengecek keberadaan parameter, meskipun nilainya kosong
        // Log ini ditempatkan setelah potensi pemrosesan request untuk memastikan
        // nilai input sudah sepenuhnya tersedia.
        Log::info('Nama (raw request input):', [$request->input('nama')]); // Log input mentah
        Log::info('Is has nama (check):', [$request->has('nama')]); // Log hasil has()

        if ($request->has('nama')) {
            $jaket->nama = $request->input('nama'); // Gunakan input() untuk konsistensi
        }
        if ($request->has('jenis')) {
            $jaket->jenis = $request->input('jenis');
        }
        if ($request->has('status')) {
            $jaket->status = $request->input('status');
        }

        // Update Authorization jika ada header Authorization
        if ($request->hasHeader('Authorization')) {
            $jaket->Authorization = $request->header('Authorization');
        }

        $jaket->save();

        Log::info('Nama (after saving):', [$request->all()]); // Log nilai setelah disimpan
        Log::info('Id:', [$id]); // Log nilai setelah disimpan

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diupdate!',
            'data' => $jaket
        ]);
    }
}

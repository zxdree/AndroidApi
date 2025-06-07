<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jaket; // Pastikan model Jaket diimpor
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Untuk menghasilkan ID unik
use Illuminate\Validation\Rule;

class JaketWebController extends Controller
{
    /**
     * Tampilkan form untuk membuat jaket baru.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('jaket.create');
    }

    /**
     * Simpan jaket baru dari form web.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            // 'id' => 'required|string|unique:jakets,id|max:255',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'status' => 'required|string',
            'gambar' => 'required|image|max:2048', // Validasi gambar
        ]);

        $path = $request->file('gambar')->store('jaket_images'); // Simpan gambar di storage/app/public/jaket_images
        $fileName = basename($path);

        Jaket::create([
            // 'id' => $request->id,
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'status' => $request->status,
            'gambar' => $fileName,
            'mine' => false, // Default: public
        ]);

        // Redirect kembali ke form dengan pesan sukses
        return redirect()->route('jakets.create')->with('success', 'Jaket berhasil ditambahkan!');
    }

    /**
     * Tampilkan semua jaket.
     * Anda bisa menambahkan tampilan daftar jaket di sini jika diperlukan.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $jakets = Jaket::all();
        return view('jakets.index', compact('jakets'));
    }
}

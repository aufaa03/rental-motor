<?php

namespace App\Http\Controllers;

use App\Models\Merek;
use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MotorController extends Controller
{
    public function index(Request $request)
    {
        $query = Motor::with('merek'); // Pastikan relasi ke Merek ada

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where('nama_motor', 'like', '%' . $search . '%')
                  ->orWhereHas('merek', function ($q) use ($search) {
                      $q->where('nama_merek', 'like', '%' . $search . '%');
                  });
        }

        $data = [
            'merek' => Merek::all(),
            'motor' => $query->get()
        ];

        return view('motor.index', $data);
    }

    public function tambah(Request $request)
    {
        // Motor::create([
        //     'nama_motor' => $request->nama_motor,
        //     'nomor_polisi' => $request->nomer_polisi,
        //     'merek_id' => $request->merek,
        //     'warna' => $request->warna,
        //     'bahan_bakar' => $request->bahan_bakar,
        //     'harga_sewa' => $request->harga,
        //     'status' => $request->status,
        //     'tranmisi' => $request->transmisi,
        //     'foto' => $request->foto
        // ]);

    //     $request->validate([
    //         'nama_motor' => 'required',
    //         'nomer_polisi' => 'required',
    //         'merek' => 'required',
    //         'warna' => 'required',
    //         'bahan_bakar' => 'required',
    //         'harga' => 'required|numeric',
    //         'status' => 'required',
    //         'transmisi' => 'required',
    //         'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ],
    //     [
    //         'harga.numeric' => 'harga harus berupa angka!',
    //         'foto.mimes' => 'format foto tidak sesuai. Hanya file JPEG, PNG, JPG, dan GIF yang diperbolehkan.',
    //         'foto.max' => 'maksimal ukuran foto adalah 2mb.'

    //     ]
    // );

        $data = [
            'nama_motor' => $request->nama_motor,
            'nomor_polisi' => $request->nomer_polisi,
            'merek_id' => $request->merek,
            'warna' => $request->warna,
            'bahan_bakar' => $request->bahan_bakar,
            'harga_sewa' => $request->harga,
            'status' => $request->status,
            'tranmisi' => $request->transmisi,
        ];

        // Handle upload foto
        if ($request->hasFile('foto')) {
            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('motor', 'public');
            $data['foto'] = $fotoPath;
        }
        Motor::create($data);

        return redirect()->route('motor')->with('success', 'Berhasil Menambahkan Data!');
    }

    public function update(Request $request, $id)
    {
        $motor = Motor::findOrFail($id);

        $request->validate([
            'nama_motor' => 'required',
            'nomer_polisi' => 'required',
            'merek' => 'required',
            'warna' => 'required',
            'bahan_bakar' => 'required',
            'harga' => 'required|numeric',
            'status' => 'required',
            'transmisi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],
        [
            'harga.numeric' => 'harga harus berupa angka!',
            'foto.mimes' => 'format foto tidak sesuai. Hanya file JPEG, PNG, JPG, dan GIF yang diperbolehkan.',
            'foto.max' => 'maksimal ukuran foto adalah 2mb.'

        ]
    );

        $data = [
            'nama_motor' => $request->nama_motor,
            'nomor_polisi' => $request->nomer_polisi,
            'merek_id' => $request->merek,
            'warna' => $request->warna,
            'bahan_bakar' => $request->bahan_bakar,
            'harga_sewa' => $request->harga,
            'status' => $request->status,
            'tranmisi' => $request->transmisi,
        ];

        // Handle upload foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($motor->foto && Storage::exists($motor->foto)) {
                Storage::delete($motor->foto);
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('motor', 'public');
            $data['foto'] = $fotoPath;
        }

        // Update data motor
        $motor->update($data);

        return redirect()->route('motor')->with('success', 'Berhasil Mengubah Data!');
    }

    public function delete($id)
    {
        $motor = Motor::findOrFail($id);
        $motor->delete();
        return redirect()->route('motor')->with('success', 'Berhasil MengHapus Data!');
    }
}

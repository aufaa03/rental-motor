<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggan'));
    }
    public function tambahPelanggan(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required',
                'alamat' => 'required',
                'nomor_hp' => 'required|max:15',
                'nomor_ktp' => 'required|max:17',
                'email' => 'required|email'
            ],
            [
                'nama.required' => 'Nama harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'nomor_hp.required' => 'Nomor HP harus diisi',
                'nomor_hp.max' => 'Nomor HP tidak boleh lebih dari 15 digit',
                'nomor_ktp.required' => 'Nomor KTP harus diisi',
                'nomor_ktp.max' => 'Nomor KTP tidak boleh lebih dari 17 digit',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email tidak valid'
            ]
        );
        Pelanggan::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->nomor_hp,
            'no_ktp' => $request->nomor_ktp,
            'email' => $request->email
        ]);
        return redirect('/pelanggan')->with('success', 'Data Pelanggan Berhasil Ditambahkan');
    }

    public function updatePelanggan(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        // dd($pelanggan);
        $pelanggan->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->nomor_hp,
            'no_ktp' => $request->nomor_ktp,
            'email' => $request->email
        ]);
        return redirect('/pelanggan')->with('success', 'Data Pelanggan Berhasil Diubah');
    }
    public function deletePelanggan($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return redirect('/pelanggan')->with('success', 'Data Pelanggan Berhasil Dihapus');
    }
}

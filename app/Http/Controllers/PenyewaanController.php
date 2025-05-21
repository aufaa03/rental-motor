<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Pelanggan;
use App\Models\Penyewaan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PenyewaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penyewaan::where('status', 'berjalan');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pelanggan', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }

        Penyewaan::where('tanggal_kembali', '<', now())
            ->where('status', 'berjalan')
            ->update(['status' => 'belum kembali']);

        $datas = [
            'penyewaan' => $query->get(),
            'pelanggan' => Pelanggan::all(),
            'motor' => Motor::where('status', 'tersedia')->get(),
        ];

        return view('sewa.index', $datas);
    }

    public function Tambah(Request $request)
    {
        $request->validate([
            'pelanggan' => 'required',
            'motor' => 'required',
            'tanggal_sewa' => 'required',
            'tanggal_selesai' => 'required',
            'biaya' => 'required',
        ]);
        Penyewaan::create([
            'pelanggan_id' => $request->pelanggan,
            'motor_id' => $request->motor,
            'tanggal_sewa' => $request->tanggal_sewa,
            'tanggal_kembali' => $request->tanggal_selesai,
            'total_bayar' => str_replace('.', '', $request->biaya),
        ]);
        $motor = Motor::findOrFail($request->motor);
        $motor->update([
            'status' => 'disewa',
        ]);
        return redirect()->route('penyewaan')->with('success', 'Data berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $sewa = Penyewaan::findOrFail($id);
        $sewa->update([
            'tanggal_sewa' => $request->tanggal_sewa,
            'tanggal_kembali' => $request->tanggal_selesai,
            'total_bayar' => $request->biaya,
        ]);
        return redirect()->route('penyewaan')->with('success', 'Data berhasil diubah');
    }
    public function delete($id)
{
    $sewa = Penyewaan::findOrFail($id);

    // Ubah status motor menjadi tersedia
    $motor = $sewa->motor;
    if ($motor) {
        $motor->update(['status' => 'tersedia']);
    }

    // // Ubah status transaksi menjadi dibatalkan
    //     Transaksi::create([
    //         'penyewaan_id' => $sewa->id,
    //         'denda' => '0', // Sesuaikan dengan kebutuhan
    //         'total_bayar' => $sewa->total_bayar,
    //         'status' => 'dibatalkan',
    //     ]);

    // // Ubah status penyewaan menjadi selesai tanpa menghapus data
    // $sewa->update(['status' => 'selesai']);
        $sewa->delete();
    return redirect()->route('penyewaan')->with('success', 'Penyewaan dibatalkan dan status diperbarui');
}
}

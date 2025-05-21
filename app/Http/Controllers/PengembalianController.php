<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Penyewaan;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

    class PengembalianController extends Controller
    {
        public function index()
        {
            $penyewaanList = Penyewaan::whereIn('status', ['berjalan', 'belum kembali'])->get();

            $today = Carbon::today();
            $totalDenda = 0; // Inisialisasi dengan 0

            foreach ($penyewaanList as $penyewaan) {
                $tanggalKembali = Carbon::parse($penyewaan->tanggal_kembali);

                // Hanya hitung denda jika sudah lewat dari tanggal kembali
                if ($today->greaterThan($tanggalKembali)) {
                    $selisihWaktu = $tanggalKembali->diffInDays($today);
                    $denda = $selisihWaktu * 50000;

                    // Pastikan hanya menambah denda untuk penyewaan yang telat
                    $totalDenda += $denda;
                }
            }

            $data = [
                'penyewaan' => $penyewaanList,
                'denda' => $totalDenda,
            ];

            return view('pengembalian.index', $data);
        }


        public function kembali(Request $request, $id)
        {
            $penyewaan = Penyewaan::findOrFail($id);
            $totalDenda = 0;
            $today = Carbon::today();
            $tanggalKembali = Carbon::parse($penyewaan->tanggal_kembali);

            if ($today->greaterThan($tanggalKembali)) { // Hanya hitung jika sudah lewat
                $selisihWaktu = $tanggalKembali->diffInDays($today);
                $totalDenda = $selisihWaktu * 50000;
            }
            // dd($totalDenda);
            $penyewaan->update([
                'status' => 'selesai',
            ]);

            $motor = $penyewaan->motor;
            $motor->update([
                'status' => 'tersedia',
            ]);

            Pengembalian::create([
                'penyewaan_id' => $id,
                'tanggal_pengembalian' => $today,
                'denda' => $totalDenda,
            ]);

            Transaksi::create([
                'penyewaan_id' => $id,
                'denda' => $totalDenda,
                'tanggal_pengembalian' => $today,
                'total_bayar' => $penyewaan->total_bayar + $totalDenda,
                'status' => $request->status_transaksi,
            ]);

            return redirect()->route('pengembalian')->with('success', 'Berhasil Mengubah Status Penyewaan');
        }
    }

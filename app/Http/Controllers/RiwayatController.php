<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{

    public function index(Request $request)
    {
        $query = Transaksi::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('penyewaan.pelanggan', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            })->orWhereHas('penyewaan.motor', function ($q) use ($search) {
                $q->where('nama_motor', 'like', '%' . $search . '%');
            });
        }

        $transaksi = $query->get();

        return view('riwayat.index', compact('transaksi'));
    }


}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Motor;
use App\Models\Pelanggan;
use App\Models\Penyewaan;
use Illuminate\Http\Request;

class utamaController extends Controller
{
    public function index() {
          $jumlahPelanggan = Pelanggan::count();
        $jumlahMotor = Motor::count();
        $jumlahMotorTersedia = Motor::where('status', 'tersedia')->count();
        $jumlahMotorDisewa = Motor::where('status', 'disewa')->count();
     $penyewaanBerjalan = Penyewaan::where('status', 'berjalan')->count();
        $jumlahPenyewaan = Penyewaan::count();
        // dd($jumlahPenyewaan);
    return view('index', compact('jumlahPelanggan', 'jumlahMotor', 'penyewaanBerjalan', 'jumlahPenyewaan', 'jumlahMotorTersedia', 'jumlahMotorDisewa'));
    }
}

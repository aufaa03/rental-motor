@extends('layout.partials.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4 order-0">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-primary">
                    Selamat Datang di Rental Motor Aufa!
                </h3>
                <p class="mb-4">
                    Temukan berbagai pilihan motor terbaik untuk disewa dengan harga terjangkau.
                </p>
                <a href="javascript:;" class="btn btn-sm btn-outline-primary">Lihat Motor</a>
            </div>
        </div>
    </div>
</div>

<!-- Card Section -->
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <span class="fw-semibold d-block mb-1">Jumlah Pelanggan</span>
                <h3 class="card-title mb-2">{{ $jumlahPelanggan }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <span>Jumlah Motor</span>
                <h3 class="card-title text-nowrap mb-1">{{ $jumlahMotor }}</h3>
                <small class="text-info fw-semibold">
                    <i class="bx bx-info-circle"></i> {{ $jumlahMotorDisewa }} motor sedang disewa
                </small><br>
                <small class="text-info fw-semibold">
                    <i class="bx bx-info-circle"></i> {{ $jumlahMotorTersedia }} motor tersedia
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <span class="d-block mb-1">Jumlah Penyewaan</span>
                <h3 class="card-title text-nowrap mb-2">{{ $jumlahPenyewaan }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <span class="fw-semibold d-block mb-1">Penyewaan Berjalan</span>
                <h3 class="card-title mb-2">{{ $penyewaanBerjalan }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection

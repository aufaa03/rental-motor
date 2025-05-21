@extends('layout.partials.app')
@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sewa /</span> Riwayat Penyewaan</h4>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="mb-0">Riwayat Penyewaan Motor</h5>

                        <form action="{{ route('riwayat') }}" method="GET" class="d-flex mt-2 mt-md-0" style="width: 300px;">
                            <input type="text" name="search" class="form-control me-2" placeholder="Cari pelanggan atau motor..." value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </form>
                    </div>

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible mt-3" role="alert">
                            <strong>{{ session('success') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="card-body ">


                    <div class="table-responsive text-nowrap mt-4 text-center">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Motor sewa</th>
                                    <th>Denda</th>
                                    <th>Total bayar</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @if ($transaksi->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center pt-3 fs-5">Data tidak ditemukan</td>
                                    </tr>
                                @endif
                                @foreach ($transaksi as $data)
                                    <tr>
                                        <td><i class="fab fa-react fa-lg text-info me-2"></i>
                                            <strong>{{ $loop->iteration }}</strong>
                                        </td>
                                        <td>
                                            {{ $data->penyewaan->pelanggan->nama }}
                                        </td>
                                        <td>{{ $data->penyewaan->motor->nama_motor }}</td>
                                        <td>
                                            {{ 'Rp ' . number_format($data->denda, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            {{ 'Rp ' . number_format($data->total_bayar, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            {{-- {{ substr($data->created_at , 0, 10) . ' ' .substr($data->created_at, 14) }} --}}
                                            {{ \Carbon\Carbon::parse($data->created_at)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i') }}

                                        </td>
                                        <td>
                                            @if ($data->status == 'dibatalkan')
                                                <span class="badge bg-danger">{{ $data->status }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $data->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

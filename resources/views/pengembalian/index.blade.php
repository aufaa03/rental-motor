@extends('layout.partials.app')
@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sewa /</span> Pengembalian</h4>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Pengembalian Motor</h5>
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
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
                                    <th>Pelanggan</th>
                                    <th>Motor Sewa</th>
                                    <th>Tanggal Sewa</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @if ($penyewaan->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center pt-3 fs-5">Data tidak ditemukan</td>
                                    </tr>
                                @endif
                                @foreach ($penyewaan as $data)
                                    <tr>
                                        <td><i class="fab fa-react fa-lg text-info me-2"></i>
                                            <strong>{{ $loop->iteration }}</strong>
                                        </td>
                                        <td>{{ $data->pelanggan->nama }}</td>
                                        <td>
                                            {{ $data->motor->nama_motor }}
                                        </td>
                                        <td>
                                            {{ $data->tanggal_sewa }}
                                        </td>
                                        <td>
                                            {{ $data->tanggal_kembali }}
                                        </td>
                                        <td>
                                            @if ($data->status == 'belum kembali')
                                                <span class="badge bg-warning">{{ $data->status }}</span>
                                            @elseif($data->status == 'berjalan')
                                                <span class="badge bg-info">{{ $data->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#pilih{{ $data->id }}">

                                                <span class="bx bx-low-vision"></span> pilih
                                            </button>
                                            {{-- <button class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal" wire:click='edit({{ $data->id }})'>

                                            <span class="bx bx-pencil"></span>
                                        </button>
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            wire:click='confirmDelete({{ $data->id }})'>
                                            <span class="bx bx-trash"></span> --}}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $penyewaan->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($penyewaan as $data)
        {{-- pilih modal --}}
        <div class="modal fade" id="pilih{{ $data->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Pengembalian Motor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <dl class="row mt-2 align-items-center">
                            <dt class="col-md-4 text-md-end">Pelanggan :</dt>
                            <dd class="col-md-8">{{ $data->pelanggan->nama }}</dd>
                            <dt class="col-md-4 text-md-end">Motor Sewa :</dt>
                            <dd class="col-md-8">{{ $data->motor->nama_motor }}</dd>
                            <dt class="col-md-4 text-md-end">Warna Motor :</dt>
                            <dd class="col-md-8">{{ $data->motor->warna }}</dd>
                            <dt class="col-md-4 text-md-end">Nomer Polisi :</dt>
                            <dd class="col-md-8">{{ $data->motor->nomor_polisi }}</dd>
                            <dt class="col-md-4 text-md-end">Tanggal Kembali :</dt>
                            <dd class="col-md-8">{{ $data->tanggal_kembali }}</dd>
                            <dt class="col-md-4 text-md-end">Tanggal Hari Ini :</dt>
                            <dd class="col-md-8">{{ date('Y-m-d') }}</dd>
                            <dt class="col-md-4 text-md-end">Status :</dt>
                            <dd class="col-md-8">
                                @if ($data->tanggal_kembali < date('Y-m-d'))
                                    <span class="badge bg-danger">Terlambat</span>
                                @elseif ($data->tanggal_kembali == date('Y-m-d'))
                                    <span class="badge bg-success">Tepat Waktu</span>
                                @else
                                    <span class="badge bg-warning">Masih ada waktu</span>
                                @endif
                            </dd>
                            <dt class="col-md-4 text-md-end">Denda :</dt>
                            <dd class="col-md-8">
                                @if ($denda == 0 || $denda <= 0)
                                    <span class="badge bg-success">Tidak Ada Denda</span>
                                @elseif($denda > 0)
                                    <span class="badge bg-danger">{{ 'Rp ' . number_format($denda, 0, ',', '.') }}</span>
                                @endif
                            </dd>
                            <dt class="col-md-4 text-md-end"> Total Bayar :</dt>
                            <dd class="col-md-8"> {{ 'Rp ' . number_format($data->total_bayar + $denda , 0, ',', '.') }}
                            <dt class="col-md-4 text-md-end"> Status Transaksi :</dt>
                            <dd class="col-md-8">
                                <form action="{{ route('kembali', $data->id) }}" method="POST">
                                    @csrf
                                    {{-- @method('PUT') --}}
                             <select  class="form-select" name="status_transaksi" id="status_transaksi">
                                <option value="selesai">Selesai</option>
                                <option value="dibatalkan">Dibatalkan</option>
                            </select>
                            </dd>
                        </dl>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                            {{-- <input type="hidden" name="total_bayar" value="{{ $data->total_bayar + $denda }}"> --}}
                            {{-- <input type="hidden" name="status" value="kembali"> --}}
                            <button type="submit" class="btn btn-primary">Kembalikan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

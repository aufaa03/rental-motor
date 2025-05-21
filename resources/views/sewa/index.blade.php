@extends('layout.partials.app')
@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sewa /</span> Penyewaan</h4>

    <div class= "row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Penyewaan Motor</h5>
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <strong>{{ session('success') }}</strong>
                        </div>
                    @endif
                    @if (session()->has('message'))
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <strong>{{ session('message') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="card-body ">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Tombol di kiri -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                            <span class="bx bx-plus"></span> Tambah
                        </button>

                        <!-- Input di kanan -->
                        <form action="{{ route('penyewaan') }}" method="GET" class="d-flex mb-3" style="width: 300px;">
                            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama pelanggan..." value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </form>


                    </div>

                    <div class="table-responsive text-nowrap mt-4 text-center">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Foto Motor</th>
                                    <th>Motor Sewa</th>
                                    {{-- <th>Tanggal Sewa</th>
                                    <th>Tanggal Kembali</th> --}}
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @if ($penyewaan->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center pt-3 fs-5">Data tidak ditemukan</td>
                                    </tr>
                                @else
                                    @foreach ($penyewaan as $data)
                                        <tr>
                                            <td><i class="fab fa-react fa-lg text-info me-2"></i>
                                                <strong>{{ $loop->iteration }}</strong>
                                            </td>
                                            <td>
                                                {{ $data->pelanggan->nama }}
                                            </td>
                                            <td>
                                                @if ($data->motor->foto)
                                                    <img src="{{ asset('storage/' . $data->motor->foto) }}" alt="Foto Motor"
                                                        class="img-thumbnail"
                                                        style=" width: 50px; height: 45px; object-fit: cover">
                                                    {{-- max-height: 40px; max-width: 60px; --}}
                                                @else
                                                    <p class="text-muted">Tidak ada foto yang tersedia.</p>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $data->motor->nama_motor }}
                                            </td>
                                            <td>
                                                {{ 'Rp ' . number_format($data->total_bayar, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @if ($data->status == 'selesai')
                                                    <span class="badge bg-success">{{ $data->status }}</span>
                                                @else
                                                    <span class="badge bg-info">{{ $data->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $data->id }}">

                                                    <span class="bx bx-pencil"></span>
                                                </button>
                                                {{-- <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $data->id }}">
                                                    <span class="bx bx-trash"></span>
                                                </button> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{-- {{ $kategori->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal tambah --}}
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Penyewaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahSewa') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col mb-3">
                                <label for="pelangganSelect" class="form-label">Pelanggan</label>
                                <select class="form-select" name="pelanggan" id="pelangganSelect">
                                    <option selected>Pilih pelanggan</option>
                                    @foreach ($pelanggan as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mb-3">
                                <label for="motorSelect" class="form-label">Motor</label>
                                <select class="form-select" name="motor" id="motorSelect">
                                    <option selected value="">Pilih Motor</option>
                                    @foreach ($motor as $data)
                                        <option value="{{ $data->id }}" data-harga="{{ $data->harga_sewa }}">
                                            {{ $data->nama_motor }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tanggalSewa" class="form-label">Tanggal Sewa</label>
                                <input type="date" class="form-control" id="tanggalSewa" name="tanggal_sewa">
                            </div>
                            <div class="col mb-3">
                                <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggalSelesai" name="tanggal_selesai">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="biaya" class="form-label">Biaya</label>
                                <input type="text" class="form-control" id="biaya" name="biaya">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- edit modal --}}
    @foreach ($penyewaan as $data)
    <div class="modal fade modal-edit" id="editModal{{ $data->id }}" tabindex="-1" aria-hidden="true" data-harga="{{ $data->motor->harga_sewa }}">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Merek</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updateSewa', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $data->id }}">

                        <div class="row">
                            <div class="col mb-3">
                                <label for="pelangganSelect" class="form-label">Pelanggan</label>
                                <input type="text" class="form-control" value="{{ $data->pelanggan->nama }}" disabled>
                            </div>
                            <div class="col mb">
                                <label class="form-label">Motor</label>
                                <input type="text" class="form-control" value="{{ $data->motor->nama_motor }}" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="tanggalSewa" class="form-label">Tanggal Sewa</label>
                                <input type="date" class="form-control tanggalSewa" name="tanggal_sewa"
                                    value="{{ $data->tanggal_sewa ? \Carbon\Carbon::parse($data->tanggal_sewa)->format('Y-m-d') : '' }}">
                            </div>
                            <div class="col mb-3">
                                <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control tanggalSelesai" name="tanggal_selesai"
                                    value="{{ $data->tanggal_kembali ? \Carbon\Carbon::parse($data->tanggal_kembali)->format('Y-m-d') : '' }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="biaya" class="form-label">Biaya</label>
                                <input type="number" class="form-control biaya" value="{{ $data->total_bayar }}" name="biaya">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- script untuk hitung harga otomatis --}}
   <script>
document.addEventListener("DOMContentLoaded", function () {
    // ================= MODAL TAMBAH =================
    function hitungBiayaTambah() {
        const motorSelect = document.getElementById("motorSelect");
        const tanggalSewa = document.getElementById("tanggalSewa");
        const tanggalSelesai = document.getElementById("tanggalSelesai");
        const biayaInput = document.getElementById("biaya");

        let hargaPerHari = parseInt(motorSelect.selectedOptions[0]?.getAttribute("data-harga")) || 0;
        let startDate = new Date(tanggalSewa.value);
        let endDate = new Date(tanggalSelesai.value);

        if (tanggalSewa.value && tanggalSelesai.value && endDate >= startDate) {
            let selisihHari = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
            biayaInput.value = selisihHari * hargaPerHari;
        } else {
            biayaInput.value = "";
        }
    }

    const motorSelect = document.getElementById("motorSelect");
    const tanggalSewaTambah = document.getElementById("tanggalSewa");
    const tanggalSelesaiTambah = document.getElementById("tanggalSelesai");

    if (motorSelect && tanggalSewaTambah && tanggalSelesaiTambah) {
        motorSelect.addEventListener("change", hitungBiayaTambah);
        tanggalSewaTambah.addEventListener("change", hitungBiayaTambah);
        tanggalSelesaiTambah.addEventListener("change", hitungBiayaTambah);
    }

    // ================= MODAL EDIT =================
    function hitungBiayaEdit(modal) {
        const tanggalSewa = modal.querySelector(".tanggalSewa");
        const tanggalSelesai = modal.querySelector(".tanggalSelesai");
        const biayaInput = modal.querySelector(".biaya");
        const hargaPerHari = parseInt(modal.getAttribute("data-harga")) || 0;

        if (tanggalSewa.value && tanggalSelesai.value) {
            let startDate = new Date(tanggalSewa.value);
            let endDate = new Date(tanggalSelesai.value);

            if (endDate >= startDate) {
                let selisihHari = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                biayaInput.value = selisihHari * hargaPerHari;
            } else {
                biayaInput.value = "";
            }
        }
    }

    // Event listener saat tanggal diubah di modal edit
    document.querySelectorAll(".modal-edit").forEach(modal => {
        const tanggalSewa = modal.querySelector(".tanggalSewa");
        const tanggalSelesai = modal.querySelector(".tanggalSelesai");

        if (tanggalSewa && tanggalSelesai) {
            tanggalSewa.addEventListener("change", function () {
                hitungBiayaEdit(modal);
            });

            tanggalSelesai.addEventListener("change", function () {
                hitungBiayaEdit(modal);
            });
        }
    });

    // Hitung otomatis saat modal edit dibuka
    document.querySelectorAll(".modal-edit").forEach(modal => {
        modal.addEventListener("shown.bs.modal", function () {
            hitungBiayaEdit(modal);
        });
    });
});
</script>





        {{-- delete modal --}}
        <!-- Modal Konfirmasi Hapus -->
        @foreach ($penyewaan as $data)
        <!-- Modal Konfirmasi Hapus -->
        {{-- <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $data->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $data->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus penyewaan ini?</p>
                        <ul>
                            <li><strong>Pelanggan:</strong> {{ $data->pelanggan->nama }}</li>
                            <li><strong>Motor:</strong> {{ $data->motor->nama_motor }}</li>
                            <li><strong>Total Bayar:</strong> Rp{{ number_format($data->total_bayar, 0, ',', '.') }}</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('deleteSewa', $data->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
    @endforeach

    @endforeach
    <script>
        function formatRupiah(input) {
            let value = input.value.replace(/\D/g, ""); // Ambil hanya angka
            let formatted = new Intl.NumberFormat("id-ID").format(value); // Format angka tanpa Rp dan tanpa desimal
            input.value = formatted; // Update nilai input dengan format yang benar
        }
        </script>


@endsection

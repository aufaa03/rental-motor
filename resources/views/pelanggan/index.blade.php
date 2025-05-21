@extends('layout.partials.app')
@section('content')
    <h4 class="fw-bold py-3 mb-4">Data Pelanggan</h4>

    <div class= "row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Data Pelanggan</h5>
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <strong>{{ session('success') }}</strong>
                        </div>
                    @endif
                    @error('nama')
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                    @error('alamat')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror

                    @error('nomor_hp')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror

                    @error('nomor_ktp')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror

                    @error('email')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror
                </div>
                <div class="card-body ">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Tombol di kiri -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                            <span class="bx bx-plus"></span> Tambah
                        </button>

                        <!-- Input di kanan -->
                        <div style="width: 300px;">
                            <input type="text" class="form-control" placeholder="Search..." />
                        </div>
                    </div>

                    <div class="table-responsive text-nowrap mt-4 text-center">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Nomor Ktp</th>
                                    <th>Nomor Hp</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @if ($pelanggan->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center pt-3 fs-5">Data tidak ditemukan</td>
                                    </tr>
                                @else
                                    @foreach ($pelanggan as $data)
                                        <tr>
                                            <td><i class="fab fa-react fa-lg text-info me-2"></i>
                                                <strong>{{ $loop->iteration }}</strong>
                                            </td>
                                            <td>
                                                {{ $data->nama }}
                                            </td>
                                            <td>
                                                {{ $data->no_ktp }}
                                            </td>
                                            <td>
                                                {{ $data->no_hp }}
                                            </td>
                                            <td>
                                                {{ $data->email }}
                                            </td>
                                            <td class="text-truncate"
                                                style="max-width: 200px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                                {{ $data->alamat }}
                                            </td>

                                            <td>
                                                <button class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#detail{{ $data->id }}">

                                                    <span class="bx bx-info-circle"></span>
                                                </button>
                                                <button class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $data->id }}">

                                                    <span class="bx bx-pencil"></span>
                                                </button>
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $data->id }}">
                                                    <span class="bx bx-trash"></span>
                                                </button>
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
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Data Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahPelanggan') }}" method="post">
                        @csrf
                        <div class="row g-2">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Nama Pelanggan <span
                                        class="text-danger">*</span></label>
                                <input type="text" required id="nameBasic" class="form-control" placeholder="*bayu"
                                    name="nama" />
                                @error('merek')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <strong>{{ $message }}</strong>

                                    </div>
                                @enderror
                            </div>
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Nomor Hp <span
                                        class="text-danger">*</span></label>
                                <input type="number" inputmode="numeric" required id="nameBasic" class="form-control"
                                    placeholder="*086662xxxx" name="nomor_hp" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" required id="nameBasic" class="form-control"
                                    placeholder="*example@gmail.com" name="email" />
                            </div>
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Nomor KTP <span
                                        class="text-danger">*</span></label>
                                <input type="number" inputmode="numeric" required id="nameBasic" class="form-control"
                                    placeholder="*8272265868" name="nomor_ktp" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <label for="exampleFormControlTextarea1" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    @foreach ($pelanggan as $data)
        {{-- detail modal --}}
        <div class="modal fade" id="detail{{ $data->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Detail Motor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <dl class="row mt-2 align-items-center">
                            <!-- Nama Motor -->
                            <dt class="col-md-4 text-md-end">Nama :</dt>
                            <dd class="col-md-8">{{ $data->nama }}</dd>

                            <!-- Merek -->
                            <dt class="col-md-4 text-md-end">Nomor HP :</dt>
                            <dd class="col-md-8">{{ $data->no_hp }}</dd>

                            <!-- Bahan Bakar -->
                            <dt class="col-md-4 text-md-end">Nomor KTP :</dt>
                            <dd class="col-md-8">{{ $data->no_ktp }}</dd>

                            <!-- Warna -->
                            <dt class="col-md-4 text-md-end">alamat :</dt>
                            <dd class="col-md-8">{{ $data->alamat }}</dd>

                            <!-- Nomor Polisi -->
                            <dt class="col-md-4 text-md-end">Email :</dt>
                            <dd class="col-md-8">{{ $data->email }}</dd>

                        </dl>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- edit modal --}}
   <!-- Modal Edit -->
<div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <form action="{{ route('updatePelanggan', $data->id) }}" method="post">
            @csrf
            @method('put')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="nama{{ $data->id }}" class="form-label">Nama</label>
                            <input type="text" id="nama{{ $data->id }}" name="nama"
                                   value="{{ $data->nama }}" class="form-control" placeholder="*Budi" />
                        </div>
                        <div class="col mb-3">
                            <label for="hp{{ $data->id }}" class="form-label">Nomor HP</label>
                            <input type="number" inputmode="numeric" id="hp{{ $data->id }}" name="nomor_hp"
                                   value="{{ $data->no_hp }}" class="form-control" placeholder="*0867378" />
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="ktp{{ $data->id }}" class="form-label">Nomor KTP</label>
                            <input type="number" inputmode="numeric" id="ktp{{ $data->id }}" name="nomor_ktp"
                                   value="{{ $data->no_ktp }}" class="form-control" placeholder="*337937362" />
                        </div>
                        <div class="col mb-3">
                            <label for="email{{ $data->id }}" class="form-label">Email</label>
                            <input type="email" id="email{{ $data->id }}" name="email"
                                   value="{{ $data->email }}" class="form-control" placeholder="*example@gmail.com" />
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="alamat{{ $data->id }}" class="form-label">Alamat</label>
                            <textarea id="alamat{{ $data->id }}" name="alamat" rows="3" class="form-control">{{ $data->alamat }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

        {{-- delete modal --}}
        <!-- Modal Delete -->
       <!-- Modal Delete -->
<!-- Modal Delete -->
<div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('hapusPelanggan', $data->id) }}" method="post">
            @csrf
            @method('delete')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data pelanggan <strong>{{ $data->nama }}</strong>?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>


        {{-- end delete modal --}}
    @endforeach

@endsection

@extends('layout.partials.app')
@section('content')
    <div>
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Motor /</span> Data Motor</h4>

        <!-- Basic Bootstrap Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Data Motor</h5>
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <strong>{{ session('success') }}</strong>
                            </div>
                        @endif
                        @error('foto')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <strong>{{ $message }}</strong>
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
                            <form action="{{ route('motor') }}" method="GET" class="d-flex mb-3" style="width: 300px;">
                                <input type="text" name="search" class="form-control me-2" placeholder="Cari motor atau merek..." value="{{ request('search') }}">
                                <button class="btn btn-outline-primary" type="submit">Cari</button>
                            </form>

                        </div>

                        <div class="table-responsive text-nowrap mt-4 text-center">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Merek</th>
                                        <th>Warna</th>
                                        <th>Status</th>
                                        <th>No Polisi</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @if ($motor->isEmpty())
                                        <tr>
                                            <td colspan="8" class=" pt-3 fs-5">Data tidak ditemukan</td>
                                        </tr>
                                    @endif
                                    @foreach ($motor as $data)
                                        <tr>
                                            <td><i class="fab fa-react fa-lg text-info me-2"></i>
                                                <strong>
                                                    {{ $loop->iteration }}
                                                </strong>
                                            </td>
                                            <td>
                                                @if ($data->foto)
                                                    <img src="{{ asset('storage/' . $data->foto) }}" alt="Foto Motor"
                                                        class="img-thumbnail"
                                                        style=" width: 50px; height: 45px; object-fit: cover">
                                                    {{-- max-height: 40px; max-width: 60px; --}}
                                                @else
                                                    <p class="text-muted">Tidak ada foto yang tersedia.</p>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $data->nama_motor }}
                                            </td>
                                            <td>
                                                {{ $data->merek->nama_merek }}
                                            </td>
                                            <td>
                                                {{ $data->warna }}
                                            </td>
                                            <td>
                                                @if ($data->status == 'tersedia')
                                                    <span
                                                        class="badge rounded-pill bg-label-success">{{ $data->status }}</span>
                                                @elseif ($data->status == 'disewa')
                                                    <span
                                                        class="badge rounded-pill bg-label-primary">{{ $data->status }}</span>
                                                @elseif ($data->status == 'servis')
                                                    <span
                                                        class="badge rounded-pill bg-label-warning">{{ $data->status }}</span>
                                                @endif

                                            </td>
                                            <td>
                                                {{ $data->nomor_polisi }}
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
                                </tbody>
                            </table>
                            {{-- {{ $buku->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- tmbah modal --}}
        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <form action="{{ route('tambahMotor') }}" method="post"  enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Tambah Data Motor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col mb-3">
                                    <label for="nameBasic" class="form-label">Nama</label>
                                    <input required type="text" name="nama_motor" id="nameBasic" class="form-control"
                                        placeholder="*Beat Deluxe 2020" />
                                    @error('judul')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <strong>{{ $message }}</strong>

                                        </div>
                                    @enderror
                                </div>
                                <div class="col mb-3">
                                    <label for="exampleFormControlSelect1" class="form-label">Merek</label>
                                    <select class="form-select" name="merek" id="exampleFormControlSelect1"
                                        aria-label="Default select example">

                                        <option selected>Pilih Merek</option>
                                        @foreach ($merek as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama_merek }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="emailBasic" class="form-label">No Polisi</label>
                                    <input required type="text" id="emailBasic" name="nomer_polisi" class="form-control"
                                        placeholder="*G 3291 EXP" />
                                    @error('penerbit')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <strong>
                                                {{-- {{ $message }} --}}
                                            </strong>

                                        </div>
                                    @enderror
                                </div>
                                <div class="col mb-0">
                                    <label for="emailBasic" class="form-label">Bahan Bakar</label>
                                    <input required type="text" id="emailBasic" name="bahan_bakar" class="form-control"
                                        placeholder="*bensin" />
                                    @error('tahun')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <strong>
                                                {{-- {{ $message }} --}}
                                            </strong>

                                        </div>
                                    @enderror
                                </div>
                                <div class="row g-2">
                                    <div class="col mb-0">
                                        <label for="emailBasic" class="form-label">Harga Sewa Perhari</label>
                                        <input required type="number" id="emailBasic" name="harga"
                                            class="form-control" placeholder="*100.000" />
                                        @error('isbn')
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <strong>
                                                    {{-- {{ $message }} --}}
                                                </strong>

                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-0">
                                        <label for="emailBasic" class="form-label">Warna</label>
                                        <input required type="text" id="emailBasic" class="form-control"
                                            name="warna" placeholder="*merah" />
                                        @error('jumlah')
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <strong>
                                                    {{-- {{ $message }} --}}
                                                </strong>

                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col mb-0">
                                        <label for="exampleFormControlSelect1" class="form-label">Status</label>
                                        <select class="form-select" name="status" id="exampleFormControlSelect1"
                                            aria-label="Default select example">
                                            <option selected>--pilih --</option>
                                            <option value="tersedia">Tersedia</option>
                                            <option value="disewa">Disewa</option>
                                            <option value="servis">Servis</option>
                                        </select>
                                        @error('isbn')
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <strong>
                                                    {{-- {{ $message }} --}}
                                                </strong>

                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-0">
                                        <label for="exampleFormControlSelect1" class="form-label">Tranmisi</label>
                                        <select class="form-select" name="transmisi" id="exampleFormControlSelect1"
                                            aria-label="Default select example">
                                            <option selected>--pilih --</option>
                                            <option value="kopling">kopling</option>
                                            <option value="matic">matic</option>
                                        </select>
                                        @error('jumlah')
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <strong>
                                                    {{-- {{ $message }} --}}
                                                </strong>

                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col mb-0">
                                        <label for="formFile" class="form-label">Foto</label>
                                        <input required class="form-control" name="foto" type="file"
                                            id="formFile" />

                                        {{-- @endforeach --}}
                                        @error('kategori')
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <strong>
                                                    {{-- {{ $message }} --}}
                                                </strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @foreach ($motor as $data)
            {{-- detail modal --}}
            <div class="modal fade" id="detail{{ $data->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Detail Motor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <dl class="row mt-2 align-items-center">
                                <!-- Nama Motor -->
                                <dt class="col-md-4 text-md-end">Nama :</dt>
                                <dd class="col-md-8">{{ $data->nama_motor }}</dd>

                                <!-- Merek -->
                                <dt class="col-md-4 text-md-end">Merek :</dt>
                                <dd class="col-md-8">{{ $data->merek->nama_merek }}</dd>

                                <!-- Bahan Bakar -->
                                <dt class="col-md-4 text-md-end">Bahan Bakar :</dt>
                                <dd class="col-md-8">{{ $data->bahan_bakar }}</dd>

                                <!-- Warna -->
                                <dt class="col-md-4 text-md-end">Warna :</dt>
                                <dd class="col-md-8">{{ $data->warna }}</dd>

                                <!-- Harga Sewa per Hari -->
                                <dt class="col-md-4 text-md-end">Harga Sewa :</dt>
                                <dd class="col-md-8">Rp {{ number_format($data->harga_sewa, 0, ',', '.') }} PerHari</dd>


                                <!-- Nomor Polisi -->
                                <dt class="col-md-4 text-md-end">Nomor Polisi :</dt>
                                <dd class="col-md-8">{{ $data->nomor_polisi }}</dd>

                                <!-- Status -->
                                <dt class="col-md-4 text-md-end">Status :</dt>
                                <dd class="col-md-8">{{ $data->status }}</dd>

                                <!-- Transmisi -->
                                <dt class="col-md-4 text-md-end">Transmisi :</dt>
                                <dd class="col-md-8">{{ $data->tranmisi }}</dd>

                                <!-- Foto -->
                                <dt class="col-md-4 text-md-end">Foto :</dt>
                                <dd class="col-md-8">
                                    <img src="{{ asset('storage/' . $data->foto) }}" alt="Foto"
                                        class="img-fluid rounded" style="max-width: 200px; height: auto;">
                                </dd>
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
            <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <form action="{{ route('updateMotor', $data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Ubah Data Motor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Nama</label>
                                        <input value="{{ $data->nama_motor }}" type="text" name="nama_motor"
                                            id="nameBasic" class="form-control" placeholder="*Beat Deluxe 2020" />
                                    </div>
                                    <div class="col mb-3">
                                        <label for="exampleFormControlSelect1" class="form-label">Merek</label>
                                        <select class="form-select" name="merek" id="exampleFormControlSelect1"
                                            aria-label="Default select example">
                                            <option selected>Pilih Merek</option>
                                            @foreach ($merek as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $data->merek_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_merek }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col mb-0">
                                        <label for="emailBasic" class="form-label">No Polisi</label>
                                        <input value="{{ $data->nomor_polisi }}" type="text" id="emailBasic"
                                            name="nomer_polisi" class="form-control" placeholder="*G 3291 EXP" />
                                        @error('penerbit')
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <strong>
                                                    {{-- {{ $message }} --}}
                                                </strong>

                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-0">
                                        <label for="emailBasic" class="form-label">Bahan Bakar</label>
                                        <input value="{{ $data->bahan_bakar }}" type="text" id="emailBasic"
                                            name="bahan_bakar" class="form-control" placeholder="*bensin" />
                                        @error('tahun')
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <strong>
                                                    {{-- {{ $message }} --}}
                                                </strong>

                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row g-2">
                                        <div class="col mb-0">
                                            <label for="emailBasic" class="form-label">Harga Sewa Perhari</label>
                                            <input value="{{ $data->harga_sewa }}" type="number" id="emailBasic"
                                                name="harga" class="form-control" placeholder="*100.000" />
                                            @error('isbn')
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <strong>
                                                        {{-- {{ $message }} --}}
                                                    </strong>

                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col mb-0">
                                            <label for="emailBasic" class="form-label">Warna</label>
                                            <input value="{{ $data->warna }}" type="text" id="emailBasic"
                                                class="form-control" name="warna" placeholder="*merah" />
                                            @error('jumlah')
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <strong>
                                                        {{-- {{ $message }} --}}
                                                    </strong>

                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col mb-0">
                                            <label for="exampleFormControlSelect1" class="form-label">Status</label>
                                            <select class="form-select" name="status" id="exampleFormControlSelect1"
                                                aria-label="Default select example">
                                                {{-- <option selected>--pilih --</option> --}}
                                                <option value="tersedia"
                                                    {{ $data->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                <option value="disewa" {{ $data->status == 'disewa' ? 'selected' : '' }}>
                                                    Disewa</option>
                                                <option value="servis" {{ $data->status == 'servis' ? 'selected' : '' }}>
                                                    Servis</option>
                                            </select>
                                            @error('isbn')
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <strong>
                                                        {{-- {{ $message }} --}}
                                                    </strong>

                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col mb-0">
                                            <label for="exampleFormControlSelect1" class="form-label">Tranmisi</label>
                                            <select class="form-select" name="transmisi" id="exampleFormControlSelect1"
                                                aria-label="Default select example">
                                                {{-- <option selected>--pilih --</option> --}}
                                                <option value="kopling"
                                                    {{ $data->tranmisi == 'kopling' ? 'selected' : '' }}>kopling</option>
                                                <option value="matic" {{ $data->tranmisi == 'matic' ? 'selected' : '' }}>
                                                    matic</option>
                                            </select>
                                            @error('jumlah')
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <strong>
                                                        {{-- {{ $message }} --}}
                                                    </strong>

                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col mb-0">
                                            <label for="formFile" class="form-label">Foto</label>

                                            <!-- Tampilkan pratinjau foto yang sudah ada -->
                                            @if ($data->foto)
                                                <img src="{{ asset('storage/' . $data->foto) }}" alt="Foto Motor"
                                                    class="img-thumbnail mb-3" style="max-width: 200px;">
                                            @else
                                                <p class="text-muted">Tidak ada foto yang tersedia.</p>
                                            @endif

                                            <!-- Input untuk mengunggah foto baru -->
                                            <input class="form-control" name="foto" type="file" id="formFile" />

                                            {{-- @endforeach --}}
                                            @error('kategori')
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <strong>
                                                        {{-- {{ $message }} --}}
                                                    </strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-primary">Ubah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- delete modal --}}
            <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus Data Motor <strong>{{ $data->nama_motor }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                            <!-- Form untuk Hapus -->
                            <form action="{{ route('deleteMotor', $data->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

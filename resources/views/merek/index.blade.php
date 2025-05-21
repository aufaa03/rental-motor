@extends('layout.partials.app')
@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Motor /</span> Merek Motor</h4>

    <div class= "row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Merek Motor</h5>
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
                        <form action="{{ route('indexMerek') }}" method="GET" class="d-flex mb-3" style="width: 300px;">
                            <input type="text" name="search" class="form-control me-2" placeholder="Cari merek..." value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </form>

                    </div>

                    <div class="table-responsive text-nowrap mt-4 text-center">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Merek</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @if ($merek->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center pt-3 fs-5">Data tidak ditemukan</td>
                                    </tr>
                                @else
                                    @foreach ($merek as $data)
                                        <tr>
                                            <td><i class="fab fa-react fa-lg text-info me-2"></i>
                                                <strong>{{ $loop->iteration }}</strong>
                                            </td>
                                            <td>
                                                {{ $data->nama_merek }}
                                            </td>
                                            <td>
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
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Merek</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahMerek') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Nama Merek <span
                                        class="text-danger">*</span></label>
                                <input type="text" required id="nameBasic" class="form-control" placeholder="*Honda"
                                    name="merek" />
                                @error('merek')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <strong>{{ $message }}</strong>

                                    </div>
                                @enderror
                            </div>
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
    {{-- edit modal --}}
    @foreach ($merek as $data)
        <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Edit Merek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form action="{{ route('update', $data->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $data->id }}">

                                <div class="col mb-3">
                                    <label for="nameBasic" class="form-label">Nama Merek</label>
                                    <input type="text" id="nameBasic" name="merek" class="form-control"
                                        value="{{ $data->nama_merek }}" placeholder="Masukan Kategori" />
                                    @error('nama')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <strong>{{ $message }}</strong>

                                        </div>
                                    @enderror
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
        {{-- delete modal --}}
        <!-- Modal Konfirmasi Hapus -->
        <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus Merek <strong>{{ $data->nama_merek }}</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                        <!-- Form untuk Hapus -->
                        <form action="{{ route('delete', $data->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@extends('inc.main')

@section('page-title')
    Aspek Penilaian
@endsection

@section('breadcrumb-title')
    Aspek Penilaian
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            @if ($isBobotFull)
                                <div class="alert alert-danger" role="alert">
                                    Total bobot sudah mencapai 100%. Tidak bisa menambah data lagi.
                                </div>
                            @else
                                <div class="mb-3">
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-toggle="modal" data-target="#myModal">Tambah Data</button>
                                </div>
                            @endif

                            <!-- sample modal content -->
                            <form action="{{ route('aspek-penilaian.store') }}" method="post">
                                @csrf
                                <div id="myModal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title mt-0" id="myModalLabel">Tambah Data</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Aspek Penilaian</label>
                                                    <div>
                                                        <input type="text" class="form-control" name="aspek" required
                                                            placeholder="Masukkan nama aspek" />
                                                        @error('aspek')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Bobot (Min: 1, Max: {{ $maxBobot }})</label>
                                                    <div>
                                                        <input type="number" class="form-control" name="bobot"
                                                            min="1" max="{{ $maxBobot }}" required
                                                            placeholder="Masukkan bobot" />
                                                        @error('bobot')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </form>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Aspek Penilaian</th>
                                        <th>Bobot</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($aspek as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->aspek }}</td>
                                            <td>{{ number_format($value->bobot, 0) }}%</td>
                                            <td>
                                                <!-- Tombol untuk membuka modal -->
                                                <form action="{{ route('aspek-penilaian.update', $value->uid) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#editModal{{ $value->id }}">
                                                        <i class="far fa-edit"></i>
                                                    </button>
                                                    <!-- Modal Edit -->
                                                    <div class="modal fade" id="editModal{{ $value->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="editModalLabel{{ $value->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editModalLabel{{ $value->id }}">Edit Aspek
                                                                        Penilaian
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Form untuk mengedit aspek -->
                                                                    <div class="form-group">
                                                                        <label for="editAspek{{ $value->id }}">Aspek
                                                                            Penilaian</label>
                                                                        <input type="text" class="form-control"
                                                                            id="editAspek{{ $value->id }}"
                                                                            name="aspek" value="{{ $value->aspek }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editAspek{{ $value->id }}">Bobot
                                                                            (Min: 1, Max:
                                                                            {{ $value->maxBobotUpdate }})</label>
                                                                        <input type="number" class="form-control"
                                                                            id="editAspek{{ $value->id }}"
                                                                            name="bobot" min="1"
                                                                            max="{{ $value->maxBobotUpdate }}"
                                                                            value="{{ number_format($value->bobot, 0) }}"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan
                                                                        Perubahan</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form action="{{ route('aspek-penilaian.destroy', $value->uid) }}"
                                                    method="post" style="display: inline;">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#confirmDelete{{ $value->id }}">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                    <!-- Modal Konfirmasi Hapus -->
                                                    <div class="modal fade" id="confirmDelete{{ $value->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="confirmDeleteLabel">
                                                                        Konfirmasi Hapus</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin menghapus item ini?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-danger">Ya,
                                                                        Hapus</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- end row -->


        </div> <!-- container-fluid -->

    </div> <!-- content -->
@endsection

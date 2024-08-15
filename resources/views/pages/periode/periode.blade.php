@extends('inc.main')

@section('page-title')
    Periode Magang
@endsection

@section('breadcrumb-title')
    Periode
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal"
                                    data-target="#myModal">Tambah Data</button>
                            </div>

                            <!-- Modal Tambah Data -->
                            <form id="formPeriode" action="{{ route('periode.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div id="myModal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title mt-0" id="myModalLabel">Tambah Data Periode</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Judul Periode</label>
                                                    <input type="text" class="form-control" name="judul_periode" required />
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal Mulai</label>
                                                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" required />
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal Selesai</label>
                                                    <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" required />
                                                    <small id="error_tanggal_selesai" class="text-danger"></small>
                                                </div>
                                                <div class="form-group">
                                                    <label>Batas Pendaftaran</label>
                                                    <input type="datetime-local" class="form-control" name="batas_pendaftaran" id="batas_pendaftaran" required />
                                                    <small id="error_batas_pendaftaran" class="text-danger"></small>
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label>Tanggal Pengumuman</label>
                                                    <input type="datetime-local" class="form-control" name="tgl_pengumuman" id="tgl_pengumuman" required />
                                                    <small id="error_tgl_pengumuman" class="text-danger"></small>
                                                </div> --}}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" id="btnSubmit" class="btn btn-primary">Simpan</button>
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
                                        <th>Judul Periode</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Batas Pendaftaran</th>
                                        {{-- <th>Tanggal Pengumuman</th> --}}
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($periode as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->judul_periode }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value->tanggal_mulai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value->tanggal_selesai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value->batas_pendaftaran)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}</td>
                                            {{-- <td>{{ \Carbon\Carbon::parse($value->tgl_pengumuman)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}</td> --}}
                                            <td>
                                                <!-- Tombol untuk membuka modal -->
                                                <form action="{{ route('periode.update', $value->uid) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#editModal{{ $value->id }}">
                                                        <i class="far fa-edit"></i>
                                                    </button>
                                                    <!-- Modal Edit -->
                                                    <div class="modal fade" id="editModal{{ $value->id }}" tabindex="-1" role="dialog"
                                                        aria-labelledby="editModalLabel{{ $value->id }}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel{{ $value->id }}">Edit Periode</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Form untuk mengedit periode -->
                                                                    <div class="form-group">
                                                                        <label>Judul Periode</label>
                                                                        <input type="text" class="form-control @error('judul_periode') is-invalid @enderror"
                                                                            id="editJudulPeriode"
                                                                            name="judul_periode"
                                                                            value="{{ old('judul_periode', $value->judul_periode) }}"
                                                                            required>
                                                                        @error('judul_periode')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Tanggal Mulai</label>
                                                                        <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                                                            id="editTanggalMulai"
                                                                            name="tanggal_mulai"
                                                                            value="{{ old('tanggal_mulai', $value->tanggal_mulai) }}"
                                                                            required>
                                                                        @error('tanggal_mulai')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Tanggal Selesai</label>
                                                                        <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                                                            id="editTanggalSelesai"
                                                                            name="tanggal_selesai"
                                                                            value="{{ old('tanggal_selesai', $value->tanggal_selesai) }}"
                                                                            required>
                                                                        <small id="error_tanggal_selesai_edit" class="text-danger"></small>
                                                                        @error('tanggal_selesai')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Batas Pendaftaran</label>
                                                                        <input type="datetime-local" class="form-control @error('batas_pendaftaran') is-invalid @enderror"
                                                                            id="editBatasPendaftaran"
                                                                            name="batas_pendaftaran"
                                                                            value="{{ old('batas_pendaftaran', $value->batas_pendaftaran) }}"
                                                                            required>
                                                                        <small id="error_batas_pendaftaran_edit" class="text-danger"></small>
                                                                        @error('batas_pendaftaran')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    {{-- <div class="form-group">
                                                                        <label>Tanggal Pengumuman</label>
                                                                        <input type="datetime-local" class="form-control @error('tgl_pengumuman') is-invalid @enderror"
                                                                            id="editTglPengumuman"
                                                                            name="tgl_pengumuman"
                                                                            value="{{ old('tgl_pengumuman', $value->tgl_pengumuman) }}"
                                                                            required>
                                                                        <small id="error_tgl_pengumuman_edit" class="text-danger"></small>
                                                                        @error('tgl_pengumuman')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div> --}}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                    <button type="submit" id="btnEdit" class="btn btn-primary">Simpan Perubahan</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form action="{{ route('periode.destroy', $value->uid) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
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
    </div>
@endsection

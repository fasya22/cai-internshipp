@extends('inc.main')

@section('page-title')
    Data HRD
@endsection

@section('breadcrumb-title')
    Data HRD
@endsection

@section('content')
<style>
    .label-value {
        display: flex;
        margin-bottom: 5px;
    }

    .label-value .label {
        width: 150px;
        font-weight: bold;
    }

    .label-value .value {
        flex: 1;
    }

    .email-container {
        display: flex;
    }
</style>
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

                            <!-- sample modal content -->
                            <form action="{{ route('hrd.store') }}" method="post" enctype="multipart/form-data">
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
                                                    <label>Nama</label>
                                                    <div>
                                                        <input type="text"
                                                            class="form-control @error('nama') is-invalid @enderror"
                                                            name="nama" data-parsley-pattern="^[a-zA-Z\s\-]+$" required
                                                            placeholder="" />
                                                        @error('nama')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis Kelamin</label>
                                                    <div>
                                                        <select name="jenis_kelamin" class="form-control" required>
                                                            <option value="">Pilih salah satu</option>
                                                            <option value="1">Laki-laki</option>
                                                            <option value="2">Perempuan</option>
                                                        </select>
                                                        @error('jenis_kelamin')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Level</label>
                                                    <div>
                                                        <select name="level" class="form-control" required>
                                                            <option value="">Pilih salah satu</option>
                                                            <option value="1">Junior</option>
                                                            <option value="2">Intermediate</option>
                                                            <option value="3">Senior</option>
                                                        </select>
                                                        @error('level')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="form-control">Email</label>
                                                    <input type="email" class="form-control" name="email" required>
                                                    @if ($errors->has('email'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('email') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" required data-parsley-minlength="8"
                                                        placeholder="Min 8 chars.">
                                                    @if ($errors->has('password'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('password') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <label for="foto" class="form-label">Foto</label>
                                                    <input type="file"
                                                        class="form-control filestyle @error('foto') is-invalid @enderror"
                                                        id="image" name="foto" data-buttonname="btn-secondary"
                                                        data-parsley-fileaccept="image/jpeg, image/png, image/jpg"
                                                        data-parsley-max-file-size="2048" accept=".jpg, .jpeg, .png">
                                                    <small class="form-text text-muted">File JPG, JPEG,
                                                        atau PNG maksimal 2MB.</small>
                                                    <div id="fileError" class="invalid-feedback"></div>
                                                    @error('foto')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
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
                                        <th data-priority="1">No</th>
                                        <th data-priority="1">Nama</th>
                                        <th data-priority="2">Level</th>
                                        <th data-priority="1">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($hrd as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    {{-- <img src="/Image/{{ $value->image }}" style="width: 30px; height: 30px; margin-right: 10px;" class="img-thumbnail" alt="Image-{{ $value->nama }}"> --}}
                                                    <span>{{ $value->nama }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($value->level == 1)
                                                    <span>Junior</span>
                                                @elseif($value->level == 2)
                                                    <span>Intermediate</span>
                                                @else
                                                    <span>Senior</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('hrd.index', $value->uid) }}"
                                                    style="display: inline;">
                                                    @csrf
                                                    <!-- Tombol untuk menampilkan modal show -->
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal"
                                                        data-target="#showModal{{ $value->id }}">
                                                        <i class="far fa-eye"></i>
                                                    </button>

                                                    <!-- Modal Show Detail -->
                                                    <div class="modal fade bs-example-modal-lg"
                                                        id="showModal{{ $value->id }}" tabindex="-1" role="dialog"
                                                        aria-labelledby="showModalLabel{{ $value->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="showModalLabel{{ $value->id }}">Detail
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-12 email-container">
                                                                            <div class="email-leftbar">
                                                                                <div class="mb-3 text-center">
                                                                                    <!-- Tampilkan foto profil peserta -->
                                                                                    @if ($hrd && $value->image)
                                                                                        <img class=""
                                                                                            src="{{ asset('storage/images/' . $hrd->image) }}"
                                                                                            alt="Profil Picture"
                                                                                            style="width: 150px; height: 150px; border: 2px solid #ccc; padding: 4px;">
                                                                                    @else
                                                                                        <img class=""
                                                                                            src="{{ asset('admin/images/users/user.png') }}"
                                                                                            alt="Default Profil Picture"
                                                                                            style="width: 150px; height: 150px; border: 2px solid #ccc; padding: 4px;">
                                                                                        {{-- <img class="rounded-circle" src="{{ asset('admin/images/users/user.png') }}" alt="Default Profil Picture" style="width: 150px; height: 150px;"> --}}
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="email-rightbar">

                                                                                <div class="card-body">
                                                                                    <div class="label-value">
                                                                                        <span class="label">Nama</span>
                                                                                        <span class="value"
                                                                                            style="text-transform: capitalize">:
                                                                                            {{ $value->nama ?? '-' }}</span>
                                                                                    </div>
                                                                                    <div class="label-value">
                                                                                        <span class="label">Level</span>
                                                                                        <span class="value">:
                                                                                            @if ($value->level == 1)
                                                                                                <span>Junior</span>
                                                                                            @elseif($value->level == 2)
                                                                                                <span>Intermediate</span>
                                                                                            @else
                                                                                                <span>Senior</span>
                                                                                            @endif
                                                                                        </span>
                                                                                    </div>
                                                                                    <div class="label-value">
                                                                                        <span class="label">Email</span>
                                                                                        <span class="value">:
                                                                                            {{ $value->user->email ?? '-' }}</span>
                                                                                    </div>
                                                                                    <div class="label-value">
                                                                                        <span class="label">Jenis
                                                                                            Kelamin</span>
                                                                                        <span class="value">:
                                                                                            @if ($value->jenis_kelamin == 1)
                                                                                                Laki-laki
                                                                                            @elseif($value->jenis_kelamin == 2)
                                                                                                Perempuan
                                                                                            @else
                                                                                                -
                                                                                            @endif
                                                                                        </span>
                                                                                    </div>
                                                                                    {{-- <div class="label-value">
                                                                            <span class="label">No HP</span>
                                                                            <span class="value">:
                                                                                {{ $value->no_hp ?? '-' }}</span>
                                                                        </div>
                                                                        <div class="label-value">
                                                                            <span class="label">Alamat</span>
                                                                            <span class="value">:
                                                                                {{ $value->alamat ?? '-' }}</span>
                                                                        </div>
                                                                        <div class="label-value">
                                                                            <span class="label">Pendidikan
                                                                                Terakhir</span>
                                                                            <span class="value">:
                                                                                {{ $value->pendidikan_terakhir ?? '-' }}</span>
                                                                        </div>
                                                                        <div class="label-value">
                                                                            <span class="label">Institusi Pendidikan
                                                                                Terakhir</span>
                                                                            <span class="value"
                                                                                style="text-transform: capitalize">:
                                                                                {{ $value->institusi_pendidikan_terakhir ?? '-' }}</span>
                                                                        </div> --}}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- Tombol untuk membuka modal -->
                                                <form action="{{ route('hrd.update', $value->uid) }}" method="POST"
                                                    enctype="multipart/form-data" style="display: inline;">
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
                                                                        id="editModalLabel{{ $value->id }}">Edit HRD
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="editHRD{{ $value->id }}">Nama</label>
                                                                        <input type="text" class="form-control"
                                                                            id="editHRD{{ $value->id }}"
                                                                            name="nama" value="{{ $value->nama }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Jenis Kelamin</label>
                                                                        <select name="jenis_kelamin" class="form-control"
                                                                            required>
                                                                            <option value="">Pilih salah satu
                                                                            </option>
                                                                            @if ($value->jenis_kelamin == 1)
                                                                                <option value="1" selected>Laki-laki
                                                                                </option>
                                                                                <option value="2">Perempuan</option>
                                                                            @else
                                                                                <option value="1">Laki-laki</option>
                                                                                <option value="2" selected>Perempuan
                                                                                </option>
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Level</label>
                                                                        <select name="level" class="form-control"
                                                                            required>
                                                                            <option value="">Pilih salah satu
                                                                            </option>
                                                                            @if ($value->level == 1)
                                                                                <option value="1" selected>
                                                                                    Junior</option>
                                                                                <option value="2">Intermediate
                                                                                </option>
                                                                                <option value="3">Senior
                                                                                </option>
                                                                            @elseif($value->level == 2)
                                                                                <option value="1">Junior
                                                                                </option>
                                                                                <option value="2" selected>
                                                                                    Intermediate</option>
                                                                                <option value="3">Senior
                                                                                </option>
                                                                            @else
                                                                                <option value="1">Junior
                                                                                </option>
                                                                                <option value="2">Intermediate
                                                                                </option>
                                                                                <option value="3" selected>
                                                                                    Senior</option>
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="email">Email</label>
                                                                        <input type="email"
                                                                            class="form-control @error('email') is-invalid @enderror"
                                                                            id="email" name="email"
                                                                            value="{{ old('email', $value->user->email) }}"
                                                                            parsley-type="email" required>
                                                                        @error('email')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="password">Password</label>
                                                                        <input type="password" class="form-control"
                                                                            id="password" name="password"
                                                                            data-parsley-minlength="8"
                                                                            placeholder="Min 8 chars.">
                                                                        <small id="passwordHelp"
                                                                            class="form-text text-muted">Kosongkan jika
                                                                            tidak ingin
                                                                            mengubah password.</small>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Foto</label>
                                                                        {{-- <input type="file" class="form-control filestyle @error('foto') is-invalid @enderror" id="image" name="foto" data-buttonname="btn-secondary" data-parsley-fileaccept="image/jpeg, image/png, image/jpg" data-parsley-max-file-size="2048" accept=".jpg, .jpeg, .png" required>
                                                                        <small class="form-text text-muted">File JPG, JPEG,
                                                                            atau PNG maksimal 2MB.</small>
                                                                        @error('foto')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror --}}
                                                                        <input type="file"
                                                                            class="form-control filestyle @error('foto') is-invalid @enderror"
                                                                            id="editimage" name="foto"
                                                                            data-buttonname="btn-secondary"
                                                                            data-parsley-fileaccept="image/jpeg, image/png, image/jpg"
                                                                            data-parsley-max-file-size="2048"
                                                                            accept=".jpg, .jpeg, .png">
                                                                        <small class="form-text text-muted">File JPG, JPEG,
                                                                            atau PNG maksimal 2MB.</small>
                                                                        <div id="fileErrorEdit" class="invalid-feedback">
                                                                        </div>
                                                                        @error('foto')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror

                                                                        <div
                                                                            class="d-flex align-items-center justify-content-center mt-3">
                                                                            @if ($value->image)
                                                                                <img src="{{ asset('images/' . $value->image) }}"
                                                                                    alt="Image-{{ $value->nama }}"
                                                                                    style="width: 150px; height: 150px; border: 2px solid #ccc; padding: 4px;">
                                                                            @else
                                                                                <img src="{{ asset('admin/images/users/user.png') }}"
                                                                                    alt="Default Profil Picture"
                                                                                    style="width: 150px; height: 150px; border: 2px solid #ccc; padding: 4px;">
                                                                            @endif
                                                                        </div>
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
                                                <form action="{{ route('hrd.destroy', $value->uid) }}" method="post"
                                                    style="display: inline;">
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

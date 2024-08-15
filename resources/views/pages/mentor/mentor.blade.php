@extends('inc.main')

@section('page-title')
    Data Mentor
@endsection

@section('breadcrumb-title')
    Data Mentor
@endsection

@section('content')
    <style>
        .label-value {
            display: flex;
            margin-bottom: 5px;
        }

        .label-value .label {
            width: 200px;
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
                    <form action="{{ route('mentor.index') }}" method="GET">
                        <div class="row mb-3">
                            <div class="col-md-3 mb-3">
                                <label for="posisi">Posisi:</label>
                                <select class="form-control" id="posisi" name="posisi">
                                    <option value="">Semua Posisi</option>
                                    @foreach ($posisi as $item)
                                        <option value="{{ $item->id }}"
                                            {{ request('posisi') == $item->id ? 'selected' : '' }}>
                                            {{ $item->posisi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="periode">Periode:</label>
                                <select class="form-control" id="periode" name="periode">
                                    <option value="">Semua Periode</option>
                                    @foreach ($periode as $item)
                                        <option value="{{ $item->id }}"
                                            {{ request('periode') == $item->id ? 'selected' : '' }}>
                                            {{ $item->judul_periode }}
                                            ({{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('j F Y') }} -
                                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('j F Y') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="level">Level:</label>
                                <select class="form-control" id="level" name="level">
                                    <option value="">Semua Level</option>
                                    <option value="1" {{ request('level') == '1' ? 'selected' : '' }}>Junior</option>
                                    <option value="2" {{ request('level') == '2' ? 'selected' : '' }}>Intermediate
                                    </option>
                                    <option value="3" {{ request('level') == '3' ? 'selected' : '' }}>Senior</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control">Filter</button>
                            </div>
                        </div>
                    </form>

                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal"
                                    data-target="#myModal">Tambah Data</button>
                            </div>

                            <!-- sample modal content -->
                            <form action="{{ route('mentor.store') }}" method="post" enctype="multipart/form-data">
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
                                                    <label>Posisi</label>
                                                    <select name="posisi" class="form-control" required>
                                                        <option value="">Pilih salah satu</option>
                                                        @foreach ($posisi as $key => $value)
                                                            <option value="{{ $value->id }}">{{ $value->posisi }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                                                {{-- <div class="form-group">
                                                    <label for="form-control">Username</label>
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" required>
                                                    @if ($errors->has('username'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('username') }}
                                                        </div>
                                                    @endif
                                                </div> --}}
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
                            <table id="datatable-buttons-example"
                                class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th data-priority="1">No</th>
                                        <th data-priority="1">Nama</th>
                                        <th data-priority="2">Posisi</th>
                                        <th data-priority="2">Level</th>
                                        <th data-priority="1">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($mentor as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    {{-- <img src="/Image/{{ $value->image }}" style="width: 30px; height: 30px; margin-right: 10px;" class="img-thumbnail" alt="Image-{{ $value->nama }}"> --}}
                                                    <span>{{ $value->nama }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($value->posisi == null)
                                                    <span class="badge badge-warning">Posisi belum ditentukan</span>
                                                @else
                                                    <span class="">{{ $value->posisi }}</span>
                                                @endif
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
                                                <!-- Tombol untuk membuka modal -->
                                                <form action="{{ route('mentor.index', $value->uid) }}"
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
                                                                                    @if ($mentor && $value->image)
                                                                                        <img class=""
                                                                                            src="{{ asset('storage/images/' . $value->image) }}"
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
                                                                                        <span class="label">Posisi</span>
                                                                                        <span class="value"
                                                                                            style="text-transform: capitalize">:
                                                                                            {{ $value->posisi ?? '-' }}</span>
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
                                                <form action="{{ route('mentor.update', $value->uid) }}" method="POST"
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
                                                                        id="editModalLabel{{ $value->id }}">Edit Mentor
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="editMentor{{ $value->id }}">Nama</label>
                                                                        <input type="text"
                                                                            class="form-control @error('nama') is-invalid @enderror"
                                                                            id="editMentor{{ $value->id }}"
                                                                            name="nama" value="{{ $value->nama }}"
                                                                            required
                                                                            data-parsley-pattern="^[a-zA-Z\s\-]+$">
                                                                        @error('nama')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
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
                                                                        @error('jenis_kelamin')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Posisi</label>
                                                                        <select name="posisi" class="form-control"
                                                                            required>
                                                                            <option value="">Pilih salah satu
                                                                            </option>
                                                                            @foreach ($posisi as $key => $posisi_value)
                                                                                @if ($value->posisi_id == $posisi_value->id)
                                                                                    <option
                                                                                        value="{{ $posisi_value->id }}"
                                                                                        selected>
                                                                                        {{ $posisi_value->posisi }}
                                                                                    </option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{ $posisi_value->id }}">
                                                                                        {{ $posisi_value->posisi }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        @error('posisi')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
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
                                                                    <button type="submit" class="btn btn-primary"
                                                                        id="submitBtn">Simpan
                                                                        Perubahan</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form action="{{ route('mentor.destroy', $value->uid) }}" method="post"
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

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<!-- DataTables Buttons JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/3.1.0/js/dataTables.buttons.js">
</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.dataTables.js">
</script>
<!-- JSZip -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<!-- pdfmake -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<!-- Buttons for Excel and PDF export -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.html5.min.js">
</script>

<script>
    $(document).ready(function() {
        var posisiText = $('#posisi option:selected').text();
        var periodeText = $('#periode option:selected').text();
        var levelText = $('#level option:selected').text(); // Ambil teks dari dropdown level

        // Buat title berdasarkan nilai filter
        var titleText = 'Daftar Mentor\n';
        if (periodeText !== 'Semua Periode') {
            titleText += ' Periode ' + periodeText;
        }
        if (posisiText !== 'Semua Posisi') {
            titleText += ' Posisi ' + posisiText;
        }
        if (levelText !== 'Semua Level') { // Pastikan level juga diperiksa
            titleText += ' Level ' + levelText;
        }

        $('#datatable-buttons-example').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    text: 'Copy to clipboard',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: 'Export-Mentor',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: 'Export-Mentor',
                    title: 'Data Export',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdf',
                    text: 'Export to PDF',
                    filename: 'Export-Mentor',
                    title: titleText,
                    customize: function(doc) {
                        // Set title alignment and size
                        doc.styles.title = {
                            alignment: 'center',
                            fontSize: 12
                        };

                        // Mengatur layout konten agar tidak terpotong
                        var objLayout = {
                            hLineWidth: function(i) {
                                return .5;
                            },
                            vLineWidth: function(i) {
                                return .5;
                            },
                            hLineColor: function(i) {
                                return '#aaa';
                            },
                            vLineColor: function(i) {
                                return '#aaa';
                            },
                            paddingLeft: function(i) {
                                return 4;
                            },
                            paddingRight: function(i) {
                                return 4;
                            },
                            paddingTop: function(i) {
                                return 4;
                            },
                            paddingBottom: function(i) {
                                return 4;
                            }
                        };
                        doc.content[1].layout = objLayout;

                        // Set column widths
                        var colCount = doc.content[1].table.body[0].length;
                        doc.content[1].table.widths = [];
                        for (var i = 0; i < colCount; i++) {
                            doc.content[1].table.widths.push('*');
                        }

                        // Custom page size and margins
                        doc.pageSize = 'A4';
                        doc.pageMargins = [20, 60, 20, 40]; // Adjust margins if needed

                        // Handle title overflow
                        doc.content[0].text = titleText;
                        doc.content[0].alignment = 'center';
                        doc.content[0].fontSize = 12; // Adjust font size if needed
                        doc.content[0].margin = [0, 10, 0, 20]; // Adjust margins to fit title
                    },
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }

                }
                // Uncomment and adjust if you need the print button
                // {
                //     extend: 'print',
                //     text: 'Print table',
                //     exportOptions: {
                //         columns: ':not(:last-child)'
                //     }
                // }
            ]
        });
    });
</script>

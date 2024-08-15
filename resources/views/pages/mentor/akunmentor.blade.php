@extends('inc.main')

@section('page-title')
    Akun Mentor
@endsection

@section('breadcrumb-title')
    Akun Mentor
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

                            <!-- sample modal content -->
                            <form action="{{ route('user-mentor.store') }}" method="post" enctype="multipart/form-data">
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
                                                    <label for="form-control">Nama</label>
                                                    <select class="form-control" name="mentor" onchange="getnamementor()"
                                                        required>
                                                        <option value="">Pilih salah satu</option>
                                                        @foreach ($mentor as $key => $value)
                                                            <option value="{{ $value }}"><b>{{ $value->nama }}</b>
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('mentor'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('mentor') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="form-control">Username</label>
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" required>
                                                    @if ($errors->has('username'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('username') }}
                                                        </div>
                                                    @endif
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
                                                        name="password" required data-parsley-minlength="8" placeholder="Min 8 chars.">
                                                    @if ($errors->has('password'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('password') }}
                                                        </div>
                                                    @endif
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
                                        <th>Nama</th>
                                        {{-- <th>Username</th> --}}
                                        <th>Email</th>
                                        <th>Status Verifikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($user_mntr as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->mentor['nama'] }}</td>
                                            {{-- <td>{{ $value->name }}</td> --}}
                                            <td>{{ $value->email }}</td>
                                            <td>
                                                @if (is_null($value->email_verified_at))
                                                    Belum Verified
                                                @else
                                                    Verified
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Tombol untuk membuka modal -->
                                                <form action="{{ route('user-mentor.update', $value->uid) }}"
                                                    method="POST" enctype="multipart/form-data" style="display: inline;">
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
                                                                        id="editModalLabel{{ $value->id }}">Edit Akun
                                                                        Mentor</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Form untuk mengedit posisi -->
                                                                    <div class="form-group">
                                                                        <label for="mentor">Mentor</label>
                                                                        <input type="text" class="form-control" id="mentor" name="mentor" value="{{ $value->mentor['nama'] }}" readonly>
                                                                        <input type="hidden" name="mentor_uid" value="{{ $value->mentor['uid'] }}">
                                                                        @if ($errors->has('mentor'))
                                                                            <div class="error" style="color: red; display:block;">
                                                                                {{ $errors->first('mentor') }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="username">Username</label>
                                                                        <input type="text" class="form-control"
                                                                            id="username" name="username"
                                                                            value="{{ $value->name }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="email">Email</label>
                                                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                                                            value="{{ old('email', $value->email) }}" parsley-type="email" required>
                                                                        @error('email')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="password">Password</label>
                                                                        <input type="password" class="form-control"
                                                                            id="password" name="password" data-parsley-minlength="8" placeholder="Min 8 chars.">
                                                                            <small id="passwordHelp" class="form-text text-muted">Kosongkan jika tidak ingin
                                                                                mengubah password.</small>
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

                                                <form action="{{ route('user-mentor.destroy', $value->uid) }}"
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

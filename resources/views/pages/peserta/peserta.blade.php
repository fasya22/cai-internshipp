@extends('inc.main')

@section('content')

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Peserta</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                            {{-- <li class="breadcrumb-item"><a href="javascript:void(0);">Master Data</a></li> --}}
                            <li class="breadcrumb-item active">Peserta</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Posisi</th>
                                        <th>Mentor</th>
                                        @IsAdmin
                                        <th>Aksi</th>
                                        @endIsAdmin
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($peserta as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->nama }}</td>
                                            {{-- <td>
                                                @if ($value->nama)
                                                    {{ $value->nama }}
                                                @else
                                                    <span class="badge badge-warning">Nama belum ditentukan</span>
                                                @endif
                                            </td> --}}
                                            {{-- <td>
                                                @if ($value->alamat)
                                                    {{ $value->alamat }}
                                                @else
                                                    <span class="badge badge-warning">Alamat belum ditentukan</span>
                                                @endif
                                            </td>
                                            <td>{{ $value->user['name'] }}</td> --}}
                                            <td>{{ $value->user['email'] }}</td>
                                            <td>
                                                @if ($value->posisi)
                                                    {{ $value->posisi }}
                                                @else
                                                    <span class="badge badge-warning">Posisi belum ditentukan</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->mentor)
                                                    {{ $value->mentor }}
                                                @else
                                                    <span class="badge badge-warning">Mentor belum ditentukan</span>
                                                @endif
                                            </td>
                                            @IsAdmin
                                            <td>
                                                <!-- Tombol untuk membuka modal -->
                                                <form action="{{ route('peserta.update', $value->uid) }}" method="POST"
                                                    enctype="multipart/form-data" style="display: inline;">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Tombol untuk membuka modal -->
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#editModal{{ $value->id }}">
                                                        <i class="far fa-edit"></i>
                                                    </button>

                                                    <!-- Modal Edit -->
                                                    <div class="modal fade" id="editModal{{ $value->id }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="editModalLabel{{ $value->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editModalLabel{{ $value->id }}">Edit Peserta
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Form untuk mengedit peserta -->
                                                                    <form
                                                                        action="{{ route('peserta.update', $value->uid) }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="form-group">
                                                                            <label for="nama">Nama</label>
                                                                            <input type="text" class="form-control"
                                                                                id="nama" name="nama"
                                                                                value="{{ $value->nama }}" disabled>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                                                            <select name="jenis_kelamin" id="jenis_kelamin"
                                                                                class="form-control" disabled>
                                                                                <option value="1"
                                                                                    {{ $value->jenis_kelamin == 1 ? 'selected' : '' }}>
                                                                                    Laki-laki</option>
                                                                                <option value="2"
                                                                                    {{ $value->jenis_kelamin == 2 ? 'selected' : '' }}>
                                                                                    Perempuan</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="alamat">Alamat</label>
                                                                            <textarea class="form-control" id="alamat" name="alamat" rows="3" disabled>{{ $value->alamat }}</textarea>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="posisi{{ $value->id }}">Posisi</label>
                                                                            <select name="posisi" id="posisi{{ $value->id }}" class="form-control" readonly>
                                                                                @foreach ($posisi as $pos)
                                                                                    <option value="{{ $pos->id }}" {{ $value->posisi_id == $pos->id ? 'selected' : '' }}>
                                                                                        {{ $pos->posisi }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="mentor{{ $value->id }}">Mentor</label>
                                                                            <select name="mentor" id="mentor{{ $value->id }}" class="form-control">
                                                                                @foreach ($mentor as $mentors)
                                                                                    @if ($mentors->posisi_id == $value->posisi_id)
                                                                                        <option value="{{ $mentors->id }}" {{ $mentors->id == $value->mentor_id ? 'selected' : '' }}>
                                                                                            {{ $mentors->nama }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        {{-- <div class="form-group">
                                                                            <label for="posisi_{{ $value->id }}">Posisi</label>
                                                                            <select name="posisi" id="posisi_{{ $value->id }}" class="form-control">
                                                                                @foreach ($posisi as $pos)
                                                                                    <option value="{{ $pos->id }}"
                                                                                        {{ $value->posisi_id == $pos->id ? 'selected' : '' }}>
                                                                                        {{ $pos->posisi }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="mentor_{{ $value->id }}">Mentor</label>
                                                                            <select name="mentor" id="mentor_{{ $value->id }}" class="form-control">
                                                                                <!-- Ini akan diisi secara dinamis dengan JavaScript -->
                                                                            </select>
                                                                        </div> --}}

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

                                                <form action="{{ route('peserta.destroy', $value->uid) }}" method="post"
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
                                            @endIsAdmin
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

    {{-- <script>
        // Mendengarkan perubahan pada dropdown posisi
        document.querySelectorAll('[id^="posisi_"]').forEach(function(element) {
            element.addEventListener('change', function() {
                var posisiId = this.value; // Mengambil nilai id posisi yang dipilih
                var pesertaId = this.id.split('_')[1]; // Mengambil id peserta dari id dropdown posisi

                var mentorDropdown = document.getElementById('mentor_' + pesertaId);

                // Mengosongkan dropdown mentor
                mentorDropdown.innerHTML = '';

                // Mengambil mentor yang sesuai dengan posisi yang dipilih
                var mentors = {!! $mentor->toJson() !!};
                var filteredMentors = mentors.filter(function(mentor) {
                    return mentor.posisi_id == posisiId;
                });

                // Menambahkan opsi untuk setiap mentor yang sesuai dengan posisi
                filteredMentors.forEach(function(mentor) {
                    var option = document.createElement('option');
                    option.value = mentor.id;
                    option.text = mentor.nama;
                    mentorDropdown.appendChild(option);
                });
            });
        });

        // Memanggil event change pada setiap dropdown posisi saat halaman pertama kali dimuat
        document.querySelectorAll('[id^="posisi_"]').forEach(function(element) {
            element.dispatchEvent(new Event('change'));
        });
    </script> --}}

@endsection

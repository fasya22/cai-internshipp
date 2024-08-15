@extends('inc.main')

@section('page-title')
    Lowongan
@endsection

@section('breadcrumb-title')
    Lowongan
@endsection

@section('content')
    {{-- <style>
        .elm {
            overflow-wrap: break-word;
            word-break: break-word;
        }
    </style> --}}
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
                            <form action="{{ route('lowongan.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title mt-0" id="myLargeModalLabel">Tambah Data</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
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
                                                    <label>Periode</label>
                                                    <select name="periode" class="form-control" required>
                                                        <option value="">Pilih salah satu</option>
                                                        @foreach ($periode as $key => $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->judul_periode }}
                                                                ({{ \Carbon\Carbon::parse($value->tanggal_mulai)->translatedFormat('j F Y') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($value->tanggal_selesai)->translatedFormat('j F Y') }})
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div>
                                                        <select name="metode" class="form-control" required>
                                                            <option value="">Pilih salah satu</option>
                                                            <option value="1">Remote</option>
                                                            <option value="2">Onsite</option>
                                                            <option value="3">Hybrid</option>
                                                        </select>
                                                        @error('metode')
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
                                                    <label>Deskripsi</label>
                                                    <div>
                                                        <textarea id="deskripsi" name="deskripsi" required></textarea>
                                                        @error('deskripsi')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kualifikasi</label>
                                                    <div>
                                                        <textarea id="kualifikasi" name="kualifikasi" required></textarea>
                                                        @error('kualifikasi')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Keahlian yang Dibutuhkan</label>
                                                    <div id="keahlian-container">
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="keahlian_yang_dibutuhkan[]"
                                                                class="form-control" placeholder="Keahlian" required>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-danger" type="button"
                                                                    onclick="removeKeahlian(this)">-</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-success mb-2" type="button"
                                                        onclick="addKeahlian()">
                                                        <i class="fas fa-plus"></i> Tambah Keahlian
                                                    </button>
                                                    @error('keahlian_yang_dibutuhkan')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input type="hidden" name="requires_english" value="0">
                                                        <input type="checkbox" id="requires_english" name="requires_english" class="form-check-input" value="1">
                                                        <label for="requires_english" class="form-check-label">Wajib Bahasa Inggris</label>
                                                        @error('requires_english')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Kuota Magang</label>
                                                    <input type="number" class="form-control" name="kuota" required />
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
                                {{-- <table id="tech-companies-1" class="table  table-striped"> --}}
                                <thead>
                                    <tr>
                                        <th data-priority="1">No</th>
                                        <th data-priority="1">Posisi</th>
                                        <th data-priority="2">Periode</th>
                                        <th data-priority="2">Level</th>
                                        <th data-priority="3">Kemampuan Bahasa Inggris</th>
                                        <th data-priority="1">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($lowongan as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->posisi['posisi'] }}</td>
                                            <td>{{ $value->periode['judul_periode'] }}
                                                {{-- (
                                                {{ strftime('%e %B %Y', strtotime($value->periode['tanggal_mulai'])) }}
                                                -
                                                {{ strftime('%e %B %Y', strtotime($value->periode['tanggal_selesai'])) }}) --}}
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
                                                {{ $value->requires_english ? 'Ya' : 'Tidak' }}
                                            </td>
                                            <td>
                                                <!-- Tombol untuk membuka modal -->
                                                <form action="{{ route('list-pendaftar.index', $value->uid) }}"
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
                                                                        Lowongan
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered mb-0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><strong>Posisi</strong></td>
                                                                                    <td>{{ $value->posisi['posisi'] ?? '-' }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><strong>Periode</strong></td>
                                                                                    <td>
                                                                                        {{ $value->periode['judul_periode'] }}
                                                                                        ({{ \Carbon\Carbon::parse($value->periode['tanggal_mulai'])->translatedFormat('j F Y') }}
                                                                                        -
                                                                                        {{ \Carbon\Carbon::parse($value->periode['tanggal_selesai'])->translatedFormat('j F Y') }})
                                                                                    </td>

                                                                                </tr>
                                                                                <tr>
                                                                                    <td><strong>Metode</strong></td>
                                                                                    <td>
                                                                                        @if ($value->metode == 1)
                                                                                            <span>Remote</span>
                                                                                        @elseif($value->metode == 2)
                                                                                            <span>Onsite</span>
                                                                                        @else
                                                                                            <span>Hybrid</span>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><strong>Level</strong></td>
                                                                                    <td>
                                                                                        @if ($value->level == 1)
                                                                                            <span>Junior</span>
                                                                                        @elseif($value->level == 2)
                                                                                            <span>Intermediate</span>
                                                                                        @else
                                                                                            <span>Senior</span>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><strong>Deskripsi</strong></td>
                                                                                    <td style="padding-right: 10px;">
                                                                                        {!! $value->deskripsi !!}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><strong>Kualifikasi</strong></td>
                                                                                    <td>{!! $value->kualifikasi !!}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><strong>Keahlian Yang
                                                                                            Dibutuhkan</strong></td>
                                                                                    <td>
                                                                                        <ul>
                                                                                            @foreach (json_decode($value->keahlian_yang_dibutuhkan) as $keahlian)
                                                                                                <li>{{ $keahlian }}
                                                                                                </li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </td>
                                                                                </tr>
                                                                                {{-- <tr>
                                                                                    <td><strong>Batas Pendaftaran</strong>
                                                                                    </td>
                                                                                    <td>{{ \Carbon\Carbon::parse($value->batas_pendaftaran)->translatedFormat('l, j F Y') }}
                                                                                    </td>
                                                                                </tr> --}}
                                                                            </tbody>
                                                                        </table>
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
                                                <form action="{{ route('lowongan.update', $value->uid) }}" method="POST"
                                                    enctype="multipart/form-data" style="display: inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#editModal{{ $value->id }}">
                                                        <i class="far fa-edit"></i>
                                                    </button>
                                                    <!-- Modal Edit -->
                                                    <div class="modal fade bs-example-modal-lg"
                                                        id="editModal{{ $value->id }}" tabindex="-1" role="dialog"
                                                        aria-labelledby="editLargeModalLabel{{ $value->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editLargeModalLabel{{ $value->id }}">
                                                                        Edit Lowongan
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label>Posisi</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $value->posisi->posisi }}" disabled>
                                                                        <input type="hidden" name="posisi"
                                                                            value="{{ $value->posisi_id }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Periode</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $value->periode->judul_periode }} ({{ \Carbon\Carbon::parse($value->periode->tanggal_mulai)->translatedFormat('j F Y') }} - {{ \Carbon\Carbon::parse($value->periode->tanggal_selesai)->translatedFormat('j F Y') }})"
                                                                            disabled>
                                                                        <input type="hidden" name="periode"
                                                                            value="{{ $value->periode_id }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Metode</label>
                                                                        <select name="metode" class="form-control"
                                                                            required>
                                                                            <option value="">Pilih salah satu
                                                                            </option>
                                                                            @if ($value->metode == 1)
                                                                                <option value="1" selected>
                                                                                    Remote</option>
                                                                                <option value="2">Onsite
                                                                                </option>
                                                                                <option value="3">Hybrid
                                                                                </option>
                                                                            @elseif($value->metode == 2)
                                                                                <option value="1">Remote
                                                                                </option>
                                                                                <option value="2" selected>
                                                                                    Onsite</option>
                                                                                <option value="3">Hybrid
                                                                                </option>
                                                                            @else
                                                                                <option value="1">Remote
                                                                                </option>
                                                                                <option value="2">Onsite
                                                                                </option>
                                                                                <option value="3" selected>
                                                                                    Hybrid</option>
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
                                                                        <label>Deskripsi</label>
                                                                        <textarea id="deskripsi" required name="deskripsi">{{ $value->deskripsi }}</textarea>
                                                                        @error('deskripsi')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Kualifikasi</label>
                                                                        <textarea id="kualifikasi" required name="kualifikasi">{{ $value->kualifikasi }}</textarea>
                                                                        @error('deskripsi')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Keahlian yang Dibutuhkan</label>
                                                                        <div id="keahlian-container-edit">
                                                                            @foreach (json_decode($value->keahlian_yang_dibutuhkan) as $keahlian)
                                                                                <div class="input-group mb-2">
                                                                                    <input type="text"
                                                                                        name="keahlian_yang_dibutuhkan[]"
                                                                                        class="form-control"
                                                                                        value="{{ $keahlian }}"
                                                                                        required>
                                                                                    <div class="input-group-append-edit">
                                                                                        <button class="btn btn-danger"
                                                                                            type="button"
                                                                                            onclick="removeKeahlianEdit(this)">-</button>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                        <button class="btnedit btn btn-success mb-2"
                                                                            type="button" onclick="addKeahlianEdit()">
                                                                            <i class="fas fa-plus"></i> Tambah Keahlian
                                                                        </button>
                                                                        @error('keahlian_yang_dibutuhkan')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="form-check">
                                                                            <input type="hidden" name="requires_english" value="0">
                                                                            <input type="checkbox" id="requires_english"
                                                                                   name="requires_english"
                                                                                   class="form-check-input"
                                                                                   value="1"
                                                                                   {{ old('requires_english', $value->requires_english) ? 'checked' : '' }}>
                                                                            <label for="requires_english" class="form-check-label">Wajib Bahasa Inggris</label>
                                                                            @error('requires_english')
                                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Kuota Magang</label>
                                                                        <div>
                                                                        <input type="number" class="form-control @error('kuota') is-invalid @enderror"
                                                                            name="kuota"
                                                                            value="{{ $value->kuota }}"
                                                                            required>
                                                                        @error('kuota')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
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
                                                <form action="{{ route('lowongan.destroy', $value->uid) }}"
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('select[name="posisi"]').on('change', function() {
                var posisiId = $(this).val();
                var periodeSelect = $('select[name="periode"]');

                $.ajax({
                    url: '/get-available-periodes/' + posisiId,
                    type: 'GET',
                    success: function(response) {
                        periodeSelect.empty();
                        if (response.length > 0) {
                            $.each(response, function(key, value) {
                                let displayText = value.judul_periode + ' (' + value
                                    .tanggal_mulai + ' - ' + value.tanggal_selesai +
                                    ')';
                                periodeSelect.append('<option value="' + value.id +
                                    '">' + displayText + '</option>');
                            });
                        } else {
                            periodeSelect.append(
                                '<option value="">Tidak ada periode tersedia</option>');
                        }
                    }
                });
            });
        });
    </script>


    <script>
        function addKeahlian(containerId = '') {
            var container = containerId ? document.getElementById('keahlian-container-' + containerId) : document
                .getElementById('keahlian-container');
            var inputGroup = document.createElement('div');
            inputGroup.className = 'input-group mb-2';
            inputGroup.innerHTML = `
                <input type="text" name="keahlian_yang_dibutuhkan[]" class="form-control" placeholder="Keahlian">
                <div class="input-group-append">
                    <button class="btn btn-danger" type="button" onclick="removeKeahlian(this)">-</button>
                </div>
            `;
            container.appendChild(inputGroup);
        }

        function removeKeahlian(button) {
            var inputGroup = button.parentElement.parentElement;
            inputGroup.remove();
        }
    </script>
    <script>
        function addKeahlianEdit(containerId = '') {
            var container = containerId ? document.getElementById('keahlian-container-' + containerId) : document
                .getElementById('keahlian-container-edit');
            var inputGroup = document.createElement('div');
            inputGroup.className = 'input-group mb-2';
            inputGroup.innerHTML = `
                <input type="text" name="keahlian_yang_dibutuhkan[]" class="form-control" placeholder="Keahlian">
                <div class="input-group-append-edit">
                    <button class="btnedit btn btn-danger" type="button" onclick="removeKeahlianEdit(this)">-</button>
                </div>
            `;
            container.appendChild(inputGroup);
        }

        function removeKeahlianEdit(button) {
            var inputGroup = button.parentElement.parentElement;
            inputGroup.remove();
        }
    </script>
@endsection

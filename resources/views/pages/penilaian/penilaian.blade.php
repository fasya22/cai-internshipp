@extends('inc.main')

@section('page-title')
    Penilaian Hasil Magang
@endsection

@section('breadcrumb-title')
    Penilaian
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            @IsMentor
                                @if ($is_within_period)
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal"
                                            data-target="#myModal">Tambah Data</button>
                                    </div>
                                @endif

                                <!-- sample modal content -->
                                <form action="{{ route('data-penilaian.store', ['uid' => $lowongan_uid]) }}" method="post">
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
                                                        <label>Peserta</label>
                                                        <select name="magang_id" class="form-control" required>
                                                            <option value="">Pilih salah satu</option>
                                                            @foreach ($pesertas as $peserta)
                                                                @if ($peserta->magang)
                                                                    <option value="{{ $peserta->magang->id }}">
                                                                        {{ $peserta->nama }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @foreach ($aspeks as $aspek)
                                                        <div class="form-group">
                                                            <label for="nilai[{{ $aspek->id }}]">{{ $aspek->aspek }}</label>
                                                            <input type="number" class="form-control"
                                                                name="nilai[{{ $aspek->id }}]" required min="1"
                                                                max="100">
                                                        </div>
                                                    @endforeach

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
                                            <th>Nama Peserta</th>
                                            @foreach ($aspeks as $aspek)
                                                <th>{{ $aspek->aspek }}</th>
                                            @endforeach
                                            <th>Total Nilai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($penilaians as $key => $penilaian)
                                            <tr>
                                                <td>
                                                    {{-- @if ($key === 0)
                                                    <i class="fas fa-trophy text-warning mr-1"></i>
                                                @elseif ($key === 1)
                                                    <i class="fas fa-trophy text-silver mr-1"></i>
                                                @endif --}}
                                                    {{ $penilaian->magang->peserta['nama'] }}</td>
                                                @foreach ($aspeks as $aspek)
                                                    <td>
                                                        {{ isset($penilaian->nilai[$aspek->id]) ? $penilaian->nilai[$aspek->id] : '0' }}
                                                    </td>
                                                @endforeach
                                                <td>{{ $penilaian->total_nilai }}</td>
                                                <td>
                                                    <!-- Tombol untuk membuka modal -->
                                                    <form
                                                        action="{{ route('data-penilaian.index', ['id' => $penilaian->uid, 'uid' => $lowongan_uid]) }}"
                                                        style="display: inline;">
                                                        @csrf
                                                        <!-- Tombol untuk menampilkan modal show -->
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal"
                                                            data-target="#showModal{{ $penilaian->id }}">
                                                            <i class="far fa-eye"></i>
                                                        </button>

                                                        <!-- Modal Show Detail -->
                                                        <div class="modal fade bs-example-modal-lg"
                                                            id="showModal{{ $penilaian->id }}" tabindex="-1" role="dialog"
                                                            aria-labelledby="showModalLabel{{ $penilaian->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="showModalLabel{{ $penilaian->id }}">Detail
                                                                            Penilaian</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Tempat untuk menampilkan detail penilaian -->
                                                                        <p>Nama Peserta:
                                                                            {{ $penilaian->magang->peserta['nama'] }}</p>
                                                                        <table class="table table-bordered mb-0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Aspek Penilaian</td>
                                                                                    <td>Bobot (%)</td>
                                                                                    <td>Nilai</td>
                                                                                    <td>Hasil</td>
                                                                                </tr>
                                                                                @foreach ($aspeks as $aspek)
                                                                                    <tr>
                                                                                        <td>{{ $aspek->aspek }}</td>
                                                                                        <td>{{ number_format($aspek->bobot, 0) }}%
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ isset($penilaian->nilai[$aspek->id]) ? $penilaian->nilai[$aspek->id] : '0' }}
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ number_format(($aspek->bobot / 100) * (isset($penilaian->nilai[$aspek->id]) ? $penilaian->nilai[$aspek->id] : 0), 2) }}
                                                                                        </td>
                                                                                        <!-- Menghitung hasil perkalian nilai dan bobot -->
                                                                                    </tr>
                                                                                @endforeach
                                                                                <tr>
                                                                                    <td colspan="3">Total Nilai</td>
                                                                                    <td>{{ $penilaian->total_nilai }}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <form
                                                        action="{{ route('data-penilaian.update', ['id' => $penilaian->uid, 'uid' => $lowongan_uid]) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                                            data-target="#editModal{{ $penilaian->id }}">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                        <!-- Modal Edit -->
                                                        <div class="modal fade" id="editModal{{ $penilaian->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="editModalLabel{{ $penilaian->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="editModalLabel{{ $penilaian->id }}">Edit
                                                                            Penilaian</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Form untuk mengedit aspek -->
                                                                        {{-- <div class="form-group">
                                                                            <label>Nama Peserta</label>
                                                                            <input type="text" class="form-control"
                                                                                name="magang_id"
                                                                                value="{{ $penilaian->magang->peserta->nama }}"
                                                                                readonly>
                                                                        </div> --}}
                                                                        <div class="form-group">
                                                                            <label for="peserta">Peserta</label>
                                                                            <input type="text" class="form-control" id="peserta" name="peserta" value="{{ $penilaian->magang->peserta->nama }}" readonly>
                                                                            <input type="hidden" name="magang_id" value="{{ $penilaian->magang_id }}">
                                                                            @if ($errors->has('magang_id'))
                                                                                <div class="error" style="color: red; display:block;">
                                                                                    {{ $errors->first('magang_id') }}
                                                                                </div>
                                                                            @endif
                                                                        </div>

                                                                        @foreach ($aspeks as $aspek)
                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="nilai[{{ $aspek->id }}]">{{ $aspek->aspek }}</label>
                                                                                <input type="number" class="form-control"
                                                                                    name="nilai[{{ $aspek->id }}]"
                                                                                    value="{{ isset($penilaian->nilai[$aspek->id]) ? $penilaian->nilai[$aspek->id] : '0' }}"
                                                                                    required>
                                                                            </div>
                                                                        @endforeach
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

                                                    <form
                                                        action="{{ route('data-penilaian.destroy', ['id' => $penilaian->uid, 'uid' => $lowongan_uid]) }}"
                                                        method="post" style="display: inline;">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                                            data-target="#confirmDelete{{ $penilaian->id }}">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                        <!-- Modal Konfirmasi Hapus -->
                                                        <div class="modal fade" id="confirmDelete{{ $penilaian->id }}"
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
                            @endIsMentor

                            @IsPeserta
                                @if ($penilaians->isEmpty())
                                    <div class="ex-page-content text-center">
                                        <img src="{{ asset('admin/images/no_data.png') }}" alt="No Internships"
                                            style="width: 200px; height: auto;">
                                        <h4 class="">Belum ada penilaian</h4><br>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <a href="{{ route('cetakPenilaian', ['magang_uid' => $magang_uid]) }}"
                                            class="btn btn-primary waves-effect waves-light" target="_blank">Cetak
                                            Penilaian</a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <tbody>
                                                <tr>
                                                    <td><b>Aspek Penilaian</b></td>
                                                    <td><b>Bobot (%)</b></td>
                                                    <td><b>Nilai</b></td>
                                                    <td><b>Hasil</b></td>
                                                </tr>
                                                @foreach ($penilaians as $penilaian)
                                                    @foreach ($aspeks as $aspek)
                                                        <tr>
                                                            <td>{{ $aspek->aspek }}</td>
                                                            <td>{{ number_format($aspek->bobot, 0) }}%
                                                            </td>
                                                            <td>
                                                                {{ isset($penilaian->nilai[$aspek->id]) ? $penilaian->nilai[$aspek->id] : '0' }}
                                                            </td>
                                                            <td>
                                                                {{ number_format(($aspek->bobot / 100) * (isset($penilaian->nilai[$aspek->id]) ? $penilaian->nilai[$aspek->id] : 0), 2) }}
                                                            </td>
                                                            <!-- Menghitung hasil perkalian nilai dan bobot -->
                                                        </tr>
                                                    @endforeach

                                                    <tr>
                                                        <td colspan="3">Total Nilai</td>
                                                        <td>{{ $penilaian->total_nilai }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endIsPeserta

                            @IsAdmin
                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Nama Peserta</th>
                                            @foreach ($aspeks as $aspek)
                                                <th>{{ $aspek->aspek }}</th>
                                            @endforeach
                                            <th>Total Nilai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($penilaians as $penilaian)
                                            <tr>
                                                <td>{{ $penilaian->magang->peserta['nama'] }}</td>
                                                @foreach ($aspeks as $aspek)
                                                    <td>
                                                        {{ isset($penilaian->nilai[$aspek->id]) ? $penilaian->nilai[$aspek->id] : '0' }}
                                                    </td>
                                                @endforeach
                                                <td>{{ $penilaian->total_nilai }}</td>
                                                <td>
                                                    <!-- Tombol untuk membuka modal -->
                                                    <form
                                                        action="{{ route('data-penilaian.index', ['id' => $penilaian->uid, 'uid' => $lowongan_uid]) }}"
                                                        style="display: inline;">
                                                        @csrf
                                                        <!-- Tombol untuk menampilkan modal show -->
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal"
                                                            data-target="#showModal{{ $penilaian->id }}">
                                                            <i class="far fa-eye"></i>
                                                        </button>

                                                        <!-- Modal Show Detail -->
                                                        <div class="modal fade bs-example-modal-lg"
                                                            id="showModal{{ $penilaian->id }}" tabindex="-1" role="dialog"
                                                            aria-labelledby="showModalLabel{{ $penilaian->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="showModalLabel{{ $penilaian->id }}">Detail
                                                                            Penilaian</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Tempat untuk menampilkan detail penilaian -->
                                                                        <p>Nama Peserta:
                                                                            {{ $penilaian->magang->peserta['nama'] }}</p>
                                                                        <table class="table table-bordered mb-0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Aspek Penilaian</td>
                                                                                    <td>Bobot (%)</td>
                                                                                    <td>Nilai</td>
                                                                                    <td>Hasil</td>
                                                                                </tr>
                                                                                @foreach ($aspeks as $aspek)
                                                                                    <tr>
                                                                                        <td>{{ $aspek->aspek }}</td>
                                                                                        <td>{{ number_format($aspek->bobot, 0) }}%
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ isset($penilaian->nilai[$aspek->id]) ? $penilaian->nilai[$aspek->id] : '0' }}
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ number_format(($aspek->bobot / 100) * (isset($penilaian->nilai[$aspek->id]) ? $penilaian->nilai[$aspek->id] : 0), 2) }}
                                                                                        </td>
                                                                                        <!-- Menghitung hasil perkalian nilai dan bobot -->
                                                                                    </tr>
                                                                                @endforeach
                                                                                <tr>
                                                                                    <td colspan="3">Total Nilai</td>
                                                                                    <td>{{ $penilaian->total_nilai }}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
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
                            @endIsAdmin
                        </div>
                    </div>
                </div>
            </div><!-- end row -->
        </div><!-- end row -->


    </div> <!-- container-fluid -->

    </div> <!-- content -->
@endsection

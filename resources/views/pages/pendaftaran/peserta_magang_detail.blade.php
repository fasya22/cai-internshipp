@extends('inc.main')

@section('page-title')
    Peserta Magang
@endsection

@section('breadcrumb-title')
    Peserta Magang
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
    </style>
    <div class="content">
        <div class="container-fluid">

            @IsAdmin
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
                                            <th>Posisi</th>
                                            <th>Mentor</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($magang as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->peserta['nama'] }}</td>
                                                <td>{{ $value->lowongan->posisi->posisi }}</td>
                                                <td>
                                                    @if ($value->mentor)
                                                        {{ $value->mentor }}
                                                    @else
                                                        <span class="badge badge-warning">Mentor belum ditentukan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 10px;">
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
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    <div class="col-12 email-container">
                                                                                        {{-- <div class=""> --}}
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Nama
                                                                                                Peserta</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta['nama'] ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Posisi</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->lowongan->posisi->posisi ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Periode</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->periode['judul_periode'] ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Email</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->user->email ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">No
                                                                                                HP</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->no_hp ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Alamat</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->alamat ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Pendidikan
                                                                                                Terakhir</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->pendidikan_terakhir ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Institusi
                                                                                                Pendidikan
                                                                                                Terakhir</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->institusi_pendidikan_terakhir ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Tanggal
                                                                                                Mulai Studi</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    @if ($value->peserta->tanggal_mulai_studi)
                                                                                                        {{ \Carbon\Carbon::parse($value->peserta->tanggal_mulai_studi)->translatedFormat('j F Y') }}
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Tanggal
                                                                                                Berakhir Studi</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    @if ($value->peserta->tanggal_berakhir_studi)
                                                                                                        {{ \Carbon\Carbon::parse($value->peserta->tanggal_berakhir_studi)->translatedFormat('j F Y') }}
                                                                                                        @if (\Carbon\Carbon::parse($value->peserta->tanggal_berakhir_studi)->isPast())
                                                                                                            <span
                                                                                                                class="badge badge-success">Lulus</span>
                                                                                                        @else
                                                                                                            <span
                                                                                                                class="badge badge-warning">Belum
                                                                                                                Lulus</span>
                                                                                                        @endif
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Program
                                                                                                Studi</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->prodi ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">IPK</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->ipk ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Kartu
                                                                                                Identitas Studi</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px;">
                                                                                                    @if ($value->peserta->kartu_identitas_studi)
                                                                                                        <a href="{{ asset('storage/kartu_identitas_studi/' . $value->peserta->kartu_identitas_studi) }}"
                                                                                                            target="_blank">
                                                                                                            Kartu Identitas
                                                                                                            Studi <i
                                                                                                                class="fas fa-external-link-alt"></i>
                                                                                                        </a>
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Curriculum
                                                                                                Vitae</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px;">
                                                                                                    @if ($value->cv)
                                                                                                        <a href="{{ asset('storage/cv/' . $value->cv) }}"
                                                                                                            target="_blank">
                                                                                                            Curriculum Vitae <i
                                                                                                                class="fas fa-external-link-alt"></i>
                                                                                                        </a>
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Surat
                                                                                                Lamaran Magang</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px;">
                                                                                                    @if ($value->surat_lamaran_magang)
                                                                                                        <a href="{{ asset('storage/surat_lamaran_magang/' . $value->surat_lamaran_magang) }}"
                                                                                                            target="_blank">
                                                                                                            Surat Lamaran Magang
                                                                                                            <i
                                                                                                                class="fas fa-external-link-alt"></i>
                                                                                                        </a>
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Portfolio</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    @if (is_array($value->link_portfolio) && !empty($value->link_portfolio))
                                                                                                        @foreach ($value->link_portfolio as $link)
                                                                                                            <a href="{{ $link }}"
                                                                                                                target="_blank">Portfolio
                                                                                                                <i
                                                                                                                    class="fas fa-external-link-alt"></i></a><br>
                                                                                                        @endforeach
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        {{-- </div> --}}
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <p><b>Kemampuan Bahasa Inggris</b></p>
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-bordered mb-0">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td><strong>Jenis
                                                                                                        Sertifikat:</strong>
                                                                                                </td>
                                                                                                <td>{{ $value->englishCertificate->jenis_sertifikat ?? 'Tidak ada sertifikat' }}
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>Nilai
                                                                                                        Minimum:</strong>
                                                                                                </td>
                                                                                                <td>{{ $value->englishCertificate->nilai_minimum ?? '-' }}
                                                                                                    @if ($value->englishCertificate && $value->englishCertificate->trashed())
                                                                                                        <span
                                                                                                            class="badge badge-warning">Archived</span>
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>Nilai Bahasa
                                                                                                        Inggris:</strong></td>
                                                                                                <td>
                                                                                                    @if (isset($value->nilai_bahasa_inggris))
                                                                                                        {{ $value->nilai_bahasa_inggris }}
                                                                                                        @if ($value->nilai_bahasa_inggris >= $value->englishCertificate->nilai_minimum)
                                                                                                            <span
                                                                                                                class="badge badge-success">Pass</span>
                                                                                                        @else
                                                                                                            <span
                                                                                                                class="badge badge-danger">Fail</span>
                                                                                                        @endif
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>Sertifikat:</strong>
                                                                                                </td>
                                                                                                <td>
                                                                                                    @if ($value->sertifikat_bahasa_inggris)
                                                                                                        <a href="{{ asset('storage/sertifikat_bahasa_inggris/' . $value->sertifikat_bahasa_inggris) }}"
                                                                                                            target="_blank">
                                                                                                            <button
                                                                                                                type="button"
                                                                                                                class="btn btn-primary">
                                                                                                                <i class="far fa-file-pdf"
                                                                                                                    aria-hidden="true"></i>
                                                                                                                Sertifikat
                                                                                                                Bahasa Inggris
                                                                                                            </button>
                                                                                                        </a>
                                                                                                    @else
                                                                                                        Tidak ada sertifikat
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <p><b>Kemampuan Keahlian Yang Dimiliki</b></p>
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-bordered mb-0">
                                                                                        <tbody>
                                                                                            @php
                                                                                                $keahlian_dibutuhkan =
                                                                                                    json_decode(
                                                                                                        $value->lowongan
                                                                                                            ->keahlian_yang_dibutuhkan,
                                                                                                        true,
                                                                                                    ) ?? [];
                                                                                                $keahlian_dimiliki =
                                                                                                    json_decode(
                                                                                                        $value->keahlian_yang_dimiliki,
                                                                                                        true,
                                                                                                    ) ?? [];
                                                                                            @endphp
                                                                                            @foreach ($keahlian_dibutuhkan as $keahlian)
                                                                                                <tr>
                                                                                                    <td>{{ $keahlian }}
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        @if (in_array($keahlian, $keahlian_dimiliki))
                                                                                                            <i
                                                                                                                class="fas fa-check text-success"></i>
                                                                                                        @else
                                                                                                            <i
                                                                                                                class="fas fa-times text-danger"></i>
                                                                                                        @endif
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <p><b>Softskill</b></p>
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-bordered mb-0">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>Memiliki kemampuan
                                                                                                    komunikasi
                                                                                                    yang baik</td>
                                                                                                <td>
                                                                                                    @if ($value->soft_komunikasi)
                                                                                                        <i
                                                                                                            class="fas fa-check text-success"></i>
                                                                                                        <!-- Centang jika true -->
                                                                                                    @else
                                                                                                        <i
                                                                                                            class="fas fa-times text-danger"></i>
                                                                                                        <!-- Silang jika false -->
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Mampu bekerja secara
                                                                                                    individu
                                                                                                    maupun tim</td>
                                                                                                <td>
                                                                                                    @if ($value->soft_tim)
                                                                                                        <i
                                                                                                            class="fas fa-check text-success"></i>
                                                                                                        <!-- Centang jika true -->
                                                                                                    @else
                                                                                                        <i
                                                                                                            class="fas fa-times text-danger"></i>
                                                                                                        <!-- Silang jika false -->
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Mampu beradaptasi dengan
                                                                                                    lingkungan baru</td>
                                                                                                <td>
                                                                                                    @if ($value->soft_adaptable)
                                                                                                        <i
                                                                                                            class="fas fa-check text-success"></i>
                                                                                                        <!-- Centang jika true -->
                                                                                                    @else
                                                                                                        <i
                                                                                                            class="fas fa-times text-danger"></i>
                                                                                                        <!-- Silang jika false -->
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
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
                                                        <form action="{{ route('peserta-magang.update', $value->id) }}"
                                                            method="POST" enctype="multipart/form-data"
                                                            style="display: inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <!-- Tombol untuk membuka modal -->
                                                            <button type="button" class="btn btn-warning"
                                                                data-toggle="modal"
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
                                                                                id="editModalLabel{{ $value->id }}">
                                                                                Tentukan Mentor
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Form untuk mengedit peserta -->
                                                                            <form
                                                                                action="{{ route('peserta-magang.update', $value->id) }}"
                                                                                method="POST" enctype="multipart/form-data">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <div class="form-group">
                                                                                    <label for="peserta">Nama</label>
                                                                                    <input type="text" class="form-control"
                                                                                        id="peserta" name="peserta"
                                                                                        value="{{ $value->peserta['nama'] }}"
                                                                                        readonly>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="lowongan">Posisi</label>
                                                                                    <input type="text" class="form-control"
                                                                                        id="lowongan" name="lowongan"
                                                                                        value="{{ $value->lowongan->posisi->posisi }}"
                                                                                        readonly>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="mentor">Mentor</label>
                                                                                    <select name="mentor_id"
                                                                                        class="form-control">
                                                                                        @foreach ($mentors->where('posisi', $value->lowongan->posisi->posisi) as $mentor)
                                                                                            <option
                                                                                                value="{{ $mentor->id }}"
                                                                                                {{ $value->mentor_id == $mentor->id ? 'selected' : '' }}>
                                                                                                {{ $mentor->nama }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <!-- Tombol "Submit" harus berada di dalam tag <form> -->
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">Batal</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">Simpan
                                                                                        Perubahan</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
            @endIsAdmin

            @IsMentor
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
                                            <th>Posisi</th>
                                            <th>Mentor</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($magang as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->peserta['nama'] }}</td>
                                                <td>{{ $value->lowongan->posisi->posisi }}</td>
                                                <td>
                                                    @if ($value->mentor)
                                                        {{ $value->mentor }}
                                                    @else
                                                        <span class="badge badge-warning">Mentor belum ditentukan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 10px;">
                                                        <form action="{{ route('list-pendaftar.index', $value->uid) }}"
                                                            style="display: inline;">
                                                            @csrf
                                                            <!-- Tombol untuk menampilkan modal show -->
                                                            <button type="button" class="btn btn-secondary"
                                                                data-toggle="modal"
                                                                data-target="#showModal{{ $value->id }}">
                                                                <i class="far fa-eye"></i>
                                                            </button>

                                                            <!-- Modal Show Detail -->
                                                            <div class="modal fade bs-example-modal-lg"
                                                                id="showModal{{ $value->id }}" tabindex="-1"
                                                                role="dialog"
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
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    <div class="col-12 email-container">
                                                                                        {{-- <div class=""> --}}
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Nama
                                                                                                Peserta</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta['nama'] ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Posisi</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->lowongan->posisi->posisi ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Periode</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->periode['judul_periode'] ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Email</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->user->email ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">No
                                                                                                HP</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->no_hp ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Alamat</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->alamat ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Pendidikan
                                                                                                Terakhir</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->pendidikan_terakhir ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Institusi
                                                                                                Pendidikan
                                                                                                Terakhir</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->institusi_pendidikan_terakhir ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Tanggal
                                                                                                Mulai Studi</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    @if ($value->peserta->tanggal_mulai_studi)
                                                                                                        {{ \Carbon\Carbon::parse($value->peserta->tanggal_mulai_studi)->translatedFormat('j F Y') }}
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Tanggal
                                                                                                Berakhir Studi</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    @if ($value->peserta->tanggal_berakhir_studi)
                                                                                                        {{ \Carbon\Carbon::parse($value->peserta->tanggal_berakhir_studi)->translatedFormat('j F Y') }}
                                                                                                        @if (\Carbon\Carbon::parse($value->peserta->tanggal_berakhir_studi)->isPast())
                                                                                                            <span
                                                                                                                class="badge badge-success">Lulus</span>
                                                                                                        @else
                                                                                                            <span
                                                                                                                class="badge badge-warning">Belum
                                                                                                                Lulus</span>
                                                                                                        @endif
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Program
                                                                                                Studi</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->prodi ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">IPK</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->peserta->ipk ?? '-' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Kartu
                                                                                                Identitas Studi</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    @if ($value->peserta->kartu_identitas_studi)
                                                                                                        <a href="{{ asset('storage/kartu_identitas_studi/' . $value->peserta->kartu_identitas_studi) }}"
                                                                                                            target="_blank">
                                                                                                            Kartu Identitas
                                                                                                            Studi <i
                                                                                                                class="fas fa-external-link-alt"></i>
                                                                                                        </a>
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Curriculum
                                                                                                Vitae</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    @if ($value->cv)
                                                                                                        <a href="{{ asset('storage/cv/' . $value->cv) }}"
                                                                                                            target="_blank">
                                                                                                            Curriculum Vitae <i
                                                                                                                class="fas fa-external-link-alt"></i>
                                                                                                        </a>
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Surat
                                                                                                Lamaran Magang</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    @if ($value->surat_lamaran_magang)
                                                                                                        <a href="{{ asset('storage/surat_lamaran_magang/' . $value->surat_lamaran_magang) }}"
                                                                                                            target="_blank">
                                                                                                            Surat Lamaran Magang
                                                                                                            <i
                                                                                                                class="fas fa-external-link-alt"></i>
                                                                                                        </a>
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Portfolio</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    @if (is_array($value->link_portfolio) && !empty($value->link_portfolio))
                                                                                                        @foreach ($value->link_portfolio as $link)
                                                                                                            <a href="{{ $link }}"
                                                                                                                target="_blank">Portfolio
                                                                                                                <i
                                                                                                                    class="fas fa-external-link-alt"></i></a><br>
                                                                                                        @endforeach
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        {{-- </div> --}}
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <p><b>Kemampuan Bahasa Inggris</b></p>
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-bordered mb-0">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td><strong>Jenis
                                                                                                        Sertifikat:</strong>
                                                                                                </td>
                                                                                                <td>{{ $value->englishCertificate->jenis_sertifikat ?? 'Tidak ada sertifikat' }}
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>Nilai
                                                                                                        Minimum:</strong>
                                                                                                </td>
                                                                                                <td>{{ $value->englishCertificate->nilai_minimum ?? '-' }}
                                                                                                    @if ($value->englishCertificate && $value->englishCertificate->trashed())
                                                                                                        <span
                                                                                                            class="badge badge-warning">Archived</span>
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>Nilai Bahasa
                                                                                                        Inggris:</strong></td>
                                                                                                <td>
                                                                                                    @if (isset($value->nilai_bahasa_inggris))
                                                                                                        {{ $value->nilai_bahasa_inggris }}
                                                                                                        @if ($value->nilai_bahasa_inggris >= $value->englishCertificate->nilai_minimum)
                                                                                                            <span
                                                                                                                class="badge badge-success">Pass</span>
                                                                                                        @else
                                                                                                            <span
                                                                                                                class="badge badge-danger">Fail</span>
                                                                                                        @endif
                                                                                                    @else
                                                                                                        -
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>Sertifikat:</strong>
                                                                                                </td>
                                                                                                <td>
                                                                                                    @if ($value->sertifikat_bahasa_inggris)
                                                                                                        <a href="{{ asset('storage/sertifikat_bahasa_inggris/' . $value->sertifikat_bahasa_inggris) }}"
                                                                                                            target="_blank">
                                                                                                            <button
                                                                                                                type="button"
                                                                                                                class="btn btn-primary">
                                                                                                                <i class="far fa-file-pdf"
                                                                                                                    aria-hidden="true"></i>
                                                                                                                Sertifikat
                                                                                                                Bahasa Inggris
                                                                                                            </button>
                                                                                                        </a>
                                                                                                    @else
                                                                                                        Tidak ada sertifikat
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <p><b>Kemampuan Keahlian Yang Dimiliki</b></p>
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-bordered mb-0">
                                                                                        <tbody>
                                                                                            @php
                                                                                                $keahlian_dibutuhkan =
                                                                                                    json_decode(
                                                                                                        $value->lowongan
                                                                                                            ->keahlian_yang_dibutuhkan,
                                                                                                        true,
                                                                                                    ) ?? [];
                                                                                                $keahlian_dimiliki =
                                                                                                    json_decode(
                                                                                                        $value->keahlian_yang_dimiliki,
                                                                                                        true,
                                                                                                    ) ?? [];
                                                                                            @endphp
                                                                                            @foreach ($keahlian_dibutuhkan as $keahlian)
                                                                                                <tr>
                                                                                                    <td>{{ $keahlian }}
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        @if (in_array($keahlian, $keahlian_dimiliki))
                                                                                                            <i
                                                                                                                class="fas fa-check text-success"></i>
                                                                                                        @else
                                                                                                            <i
                                                                                                                class="fas fa-times text-danger"></i>
                                                                                                        @endif
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <p><b>Softskill</b></p>
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-bordered mb-0">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>Memiliki kemampuan
                                                                                                    komunikasi
                                                                                                    yang baik</td>
                                                                                                <td>
                                                                                                    @if ($value->soft_komunikasi)
                                                                                                        <i
                                                                                                            class="fas fa-check text-success"></i>
                                                                                                        <!-- Centang jika true -->
                                                                                                    @else
                                                                                                        <i
                                                                                                            class="fas fa-times text-danger"></i>
                                                                                                        <!-- Silang jika false -->
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Mampu bekerja secara
                                                                                                    individu
                                                                                                    maupun tim</td>
                                                                                                <td>
                                                                                                    @if ($value->soft_tim)
                                                                                                        <i
                                                                                                            class="fas fa-check text-success"></i>
                                                                                                        <!-- Centang jika true -->
                                                                                                    @else
                                                                                                        <i
                                                                                                            class="fas fa-times text-danger"></i>
                                                                                                        <!-- Silang jika false -->
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Mampu beradaptasi dengan
                                                                                                    lingkungan baru</td>
                                                                                                <td>
                                                                                                    @if ($value->soft_adaptable)
                                                                                                        <i
                                                                                                            class="fas fa-check text-success"></i>
                                                                                                        <!-- Centang jika true -->
                                                                                                    @else
                                                                                                        <i
                                                                                                            class="fas fa-times text-danger"></i>
                                                                                                        <!-- Silang jika false -->
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
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
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
            @endIsMentor

        </div> <!-- container-fluid -->

    </div> <!-- content -->
@endsection

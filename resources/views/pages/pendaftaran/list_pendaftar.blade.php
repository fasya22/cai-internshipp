@extends('inc.main')

@section('page-title')
    Daftar Pelamar Magang
@endsection

@section('breadcrumb-title')
    Daftar Pelamar Magang
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
                        <form id="filterForm">
                            <div class="row mb-3">
                                <div class="col-md-3 mb-3">
                                    <label for="year">Tahun:</label>
                                    <select class="form-control" id="year" name="year">
                                        <option value="">Semua Tahun</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
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
                                                data-year="{{ \Carbon\Carbon::parse($item->tanggal_mulai)->year }}"
                                                {{ request('periode') == $item->id ? 'selected' : '' }}>
                                                {{ $item->judul_periode }}
                                                ({{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('j F Y') }} -
                                                {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('j F Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
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
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control">Filter</button>
                                </div>
                            </div>
                        </form>

                        <div class="card m-b-30">
                            <div class="card-body">
                                <table id="datatable-buttons-example"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">No</th>
                                            <th data-priority="1">Nama</th>
                                            <th data-priority="3">Posisi</th>
                                            <th data-priority="2">Tahap Seleksi</th>
                                            <th data-priority="2">Status Penerimaan</th>
                                            <th data-priority="2">Nilai Seleksi</th>
                                            <th data-priority="1">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($magangData as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->peserta['nama'] }}</td>
                                                <td>{{ $value->lowongan->posisi->posisi }}</td>
                                                <td>
                                                    @if (is_null($value->status_rekomendasi))
                                                        <span class="badge badge-secondary">Seleksi Berkas</span>
                                                    @elseif ($value->status_rekomendasi === 1 && $value->status_penerimaan === 1)
                                                        <span class="badge badge-success">Direkomendasikan</span>
                                                    @elseif ($value->status_rekomendasi === 1 && $value->status_penerimaan === 2)
                                                        <span class="badge badge-danger">Tidak Direkomendasikan</span>
                                                    @elseif (is_null($value->status_penerimaan) && $value->status_rekomendasi === 1)
                                                        <span class="badge badge-warning">Technical Test</span>
                                                    @elseif ($value->status_rekomendasi === 3 || $value->status_rekomendasi === 4)
                                                        <span class="badge badge-danger">Tidak Direkomendasikan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (is_null($value->status_penerimaan))
                                                        <span class="badge badge-secondary">Dalam Seleksi</span>
                                                    @elseif ($value->status_penerimaan === 1)
                                                        <span class="badge badge-success">Lolos Seleksi</span>
                                                    @elseif ($value->status_penerimaan === 2)
                                                        <span class="badge badge-danger">Tidak Lolos</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($value->seleksi)
                                                        {{ $value->seleksi->nilai_seleksi }}
                                                    @else
                                                        -
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
                                                                                id="showModalLabel{{ $value->id }}">
                                                                                Detail
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
                                                                                                            Curriculum Vitae
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
                                                                                                style="white-space: normal !important;">Surat
                                                                                                Lamaran Magang</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px;">
                                                                                                    @if ($value->surat_lamaran_magang)
                                                                                                        <a href="{{ asset('storage/surat_lamaran_magang/' . $value->surat_lamaran_magang) }}"
                                                                                                            target="_blank">
                                                                                                            Surat Lamaran
                                                                                                            Magang
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
                                                                                                        Inggris:</strong>
                                                                                                </td>
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
                                                                                                                Bahasa
                                                                                                                Inggris
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
                                                                                <p><b>Kemampuan Keahlian Yang Dimiliki</b>
                                                                                </p>
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

                                                        @if ($value->status_rekomendasi === null)
                                                            <form
                                                                action="{{ route('changeRecommendationStatus', ['id' => $value->id, 'status' => 1]) }}"
                                                                method="POST" style="display: inline;">
                                                                @csrf
                                                                <button type="button" class="btn btn-primary"
                                                                    data-toggle="modal"
                                                                    data-target="#catatanModal{{ $value->id }}">
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                    <!-- Ganti dengan ikon yang sesuai, misalnya bi-check-square untuk Rekomendasikan -->
                                                                </button>
                                                                <!-- Modal untuk input catatan -->
                                                                <div class="modal fade" id="catatanModal{{ $value->id }}"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="catatanModalLabel{{ $value->id }}"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <form
                                                                                action="{{ route('changeRecommendationStatus', ['id' => $value->id, 'status' => 1]) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="catatanModalLabel{{ $value->id }}">
                                                                                        Input Catatan Rekomendasi</h5>
                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="catatan{{ $value->id }}">Catatan
                                                                                            <span
                                                                                                style="font-weight: normal;">(Opsional)
                                                                                                :</span></label>
                                                                                        <textarea class="form-control" id="catatan{{ $value->id }}" name="catatan" rows="3"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">Close</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">Rekomendasikan</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <form
                                                                action="{{ route('changeRecommendationStatus', ['id' => $value->id, 'status' => 4]) }}"
                                                                method="POST" style="display: inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if (is_null($value->status_penerimaan) && $value->status_rekomendasi === 4)
                                                            <form
                                                                action="{{ route('pendaftaran.changeStatus', ['id' => $value->id, 'status' => 2]) }}"
                                                                method="POST" style="display: inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @endif


                                                        {{-- @if ($value->status_rekomendasi == 2 || $value->status_rekomendasi == 3)
                                                            <div class="dropdown mo-mb-2">
                                                                <a class="btn btn-primary dropdown-toggle" href="#"
                                                                    id="dropdownMenuLink" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                    Status Penerimaan
                                                                </a>

                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('pendaftaran.changeStatus', ['id' => $value->id, 'status' => 1]) }}">Diterima</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('pendaftaran.changeStatus', ['id' => $value->id, 'status' => 2]) }}">Ditolak</a>
                                                                </div>
                                                            </div>
                                                        @endif --}}
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

            @IsHrd
                <div class="row mb-3">
                    <div class="col-12">
                        <form action="{{ route('list-pendaftar.index') }}" method="GET">
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
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
                                <div class="col-md-4 mb-3">
                                    <label for="periode">Periode:</label>
                                    <select class="form-control" id="periode" name="periode">
                                        <option value="">Semua Periode</option>
                                        @foreach ($periode as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request('periode') == $item->id ? 'selected' : '' }}>
                                                {{ $item->judul_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control">Filter</button>
                                </div>
                            </div>
                        </form>

                        @if ($magangData->isEmpty())
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="ex-page-content text-center">
                                        <img src="{{ asset('admin/images/no_data.png') }}" alt="No Internships"
                                            style="width: 200px; height: auto;">

                                        <h4 class="">Belum ada pelamar magang</h4><br>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('filterPendaftaran') }}" method="GET">
                                <div class="row">
                                    @foreach ($magangData as $value)
                                        <div class="col-lg-4">
                                            <div class="card m-b-30">
                                                <a href="{{ route('getlistpendaftar', ['uid' => $value['lowongan_uid']]) }}">
                                                    <div class="card-body">
                                                        <h4 class="card-title font-16 mt-0">{{ $value['posisi'] }} ||
                                                            {{ $value['periode_judul'] }}</h4>
                                                        {{-- <p class="card-text">Jumlah Pelamar: {{ $value['jumlah_peserta'] }}
                                                    </p> --}}
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            @endIsHrd

        </div> <!-- container-fluid -->

    </div> <!-- content -->
@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.2/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/3.1.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.print.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.colVis.min.js"></script>
<!-- JSZip -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<!-- pdfmake -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var yearSelect = document.getElementById('year');
        var periodeSelect = document.getElementById('periode');
        var originalPeriodeOptions = Array.from(periodeSelect.options);

        yearSelect.addEventListener('change', function () {
            var selectedYear = yearSelect.value;

            // Clear current periode options
            periodeSelect.innerHTML = '<option value="">Semua Periode</option>';

            if (selectedYear) {
                // Add options matching the selected year
                originalPeriodeOptions.forEach(function (option) {
                    if (option.value && option.dataset.year === selectedYear) {
                        periodeSelect.appendChild(option);
                    }
                });
            } else {
                // Display all periods if no year is selected
                originalPeriodeOptions.forEach(function (option) {
                    if (option.value) {
                        periodeSelect.appendChild(option);
                    }
                });
            }

            // Reset selected periode if not in the filtered list
            if (periodeSelect.querySelector('option[selected]') && !periodeSelect.querySelector('option[selected]').dataset.year === selectedYear) {
                periodeSelect.value = '';
            }
        });
    });
    </script>

<script>
    $(document).ready(function() {
        var posisiText = $('#posisi option:selected').text();
        var periodeText = $('#periode option:selected').text();
        var tahunText = $('#year option:selected').text();

        // Buat title berdasarkan nilai filter
        var titleText = 'Daftar Pelamar Magang\n';
        if (posisiText !== 'Semua Posisi') {
            titleText += ' Posisi ' + posisiText;
        }
        if (periodeText !== 'Semua Periode') {
            titleText += ' Periode ' + periodeText;
        }
        if (tahunText !== 'Semua Tahun' && tahunText !== '') {
            titleText += ' Tahun ' + tahunText;
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
                    filename: 'Data_Export',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: 'Data_Export',
                    title: 'Data Export',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdf',
                    text: 'Export to PDF',
                    filename: 'Data_Export',
                    title: titleText,
                    customize: function(doc) {
                        doc.styles.title = {
                            alignment: 'center'
                        };
                        doc.styles.message = {
                            alignment: 'center'
                        };

                        // Mengatur konten agar fit ke ukuran halaman
                        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) {
                            return .5;
                        };
                        objLayout['vLineWidth'] = function(i) {
                            return .5;
                        };
                        objLayout['hLineColor'] = function(i) {
                            return '#aaa';
                        };
                        objLayout['vLineColor'] = function(i) {
                            return '#aaa';
                        };
                        objLayout['paddingLeft'] = function(i) {
                            return 4;
                        };
                        objLayout['paddingRight'] = function(i) {
                            return 4;
                        };
                        objLayout['paddingTop'] = function(i) {
                            return 4;
                        };
                        objLayout['paddingBottom'] = function(i) {
                            return 4;
                        };
                        doc.content[1].layout = objLayout;

                        // Set column widths
                        var colCount = doc.content[1].table.body[0].length;
                        var body = doc.content[1].table.body;
                        doc.content[1].table.widths = [];
                        for (var i = 0; i < colCount; i++) {
                            doc.content[1].table.widths.push('*');
                        }

                        // Custom page size
                        doc.pageSize = 'A4';
                        doc.pageMargins = [20, 10, 20, 40];

                        // Menambahkan kop surat di bagian atas
                    var companyLogo = 'data:image/png;base64,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'; // Ganti dengan base64 gambar logo Anda
                    var companyName = 'PT Central Artificial Intelligence';
                    var companyAddress = 'Jalan Margonda Raya No. 1, Pondok Cina Kota Depok, Jawa Barat, Indonesia';

                    doc.content.unshift({
                        columns: [
                            {
                                image: companyLogo,
                                width: 100,
                                margin: [10, 5, 0, 0] // Margin dari kiri, atas, kanan, bawah
                            },
                            {
                                stack: [
                                    {
                                        text: companyName,
                                        fontSize: 12,
                                        bold: true,
                                        alignment: 'right',
                                        margin: [0, 0, 0, 4]
                                    },
                                    {
                                        text: companyAddress,
                                        fontSize: 8,
                                        alignment: 'right'
                                    }
                                ],
                                margin: [0, 10, 10, 50]
                            }
                        ],
                        columnGap: 10 // Jarak antara kolom logo dan teks
                    });
                    var currentDate = new Date();
                    var formattedDate = currentDate.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });

                    var leftMargin = 250;

                    doc.content.push({
                        text: formattedDate,
                        alignment: 'center',
                        margin: [leftMargin, 30, 0, 0]
                    });

                    doc.content.push({
                        text: 'Mengetahui,',
                        alignment: 'center',
                        margin: [leftMargin, 5, 0, 0]
                    });

                    doc.content.push({
                        text: '\n\n\n\n\n\n(Salwa Ziada Salsabiila)',
                        alignment: 'center',
                        margin: [leftMargin, 0, 0, 5]
                    });

                    doc.content.push({
                        text: 'CEO PT Central Artificial Intelligence',
                        alignment: 'center',
                        margin: [leftMargin, 0, 0, 0]
                    });
                    },
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
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






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


            <div class="row">
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
                                            ({{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('j F Y') }} -
                                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('j F Y') }})
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
                    <div class="card m-b-30">
                        <div class="card-body">
                            @IsAdmin
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
                                                    @elseif ($value->status_rekomendasi === 1)
                                                        @if (is_null($value->status_penerimaan))
                                                            <span class="badge badge-warning">Technical Test</span>
                                                            @if ($value->catatan)
                                                                <p>Catatan: {{ $value->catatan }}</p>
                                                            @endif
                                                        @elseif ($value->status_penerimaan === 1)
                                                            <span class="badge badge-success">Lolos Seleksi</span>
                                                        @elseif ($value->status_penerimaan === 2)
                                                            <span class="badge badge-danger">Tidak Lolos</span>
                                                        @endif
                                                    @elseif ($value->status_rekomendasi === 3)
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
                                                                action="{{ route('changeRecommendationStatus', ['id' => $value->id, 'status' => 3]) }}"
                                                                method="POST" style="display: inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary">
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
                            @endIsAdmin
                            @IsHrd
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
                                                    @elseif ($value->status_rekomendasi === 2)
                                                        <span class="badge badge-success">Direkomendasikan</span>
                                                    @elseif ($value->status_rekomendasi === 1)
                                                        <span class="badge badge-warning">Technical Test</span>
                                                    @elseif ($value->status_rekomendasi === 3)
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
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    @if ($value->peserta->kartu_identitas_studi)
                                                                                                        <a href="{{ url('pdf/' . $value->peserta->kartu_identitas_studi) }}"
                                                                                                            target="_blank">Kartu
                                                                                                            Identitas Studi
                                                                                                            <i
                                                                                                                class="fas fa-external-link-alt"></i></a>
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
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
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
                                                                                {{-- <p><b>Catatan</b></p> --}}
                                                                                <div class="row">
                                                                                    <div class="col-12 email-container">
                                                                                        {{-- <div class=""> --}}
                                                                                        <div class="row">
                                                                                            <label for="example-text-input"
                                                                                                class="col-lg-4 col-form-label font-weight-bold"
                                                                                                style="white-space: normal !important;">Catatan
                                                                                                dari Admin</label>
                                                                                            <div class="col-lg-8 mb-1">
                                                                                                <p
                                                                                                    style="white-space: normal !important; margin-bottom: 4px">
                                                                                                    {{ $value->catatan ?? 'Tidak ada Catatan dari Administrasi' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
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
                                                        {{-- <form
                                                            action="{{ route('changeRecommendationStatus', ['id' => $value->id, 'status' => 2]) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success"><i
                                                                    class="fas fa-check"></i></button>
                                                        </form>
                                                        <form
                                                            action="{{ route('changeRecommendationStatus', ['id' => $value->id, 'status' => 3]) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    class="fas fa-times"></i></button>
                                                        </form> --}}

                                                        {{-- <form action="{{ route('simpan-penilaian', $value->id) }}"
                                                            style="display: inline;">
                                                            @csrf
                                                            @if (is_null($value->nilai_seleksi))
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#inputNilaiModal{{ $value->id }}">
                                                                    <i class="fas fa-pen"></i> Input Nilai
                                                                </button>
                                                            @else
                                                                <button type="button" class="btn btn-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#inputNilaiModal{{ $value->id }}">
                                                                    <i class="fas fa-edit"></i> Edit Nilai
                                                                </button>
                                                            @endif

                                                            <!-- Modal Show Detail -->
                                                            <div class="modal fade" id="inputNilaiModal{{ $value->id }}"
                                                                tabindex="-1"
                                                                aria-labelledby="inputNilaiModalLabel{{ $value->id }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="inputNilaiModalLabel{{ $value->id }}">
                                                                                @if (is_null($value->nilai_seleksi))
                                                                                    Input
                                                                                @else
                                                                                    Edit
                                                                                @endif Nilai
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">

                                                                                <div class="form-group">
                                                                                    <label for="nilai_kriteria1">Nilai Kriteria
                                                                                        1</label>
                                                                                    <input type="number"
                                                                                        name="nilai_kriteria1"
                                                                                        class="form-control"
                                                                                        value="{{ old('nilai_kriteria1', $value->nilai_kriteria1) }}"
                                                                                        required>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="nilai_kriteria2">Nilai Kriteria
                                                                                        2</label>
                                                                                    <input type="number"
                                                                                        name="nilai_kriteria2"
                                                                                        class="form-control"
                                                                                        value="{{ old('nilai_kriteria2', $value->nilai_kriteria2) }}"
                                                                                        required>
                                                                                </div>
                                                                                <!-- Tambah kolom penilaian lainnya jika ada -->
                                                                                <button type="submit"
                                                                                    class="btn btn-primary mt-3">
                                                                                    @if (is_null($value->nilai_seleksi))
                                                                                        Simpan
                                                                                    @else
                                                                                        Update
                                                                                    @endif Nilai
                                                                                </button>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form> --}}
                                                        <form action="{{ route('simpan-penilaian', $value->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @if (is_null($value->seleksi->nilai_seleksi))
                                                                <button type="button" class="btn btn-primary"
                                                                    data-toggle="modal"
                                                                    data-target="#inputNilaiModal{{ $value->id }}">
                                                                    <i class="fas fa-pen"></i> Input Nilai
                                                                </button>
                                                            @else
                                                                <button type="button" class="btn btn-warning"
                                                                    data-toggle="modal"
                                                                    data-target="#inputNilaiModal{{ $value->id }}">
                                                                    <i class="fas fa-edit"></i> Edit Nilai
                                                                </button>
                                                            @endif
                                                        </form>
                                                        <div class="modal fade" id="inputNilaiModal{{ $value->id }}"
                                                            tabindex="-1"
                                                            aria-labelledby="inputNilaiModalLabel{{ $value->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="inputNilaiModalLabel{{ $value->id }}">
                                                                            @if (is_null($value->nilai_seleksi))
                                                                                Input
                                                                            @else
                                                                                Edit
                                                                            @endif Nilai
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('simpan-penilaian', $value->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <div class="form-group">
                                                                                <label for="nilai_kriteria1">Nilai Kriteria
                                                                                    1</label>
                                                                                <input type="number" name="nilai_kriteria1"
                                                                                    class="form-control"
                                                                                    value="{{ old('nilai_kriteria1', $value->nilai_kriteria1) }}"
                                                                                    required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="nilai_kriteria2">Nilai Kriteria
                                                                                    2</label>
                                                                                <input type="number" name="nilai_kriteria2"
                                                                                    class="form-control"
                                                                                    value="{{ old('nilai_kriteria2', $value->nilai_kriteria2) }}"
                                                                                    required>
                                                                            </div>
                                                                            <!-- Tambah kolom penilaian lainnya jika ada -->
                                                                            <button type="submit"
                                                                                class="btn btn-primary mt-3">
                                                                                @if (is_null($value->nilai_seleksi))
                                                                                    Simpan
                                                                                @else
                                                                                    Update
                                                                                @endif Nilai
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($value->seleksi->nilai_seleksi !== null && $value->status_penerimaan === null)
                                                            @if ($key < $kuota)
                                                                <form
                                                                    action="{{ route('pendaftaran.changeStatus', ['id' => $value->id, 'status' => 1]) }}"
                                                                    method="POST" style="display: inline;">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-success"><i
                                                                            class="fas fa-check"></i></button>
                                                                </form>
                                                            @else
                                                                <form
                                                                    action="{{ route('pendaftaran.changeStatus', ['id' => $value->id, 'status' => 2]) }}"
                                                                    method="POST" style="display: inline;">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger"><i
                                                                            class="fas fa-times"></i></button>
                                                                </form>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endIsHrd
                        </div>
                    </div>
                </div>
            </div><!-- end row -->


            {{-- <div class="row mb-3">
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
                                            <a href="{{ route('getlistpendaftar', $value['lowongan_uid']) }}">
                                                <div class="card-body">
                                                    <h4 class="card-title font-16 mt-0">{{ $value['posisi'] }} ||
                                                        {{ $value['periode_judul'] }}</h4>
                                                    <p class="card-text">Jumlah Pelamar: {{ $value['jumlah_peserta'] }}
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </form>
                    @endif
                </div>
            </div> --}}

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

        // Buat title berdasarkan nilai filter
        var titleText = 'Daftar Pelamar Magang';
        if (periodeText !== 'Semua Periode') {
            titleText += ' Periode ' + periodeText;
        }
        if (posisiText !== 'Semua Posisi') {
            titleText += ' Posisi ' + posisiText;
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
                        doc.pageMargins = [20, 60, 20, 40];
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

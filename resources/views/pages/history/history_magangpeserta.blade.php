@extends('inc.main')

@section('page-title')
History Magang
@endsection

@section('breadcrumb-title')
History Magang
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    @if ($magang->isEmpty())
                    <div class="card">
                        <div class="card-block">

                            <div class="ex-page-content text-center">
                                <img src="{{ asset('admin/images/no_data.png')}}" alt="No Internships" style="width: 200px; height: auto;">

                                <h4 class="">Belum ada Kegiatan Magang</h4><br>

                                <a class="btn btn-info mb-5 waves-effect waves-light" href="/jobs"><i class="mdi mdi-magnify"></i> Jelajahi Lowongan</a>
                            </div>

                        </div>
                    </div>
                    @else
                        <div class="row">
                            @foreach ($magang as $key => $value)
                                <div class="col-lg-4">
                                    <div class="card m-b-30">
                                        @if ($value->status_penerimaan === 1)
                                            <a href="{{ route('cai-internship', $value->uid) }}">
                                        @endif
                                        <div class="card-body">
                                            <h4 class="card-title font-16 mt-0">{{ $value->lowongan->posisi->posisi }}
                                                {{-- ||
                                                {{ $value->lowongan->periode['judul_periode'] }} --}}
                                            </h4>
                                            <p class="card-text">Periode {{ $value->lowongan->periode['judul_periode'] }}
                                                ({{ \Carbon\Carbon::parse($value->lowongan->periode['tanggal_mulai'])->translatedFormat('j F Y') }}
                                                -
                                                {{ \Carbon\Carbon::parse($value->lowongan->periode['tanggal_selesai'])->translatedFormat('j F Y') }})</p>
                                        </div>
                                        <div class="card-footer text-muted">
                                            @if ($value->status_penerimaan === null)
                                                <span class="badge badge-secondary">Dalam Seleksi</span>
                                            @elseif ($value->status_penerimaan === 2)
                                                <span class="badge badge-danger">Ditolak</span>
                                            @elseif ($value->status_penerimaan === 1)
                                                @php
                                                    $today = now();
                                                    $tglMulai = \Carbon\Carbon::createFromFormat(
                                                        'Y-m-d',
                                                        $value->lowongan->periode['tanggal_mulai'],
                                                    );
                                                    $tglSelesai = \Carbon\Carbon::createFromFormat(
                                                        'Y-m-d',
                                                        $value->lowongan->periode['tanggal_selesai'],
                                                    );
                                                @endphp
                                                @if ($today < $tglMulai)
                                                    <span class="badge badge-primary">Diterima</span>
                                                @elseif ($today >= $tglMulai && $today <= $tglSelesai->endOfDay())
                                                    <span class="badge badge-success">Sedang Berlangsung</span>
                                                @elseif ($today > $tglSelesai->endOfDay())
                                                    <span class="badge badge-secondary">Selesai</span>
                                                @endif
                                            @endif
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div> <!-- content -->
    </div>

@endsection

@extends('inc.main')

@section('page-title')
    Dashboard
@endsection

@section('breadcrumb-title')
    Dashboard
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            @if ($belumDiproses)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Terdapat {{ $totalPelamarPending }} peserta yang perlu diproses.
                </div>
            @elseif ($semuaDiproses)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Semua peserta telah diproses.
                </div>
            @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="fas fa-user-clock float-right"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3">Perlu Diproses</h6>
                            <h4 class="mb-4">{{ $totalPelamarPending }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="fas fa-user-check float-right"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3">Lolos Seleksi</h6>
                            <h4 class="mb-4">{{ $totalPelamarDirekomendasikan }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="fas fa-user-times float-right"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3">Tidak Lolos Seleksi</h6>
                            <h4 class="mb-4">{{ $totalPelamarTidakDirekomendasikan }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        Pelamar Terbaru
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Posisi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelamarTerbaru as $pelamar)
                                    <tr>
                                        <td>{{ $pelamar->peserta->nama }}</td>
                                        <td>{{ $pelamar->lowongan->posisi->posisi }}</td>
                                        <td>{{ $pelamar->status_penerimaan == 1 ? 'Diterima' : 'Belum Diproses' }}</td>
                                        <td>
                                            <!-- Aksi untuk melihat detail pelamar atau mengambil tindakan -->
                                            <a href="{{ route('getlistpendaftar', ['uid' => $pelamar->lowongan->uid]) }}" class="btn btn-info btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

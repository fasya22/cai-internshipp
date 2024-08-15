@extends('inc.main')

@section('page-title')
    Dashboard
@endsection

@section('breadcrumb-title')
    Dashboard
@endsection


@section('content')
    <style>
        .icon-container {
            display: flex;
            align-items: center;
            height: 100%;
        }
    </style>
    <div class="container-fluid">
        {{-- <h1 class="mb-4">Dashboard Admin</h1> --}}

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="fas fa-user-graduate float-right"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3">Peserta</h6>
                            <h4 class="mb-4">{{ $totalPeserta }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="fas fa-chalkboard-teacher float-right"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3">Mentor</h6>
                            <h4 class="mb-4">{{ $totalMentor }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="fas fa-user-tie float-right"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3">HRD</h6>
                            <h4 class="mb-4">{{ $totalHrd }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="fas fa-briefcase float-right"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3">Posisi Magang</h6>
                            <h4 class="mb-4">{{ $totalPosisi }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex align-items-stretch">
            <div class="col-lg-6 d-flex">
                <div class="card w-100">
                    <div class="card-body">
                        <h4 class="mt-0 m-b-30 header-title">Pelamar Terbaru</h4>
                        @if ($pelamarTerbaru->isEmpty())
                        <div class="alert alert-success fade show" role="alert">
                            Semua Data Sudah Diproses
                        </div>
                        @else
                            <div class="table-responsive border-0">
                                <table class="table table-vertical">
                                    <tbody>
                                        @foreach ($pelamarTerbaru as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->peserta->nama }}</td>
                                                <td>{{ $value->lowongan->posisi->posisi }}</td>
                                                {{-- <td>{{ $value->status_penerimaan == 1 ? 'Diterima' : 'Pending' }}</td> --}}
                                                <td>{{ $value->created_at->translatedFormat('j F Y') }}</td>
                                                <td>
                                                    <a href="{{ route('getlistpendaftar', ['uid' => $value->lowongan->uid]) }}"
                                                        class="btn btn-info btn-sm">Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-6 d-flex">
                <div class="card w-100">
                    <div class="card-body">
                        <h4 class="mt-0 m-b-30 header-title">Perlu Update Status Penerimaan</h4>
                        @if ($perluAcc->isEmpty())
                            <div class="alert alert-success fade show" role="alert">
                                Semua Data Sudah Diproses
                            </div>
                        @else
                            <div class="table-responsive border-0">
                                <table class="table table-vertical">
                                    <tbody>
                                        @foreach ($perluAcc as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->peserta->nama }}</td>
                                                <td>{{ $value->lowongan->posisi->posisi }}</td>
                                                <td>
                                                    @if ($value->status_rekomendasi == 2)
                                                        <span class="badge badge-success">Direkomendasikan</span>
                                                    @else
                                                        <span class="badge badge-danger">Tidak Direkomendasikan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('getlistpendaftar', ['uid' => $value->lowongan->uid]) }}"
                                                        class="btn btn-info btn-sm">Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div> --}}
            <div class="col-lg-6 d-flex">
                <div class="card w-100">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Rekapitulasi Project</h4>

                        <ul class="list-inline widget-chart m-t-20 m-b-15 text-center">
                            <li class="list-inline-item">
                                <h5 class="mb-0">{{ $totalProgress }}</h5>
                                <p class="text-muted">Progress</p>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="mb-0">{{ $totalSelesai }}</h5>
                                <p class="text-muted">Selesai</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row d-flex align-items-stretch">
            <div class="col-lg-6 d-flex">
                <div class="card w-100">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Rekapitulasi Project</h4>

                        <ul class="list-inline widget-chart m-t-20 m-b-15 text-center">
                            <li class="list-inline-item">
                                <h5 class="mb-0">{{ $totalProgress }}</h5>
                                <p class="text-muted">Progress</p>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="mb-0">{{ $totalSelesai }}</h5>
                                <p class="text-muted">Selesai</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex">
                <div class="card w-100">
                    <div class="card-body">
                        <h4 class="mt-0 m-b-30 header-title">Perlu Update Mentor Peserta</h4>
                        @if ($mentorBelumDitentukan->isEmpty())
                        <div class="alert alert-success fade show" role="alert">
                            Semua Data Sudah Diproses
                        </div>
                        @else
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Terdapat {{ $totalMentorBelumDitentukan }} peserta perlu update mentor.
                        </div>
                            <div class="table-responsive border-0">
                                <table class="table table-vertical">
                                    <tbody>
                                        @foreach ($mentorBelumDitentukan as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->peserta->nama }}</td>
                                                <td>{{ $value->lowongan->posisi->posisi }}</td>
                                                <td>
                                                    @if ($value->mentor)
                                                        {{ $value->mentor }}
                                                    @else
                                                        <span class="badge badge-warning">Mentor belum ditentukan</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-lg-6">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Total Peserta per Periode</h4>

                        <div class="form-group">
                            <select class="form-control" id="periodeSelect">
                                <option value="">Pilih Periode</option>
                                @foreach ($daftarPeriode as $id => $judul_periode)
                                    <option value="{{ $id }}">{{ $judul_periode }}</option>
                                @endforeach
                            </select>
                        </div>

                        <canvas id="barChart"></canvas>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Total Peserta per Posisi</h4>

                        <div class="form-group">
                            <select class="form-control" id="posisiSelect">
                                <option value="">Pilih Posisi</option>
                                @foreach ($daftarPosisi as $id => $nama_posisi)
                                    <option value="{{ $id }}">{{ $nama_posisi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <canvas id="pesertaPeriodeChart"></canvas>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('pesertaPeriodeChart').getContext('2d');
            var pesertaPeriodeChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Jumlah Peserta',
                        data: [],
                        fill: false,
                        backgroundColor: '#322b62',
                        borderColor: '322b62',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var posisiSelect = document.getElementById('posisiSelect');

            posisiSelect.addEventListener('change', function() {
                var posisiId = this.value;
                if (posisiId) {
                    fetch(`/home/posisi/${posisiId}`)
                        .then(response => response.json())
                        .then(data => {
                            var labels = Object.keys(data);
                            var datasetsData = Object.values(data);

                            // Update the chart data
                            pesertaPeriodeChart.data.labels = labels;
                            pesertaPeriodeChart.data.datasets[0].data = datasetsData;
                            pesertaPeriodeChart.update();
                        });
                } else {
                    pesertaPeriodeChart.data.labels = [];
                    pesertaPeriodeChart.data.datasets[0].data = [];
                    pesertaPeriodeChart.update();
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('barChart').getContext('2d');
            var barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Jumlah Peserta',
                        data: [],
                        backgroundColor: '#322b62',
                        borderColor: '#322b62',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var periodeSelect = document.getElementById('periodeSelect');

            periodeSelect.addEventListener('change', function() {
                var periodeId = this.value;
                if (periodeId) {
                    fetch(`/home/periode/${periodeId}`)
                        .then(response => response.json())
                        .then(data => {
                            var labels = Object.keys(data);
                            var datasetsData = Object.values(data);

                            // Update the chart data
                            barChart.data.labels = labels;
                            barChart.data.datasets[0].data = datasetsData;
                            barChart.update();
                        });
                } else {
                    barChart.data.labels = [];
                    barChart.data.datasets[0].data = [];
                    barChart.update();
                }
            });
        });
    </script>
@endsection

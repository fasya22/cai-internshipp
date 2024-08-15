@extends('inc.main')

@section('page-title')
    Dashboard
@endsection

@section('breadcrumb-title')
    Dashboard
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            @if (!$magang || $magang->status_penerimaan != 1)
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="ex-page-content text-center">
                                    <img src="{{ asset('admin/images/wellcome.png') }}" alt="Halloo" class="img-fluid"
                                        style="width: 500px; height: auto;">
                                    <h4 class="">Halloo!!! Selamat Datang di CAI-Internship!!</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-xl-12">
                        @if (!$projectsReminder->isEmpty())
                            <div class="alert alert-warning" role="alert">
                                <h6 class="alert-heading">Reminder!!!</h6>
                                <ul>
                                    @foreach ($projectsReminder as $project)
                                        <li>{{ $project->nama_project }} - Deadline:
                                            {{ \Carbon\Carbon::parse($project->deadline)->translatedFormat('j F Y') }}
                                            ({{ \Carbon\Carbon::parse($project->deadline)->diffForHumans() }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                @if (!empty($logbookReminder))
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="alert alert-warning">
                                <h6>Ada logbook yang belum diisi!!!! Isi sekarang yuk!!!</h6>
                                <ul>
                                    @foreach ($logbookReminder as $date)
                                        <li>{{ $date }} <span>(Belum ada aktivitas)</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-xl-3 col-md-6 d-flex">
                        <div class="card mini-stat bg-primary w-100">
                            <div class="card-body mini-stat-img">
                                <div class="mini-stat-icon">
                                    <i class="fas fa-clipboard-list float-right"></i>
                                </div>
                                <div class="text-white">
                                    <h6 class="text-uppercase mb-3">Belum Dikumpulkan</h6>
                                    <h4 class="mb-4">{{ $projectCount['in_progress'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex">
                        <div class="card mini-stat bg-primary w-100">
                            <div class="card-body mini-stat-img">
                                <div class="mini-stat-icon">
                                    <i class="fas fa-clock float-right"></i>
                                </div>
                                <div class="text-white">
                                    <h6 class="text-uppercase mb-3">Menunggu Review</h6>
                                    <h4 class="mb-4">{{ $projectCount['menunggu_review'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex">
                        <div class="card mini-stat bg-primary w-100">
                            <div class="card-body mini-stat-img">
                                <div class="mini-stat-icon">
                                    <i class="fas fa-edit float-right"></i>
                                </div>
                                <div class="text-white">
                                    <h6 class="text-uppercase mb-3">Perlu Perbaikan</h6>
                                    <h4 class="mb-4">{{ $projectCount['revisi'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex">
                        <div class="card mini-stat bg-primary w-100">
                            <div class="card-body mini-stat-img">
                                <div class="mini-stat-icon">
                                    <i class="fas fa-check-circle float-right"></i>
                                </div>
                                <div class="text-white">
                                    <h6 class="text-uppercase mb-3">Selesai</h6>
                                    <h4 class="mb-4">{{ $projectCount['completed'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex align-items-stretch">
                    <div class="col-lg-4 d-flex">
                        <div class="card w-100">
                            <div class="card-body">
                                <h5 class="header-title">Belum Mengumpulkan</h5>
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul Proyek</th>
                                                <th>Deadline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($projectsInProgress as $index => $project)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $project->nama_project }}</td>
                                                    <td>{{ $project->deadline }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex">
                        <div class="card w-100">
                            <div class="card-body">
                                <h5 class="header-title">Perlu Perbaikan</h5>
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul Proyek</th>
                                                <th>Deadline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($perluPerbaikan as $index => $project)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $project->nama_project }}</td>
                                                    <td>{{ $project->deadline }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex">
                        <!-- Ringkasan Proyek Telah Selesai -->
                        <div class="card w-100">
                            <div class="card-body">
                                <h5 class="header-title">Proyek yang Telah Selesai</h5>
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul Proyek</th>
                                                <th>Tanggal Selesai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($completedProjects as $index => $project)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $project->nama_project }}</td>
                                                    <td>{{ $project->tgl_pengumpulan }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection

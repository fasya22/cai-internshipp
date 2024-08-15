@extends('inc.main')

@section('page-title')
Kegiatan Magang
@endsection

@section('breadcrumb-title')
Kegiatan Magang
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    @IsPeserta
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="card mini-stat bg-primary">
                                <div class="card-body">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-buffer float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h5 class="text-uppercase mb-3">Logbook</h5>
                                    </div>
                                    <a href="{{ route('logbook.index', ['magang_uid' => $magang->uid]) }}">
                                        <button type="button" class="btn btn-light">
                                            <b>Detail <i class="far fa-arrow-alt-circle-right"></i></b>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="card mini-stat bg-primary">
                                <div class="card-body">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-buffer float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h5 class="text-uppercase mb-3">Project</h5>
                                    </div>
                                    <a href="{{ route('project.index', ['magang_uid' => $magang->uid]) }}">
                                        <button type="button" class="btn btn-light">
                                            <b>Detail <i class="far fa-arrow-alt-circle-right"></i></b>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="card mini-stat bg-primary">
                                <div class="card-body">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-buffer float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h5 class="text-uppercase mb-3">Penilaian</h5>
                                    </div>
                                    <a href="{{ route('penilaian.index', ['magang_uid' => $magang->uid]) }}">
                                        <button type="button" class="btn btn-light">
                                            <b>Detail <i class="far fa-arrow-alt-circle-right"></i></b>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endIsPeserta
                    @IsMentor
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="card mini-stat bg-primary">
                                <div class="card-body">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-buffer float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h5 class="text-uppercase mb-3">Peserta</h5>
                                    </div>
                                    <a href="{{ route('getlistpeserta', ['lowongan_uid' => $lowongan->uid]) }}">
                                        <button type="button" class="btn btn-light">
                                            <b>Detail <i class="far fa-arrow-alt-circle-right"></i></b>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card mini-stat bg-primary">
                                <div class="card-body">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-buffer float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h5 class="text-uppercase mb-3">Logbook</h5>
                                    </div>
                                    <a href="{{ route('data-logbook.index', ['uid' => $lowongan->uid]) }}">
                                        <button type="button" class="btn btn-light">
                                            <b>Detail <i class="far fa-arrow-alt-circle-right"></i></b>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card mini-stat bg-primary">
                                <div class="card-body">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-buffer float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h5 class="text-uppercase mb-3">Project</h5>
                                    </div>
                                    <a href="{{ route('data-project.index', ['uid' => $lowongan->uid]) }}">
                                        <button type="button" class="btn btn-light">
                                            <b>Detail <i class="far fa-arrow-alt-circle-right"></i></b>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card mini-stat bg-primary">
                                <div class="card-body">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-buffer float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h5 class="text-uppercase mb-3">Penilaian</h5>
                                    </div>
                                    <a href="{{ route('data-penilaian.index', ['uid' => $lowongan->uid]) }}">
                                        <button type="button" class="btn btn-light">
                                            <b>Detail <i class="far fa-arrow-alt-circle-right"></i></b>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endIsMentor
                    @IsAdmin
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="card mini-stat bg-primary">
                                <div class="card-body">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-buffer float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h5 class="text-uppercase mb-3">Peserta</h5>
                                    </div>
                                    <a href="{{ route('getlistpeserta', ['lowongan_uid' => $lowongan->uid]) }}">
                                        <button type="button" class="btn btn-light">
                                            <b>Detail <i class="far fa-arrow-alt-circle-right"></i></b>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card mini-stat bg-primary">
                                <div class="card-body">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-buffer float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h5 class="text-uppercase mb-3">Logbook</h5>
                                    </div>
                                    <a href="{{ route('data-logbook.index', ['uid' => $lowongan->uid]) }}">
                                        <button type="button" class="btn btn-light">
                                            <b>Detail <i class="far fa-arrow-alt-circle-right"></i></b>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card mini-stat bg-primary">
                                <div class="card-body">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-buffer float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h5 class="text-uppercase mb-3">Project</h5>
                                    </div>
                                    <a href="{{ route('data-project.index', ['uid' => $lowongan->uid]) }}">
                                        <button type="button" class="btn btn-light">
                                            <b>Detail <i class="far fa-arrow-alt-circle-right"></i></b>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card mini-stat bg-primary">
                                <div class="card-body">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-buffer float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h5 class="text-uppercase mb-3">Penilaian</h5>
                                    </div>
                                    <a href="{{ route('data-penilaian.index', ['uid' => $lowongan->uid]) }}">
                                        <button type="button" class="btn btn-light">
                                            <b>Detail <i class="far fa-arrow-alt-circle-right"></i></b>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endIsAdmin


                </div>
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->

    </div> <!-- content -->
@endsection

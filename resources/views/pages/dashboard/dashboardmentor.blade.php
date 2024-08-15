@extends('inc.main')

@section('page-title')
    Dashboard
@endsection

@section('breadcrumb-title')
    Dashboard
@endsection

{{-- @section('content')
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Dashboard</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            halo mentor
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- end row -->



    </div> <!-- container-fluid -->

</div> <!-- content -->
@endsection --}}

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="fas fa-user-clock float-right"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3">Total Peserta</h6>
                            <h4 class="mb-4">{{ $totalPeserta }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="fas fa-user-check float-right"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3">Total Kegiatan Magang</h6>
                            <h4 class="mb-4">{{ $jumlahKegiatanMagang }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card mini-stat bg-primary w-100">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="fas fa-clipboard-list float-right"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3">Belum Dikumpulkan</h6>
                            <h4 class="mb-4">{{ $totalProyekBelumDikumpulkan }}</h4>
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
                            <h4 class="mb-4">{{ $totalProyekMenungguReview }}</h4>
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
                            <h4 class="mb-4">{{ $totalProyekPerbaikan }}</h4>
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
                            <h4 class="mb-4">{{ $totalProyekSelesai }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

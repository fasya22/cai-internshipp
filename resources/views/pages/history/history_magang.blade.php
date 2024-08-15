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

            <div class="row mb-3">
                <div class="col-12">
                    <form action="{{ route('historyMagangMentor') }}" method="GET">
                        <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                <label for="posisi">Posisi:</label>
                                <select class="form-control" id="posisi" name="posisi">
                                    <option value="">Semua Posisi</option>
                                    @foreach ($listPosisi as $item)
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
                                    @foreach ($listPeriode as $item)
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

                                    <h4 class="">Belum ada kegiatan magang</h4><br>
                                </div>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('filterHistory') }}" method="GET">
                            <div class="row">
                                @foreach ($magangData as $data)
                                    <div class="col-lg-4">
                                        <div class="card m-b-30">
                                            <a href="{{ route('kegiatan-magang', $data['lowongan_uid']) }}">
                                                <div class="card-body">
                                                    <h4 class="card-title font-16 mt-0">{{ $data['posisi'] }} ||
                                                        {{ $data['periode_judul'] }}</h4>
                                                    <p class="card-text">Jumlah Peserta:
                                                        {{ $data['jumlah_peserta'] }}</p>
                                                </div>
                                                <div class="card-footer text-muted">
                                                    @if ($data['status'] == 'Belum Dimulai')
                                                        <span class="badge badge-primary">Belum Dimulai</span>
                                                    @elseif ($data['status'] == 'Sedang Berlangsung')
                                                        <span class="badge badge-success">Sedang Berlangsung</span>
                                                    @elseif ($data['status'] == 'Selesai')
                                                        <span class="badge badge-secondary">Selesai</span>
                                                    @endif
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
        </div>
    </div>
@endsection

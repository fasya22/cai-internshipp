@extends('inc.main')

@section('page-title')
    Logbook
@endsection

@section('breadcrumb-title')
    Logbook
@endsection

@section('content')

    <style>
        .elm {
            overflow-wrap: break-word;
            word-break: break-word;
        }
    </style>
    <div class="content">
        <div class="container-fluid">

            @IsPeserta
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-20">
                            <div class="card-body">
                                @if ($logbooks->isNotEmpty())
                                    <a href="{{ route('cetakLogbook', ['magang_uid' => $magang_uid]) }}" target="_blank"
                                        class="btn btn-primary">Cetak Logbook</a>
                                @endif
                                <form action="{{ route('logbook.store', ['magang_uid' => $magang_uid]) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div id="myModal" class="modal fade" tabindex="-1" role="dialog"
                                        aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title mt-0" id="myModalLabel">Isi Logbook</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Tanggal</label>
                                                        <div>
                                                            <input type="date" class="form-control" id="tanggal-logbook"
                                                                name="tanggal" readonly />
                                                            @error('tanggal')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Aktivitas</label>
                                                        <div>
                                                            <textarea id="aktivitas" name="aktivitas"></textarea>
                                                            @error('aktivitas')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </form>
                                @foreach ($logbooks as $logbook)
                                <form action="{{ route('logbook.update', ['magang_uid' => $magang_uid, 'id' => $logbook->uid]) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div id="revisi{{ $logbook->id }}" class="modal fade" tabindex="-1" role="dialog"
                                        aria-labelledby="revisi{{ $logbook->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title mt-0" id="revisi{{ $logbook->id }}">Isi Logbook</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        @if ($logbook->tanggal && $logbook->status === 2)
                                                            <p class="card-text mb-3"><b>Feedback
                                                                    :</b>
                                                                {!! $logbook->feedback !!}</p>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tanggal</label>
                                                        <div>
                                                            <input type="date" class="form-control" id="tanggal-logbook"
                                                                   name="tanggal" value="{{ $logbook->tanggal }}" readonly />
                                                            @error('tanggal')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Aktivitas</label>
                                                        <div>
                                                            <textarea id="aktivitas" name="aktivitas">{{ old('aktivitas', $logbook->aktivitas) }}</textarea>
                                                            @error('aktivitas')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </form>
                                @endforeach
                                <ol class="activity-feed mb-0">
                                    @foreach ($dates as $index => $date)
                                        @php
                                            $logbook = $logbooks->where('tanggal', $date)->first();
                                        @endphp
                                        <li class="feed-item">
                                            <div class="feed-item-list">
                                                <span
                                                    class="date">{{ \Carbon\Carbon::parse($date)->translatedFormat('j F Y') }}</span>
                                                <p class="activity-text mb-1">{!! $logbook ? $logbook->aktivitas : 'Belum ada aktivitas' !!}</p>
                                                {{-- @if ($logbook)
                                                    <a href="#"><button type="button" class="btn btn-warning"><i
                                                                class="far fa-edit"></i></button></a>
                                                @elseif (\Carbon\Carbon::parse($date)->gt($today))
                                                @else
                                                    <button type="button" class="btn btn-primary open-logbook-modal"
                                                        data-toggle="modal" data-target="#myModal"
                                                        data-tanggal="{{ $date }}">Isi Logbook</button>
                                                @endif --}}

                                                @if ($logbook)
                                                    @if ($logbook->status === null || $logbook->status === 3)
                                                        <button type="button" class="btn btn-info">Menunggu Review</button>
                                                    @elseif ($logbook->status == 2)
                                                        <button type="button" class="btn btn-warning open-logbook-modal"
                                                            data-toggle="modal" data-target="#revisi{{ $logbook->id }}"
                                                            data-tanggal="{{ $date }}">Perlu Perbaikan</button>
                                                    @elseif ($logbook->status == 1)
                                                        <button type="button" class="btn btn-success">Disetujui</button>
                                                    @endif
                                                @else
                                                    @if (\Carbon\Carbon::parse($date)->gt($today))
                                                        <!-- Tidak ada tombol untuk tanggal yang lebih dari hari ini -->
                                                    @else
                                                        <button type="button" class="btn btn-primary open-logbook-modal"
                                                            data-toggle="modal" data-target="#myModal"
                                                            data-tanggal="{{ $date }}">Isi Logbook</button>
                                                    @endif
                                                @endif
                                            </div>

                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            @endIsPeserta

            @IsMentor
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <!-- sample modal content -->
                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <form method="GET"
                                            action="{{ route('data-logbook.index', ['uid' => $lowongan_uid]) }}">
                                            <div class="form-group">
                                                <label for="form-control">Peserta</label>
                                                <select class="form-control select2" name="peserta"
                                                    onchange="this.form.submit()">
                                                    <option value="">Pilih Peserta</option>
                                                    @foreach ($pesertas as $peserta)
                                                        <option value="{{ $peserta->id }}"
                                                            {{ $peserta->id == $selectedPesertaId ? 'selected' : '' }}>
                                                            {{ $peserta->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                @if ($selectedPesertaId)
                                @foreach ($logbooks as $logbook)
                                    <form
                                        action="{{ route('logbook.updateStatusAndFeedback', ['id' => $logbook->uid, 'uid' => $lowongan_uid]) }}"
                                        method="POST" enctype="multipart/form-data" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <!-- Modal Edit -->
                                        <div class="modal fade bs-example-modal-lg" id="reviewMentor{{ $logbook->id }}"
                                            tabindex="-1" role="dialog" aria-labelledby="reviewMentor{{ $logbook->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="reviewMentor{{ $logbook->id }}">
                                                            Review
                                                            Logbook
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <p class="card-text mb-1"><b>Nama
                                                                    Peserta :</b>
                                                                {{ $logbook->magang->peserta['nama'] }}
                                                            </p>
                                                            <p class="card-text"><b>Tanggal
                                                                    :</b>
                                                                {{ \Carbon\Carbon::parse($logbook->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                                            </p>
                                                            @if ($logbook->tanggal && $logbook->status === 2)
                                                                <p class="card-text mb-3"><b>Feedback
                                                                        :</b>
                                                                    {!! $logbook->feedback !!}</p>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <select id="changestatus"
                                                                class="form-control @error('status') is-invalid @enderror"
                                                                name="status">
                                                                <option value="1"
                                                                    {{ $logbook->status == 1 ? 'selected' : '' }}>
                                                                    Disetujui</option>
                                                                <option value="2"
                                                                    {{ $logbook->status == 2 ? 'selected' : '' }}>
                                                                    Perbaikan</option>
                                                            </select>
                                                            @error('status')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Feedback</label>
                                                            <div>
                                                                <textarea id="feedback" name="feedback" required></textarea>
                                                                @error('feedback')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    @endforeach
                                    <ol class="activity-feed mb-0">
                                        @foreach ($dates as $index => $date)
                                            @php
                                                $logbook = $logbooks->where('tanggal', $date)->first();
                                            @endphp
                                            <li class="feed-item">
                                                <div class="feed-item-list">
                                                    <span
                                                        class="date">{{ \Carbon\Carbon::parse($date)->translatedFormat('j F Y') }}</span>
                                                    <p class="activity-text mb-1">{!! $logbook ? $logbook->aktivitas : 'Belum ada aktivitas' !!}</p>
                                                    @if ($logbook)
                                                        @if ($logbook->status === null || $logbook->status === 3)
                                                        <button type="button" class="btn btn-info open-logbook-modal"
                                                        data-toggle="modal"
                                                        data-target="#reviewMentor{{ $logbook->id }}"
                                                        data-tanggal="{{ $date }}">Review Logbook</button>
                                                        @elseif ($logbook->status == 2)
                                                            <button type="button" class="btn btn-warning">Perlu
                                                                Perbaikan</button>
                                                        @elseif ($logbook->status == 1)
                                                            <button type="button" class="btn btn-success">Disetujui</button>
                                                        @endif
                                                    @else
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ol>
                                @else
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="ex-page-content text-center">
                                                <img src="{{ asset('admin/images/select.jpg') }}" alt="No Internships"
                                                    style="width: 200px; height: auto;">

                                                <h4 class="">Pilih Peserta untuk melihat logbook</h4><br>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div><!-- end row -->
                </div>
            @endIsMentor

            @IsAdmin
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <!-- sample modal content -->
                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <form method="GET"
                                            action="{{ route('data-logbook.index', ['uid' => $lowongan_uid]) }}">
                                            <div class="form-group">
                                                <label for="form-control">Peserta</label>
                                                <select class="form-control select2" name="peserta"
                                                    onchange="this.form.submit()">
                                                    <option value="">Pilih Peserta</option>
                                                    @foreach ($pesertas as $peserta)
                                                        <option value="{{ $peserta->id }}"
                                                            {{ $peserta->id == $selectedPesertaId ? 'selected' : '' }}>
                                                            {{ $peserta->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @if ($selectedPesertaId)
                                    <ol class="activity-feed mb-0">
                                        @foreach ($dates as $index => $date)
                                            @php
                                                $logbook = $logbooks->where('tanggal', $date)->first();
                                            @endphp
                                            <li class="feed-item">
                                                <div class="feed-item-list">
                                                    <span
                                                        class="date">{{ \Carbon\Carbon::parse($date)->translatedFormat('j F Y') }}</span>
                                                    <p class="activity-text mb-1">{!! $logbook ? $logbook->aktivitas : 'Belum ada aktivitas' !!}</p>

                                                </div>

                                            </li>
                                        @endforeach
                                    </ol>
                                @else
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="ex-page-content text-center">
                                                <img src="{{ asset('admin/images/select.jpg') }}" alt="No Internships"
                                                    style="width: 200px; height: auto;">

                                                <h4 class="">Pilih Peserta untuk melihat logbook</h4><br>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div><!-- end row -->
                </div>
            @endIsAdmin




        </div> <!-- container-fluid -->

    </div> <!-- content -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let tableCells = document.querySelectorAll(".elm");

            tableCells.forEach(function(cell) {
                cell.style.whiteSpace = "normal";
                cell.style.wordWrap = "break-word";
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Update tanggal-logbook input when Isi Logbook button is clicked
            $('.open-logbook-modal').on('click', function() {
                var tanggal = $(this).data('tanggal');
                $('#tanggal-logbook').val(tanggal);
            });
        });
    </script>

@endsection

@extends('inc.main')

@section('page-title')
    Project Magang
@endsection

@section('breadcrumb-title')
    Project
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
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    @if ($projects->isEmpty())
                                        <div class="col-12">
                                            <div class="ex-page-content text-center">
                                                <img src="{{ asset('admin/images/no_data.png') }}" alt="No Internships"
                                                    style="width: 200px; height: auto;">

                                                <h4 class="">Belum ada Project</h4><br>
                                            </div>
                                        </div>
                                    @else
                                        @foreach ($projects as $key => $project)
                                            <div class="col-lg-4 mb-4">
                                                <div class="card m-b-30" style="height: 100%;">
                                                    <div class="card-header d-flex justify-content-between align-items-center"
                                                        style="background-color: #322b62">
                                                        <h4 class="font-16 mt-0" style="color: white">
                                                            {{ $project->nama_project }}
                                                            <span class="ml-1" style="font-size: 11px; font-style: italic">
                                                                (Deadline:
                                                                {{ \Carbon\Carbon::parse($project->deadline)->locale('id')->isoFormat('D MMMM YYYY [jam] HH:mm') }})
                                                            </span>
                                                        </h4>
                                                    </div>
                                                    <div class="card-body"
                                                        style="height: 100%; display: flex; flex-direction: column; background-color: #F7F7FD; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);">
                                                        <p class="card-text elm"
                                                            style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; height: 3.6em;">
                                                            {!! strip_tags($project->deskripsi) !!}
                                                        </p>
                                                        @if ($project->tgl_pengumpulan === null && \Carbon\Carbon::now()->greaterThan($project->deadline))
                                                            <!-- Jika hari ini sudah melewati deadline dan belum mengumpulkan -->
                                                            <button type="button" class="btn btn-danger"
                                                                style="cursor: default;">
                                                                <i class="far fa-times-circle"></i> Tidak Mengumpulkan
                                                            </button>
                                                        @elseif ($project->tgl_pengumpulan)
                                                            @if ($project->status === null || $project->status == 2)
                                                                <!-- Menunggu review -->
                                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                                    data-target="#showModalPeserta{{ $project->id }}">
                                                                    <i class="far fa-clock"></i> Menunggu Review Mentor
                                                                </button>
                                                            @elseif ($project->status == 1)
                                                                <!-- Disetujui -->
                                                                <button type="button" class="btn btn-success"
                                                                    data-toggle="modal"
                                                                    data-target="#showModalPeserta{{ $project->id }}">
                                                                    <i class="far fa-check-circle"></i> Disetujui Mentor
                                                                </button>
                                                            @endif
                                                        @else
                                                            <!-- Belum melewati deadline -->
                                                            @if ($project->status == 2)
                                                                <button type="button" class="btn btn-warning"
                                                                    data-toggle="modal"
                                                                    data-target="#editModalPeserta{{ $project->id }}">
                                                                    <i class="far fa-edit"></i> Perbaiki
                                                                </button>
                                                            @else
                                                                <button type="button" class="btn btn-primary"
                                                                    data-toggle="modal"
                                                                    data-target="#editModalPeserta{{ $project->id }}">
                                                                    <i class="far fa-edit"></i> Kumpulkan Project
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editModalPeserta{{ $project->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="editModalLabel{{ $project->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $project->id }}">
                                                                Kumpulkan Project</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <p class="card-text"><b>Nama Peserta :</b>
                                                                    {{ $project->magang->peserta->nama }}</p>
                                                                <p class="card-text"><b>Project :</b>
                                                                    {{ $project->nama_project }}</p>
                                                                <p class="card-text"><b>Deskripsi Project :</b>
                                                                    {!! $project->deskripsi !!}</p>
                                                                @if ($project->tgl_pengumpulan === null && $project->status == 2)
                                                                    <p class="card-text"><b>Perbaikan :</b>
                                                                        {{ $project->feedback }}</p>
                                                                @endif
                                                            </div>
                                                            <form
                                                                action="{{ route('project.updateProjectPeserta', $project->uid) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="editProject{{ $project->id }}">Tanggal
                                                                        Pengumpulan</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                        id="editProject{{ $project->id }}"
                                                                        name="tgl_pengumpulan"
                                                                        value="{{ $project->tgl_pengumpulan ? date('Y-m-d\TH:i', strtotime($project->tgl_pengumpulan)) : now()->format('Y-m-d\TH:i') }}"
                                                                        required readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="link_project">Link Project</label>
                                                                    <input type="url" class="form-control" id="link_project"
                                                                        name="link_project"
                                                                        value="{{ $project->link_project }}" required>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Kirim</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Show -->
                                            <div class="modal fade" id="showModalPeserta{{ $project->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="showModalPeserta{{ $project->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="showModalPeserta{{ $project->id }}">
                                                                Detail Project</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <p class="card-text mb-2"><b>Nama Peserta :</b>
                                                                    {{ $project->magang->peserta->nama }}</p>
                                                                <p class="card-text mb-2"><b>Project :</b>
                                                                    {{ $project->nama_project }}</p>
                                                                <p class="card-text mb-2"><b>Deskripsi Project :</b>
                                                                    {!! $project->deskripsi !!}</p>
                                                                <p class="card-text mb-2"><b>Batas Pengumpulan
                                                                        :</b>
                                                                    {{ \Carbon\Carbon::parse($project->deadline)->translatedFormat('l, d F Y H:i') }}
                                                                </p>
                                                                <p class="card-text mb-2"><b>Tanggal Pengumpulan
                                                                        :</b>
                                                                    {{ \Carbon\Carbon::parse($project->tgl_pengumpulan)->translatedFormat('l, d F Y H:i') }}
                                                                </p>
                                                                <p class="card-text mb-2"><b>Status :</b>
                                                                    @if (is_null($project->status) || $project->status == 2)
                                                                        Menunggu review mentor
                                                                    @elseif ($project->status == 1)
                                                                        Disetujui
                                                                    @endif
                                                                </p>

                                                                <p class="card-text mb-3"><b>Feedback :</b>
                                                                    {{ $project->feedback }}</p>

                                                                <a href="{{ $project->link_project }}"
                                                                    target="_blank"><button type="button"
                                                                        class="btn btn-secondary">
                                                                        <i class="fas fa-link mr-1"></i>
                                                                        Link Project</button></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            @endIsPeserta
            @IsMentor
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                @if ($is_within_period)
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-toggle="modal" data-target="#myModal">Tambah Data</button>
                                    </div>
                                @endif

                                <!-- sample modal content -->
                                <form action="{{ route('data-project.store', ['uid' => $lowongan_uid]) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Tambah Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="lowongan_id" value="{{ $lowongan_uid }}">
                                                    <div class="form-group">
                                                        <label>Peserta</label>
                                                        <select name="magang_id" class="form-control" required>
                                                            <option value="">Pilih salah satu</option>
                                                            @foreach ($pesertas as $peserta)
                                                                @if ($peserta->magang)
                                                                    <option value="{{ $peserta->magang->id }}">
                                                                        {{ $peserta->nama }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Project</label>
                                                        <div>
                                                            <input type="text" class="form-control" name="nama_project"
                                                                required placeholder="" />
                                                            @error('nama_project')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Deskripsi</label>
                                                        <div>
                                                            <textarea id="deskripsi" name="deskripsi" required></textarea>
                                                            @error('deskripsi')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="deadline">Batas Pengumpulan</label>
                                                        <div>
                                                            <input type="datetime-local" class="form-control" id="deadline"
                                                                name="deadline" required placeholder="" />
                                                            @error('deadline')
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
                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <form method="GET"
                                            action="{{ route('data-project.index', ['uid' => $lowongan_uid]) }}">

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
                                    <div class="row">
                                        @if ($projects->isEmpty())
                                            <div class="col-12">
                                                <div class="ex-page-content text-center">
                                                    <img src="{{ asset('admin/images/no_data.png') }}" alt="No Internships"
                                                        style="width: 200px; height: auto;">

                                                    <h4 class="">Belum ada Project</h4><br>
                                                </div>
                                            </div>
                                        @else
                                            @foreach ($projects as $key => $value)
                                                <div class="col-lg-4 mb-4">
                                                    <div class="card m-b-30" style="height: 100%;">
                                                        <div class="card-header d-flex justify-content-between align-items-center"
                                                            style="background-color: #322b62">
                                                            <h4 class="font-16 mt-0" style="color: white">
                                                                {{ $value->nama_project }} <span class="ml-1"
                                                                    style="font-size: 11px; font-style: italic">(Deadline :
                                                                    {{ \Carbon\Carbon::parse($value->deadline)->locale('id')->isoFormat('D MMMM Y') }})</span>
                                                            </h4>
                                                            <div class="d-flex">
                                                                <form
                                                                    action="{{ route('data-project.update', ['id' => $value->uid, 'uid' => $lowongan_uid]) }}"
                                                                    method="POST" enctype="multipart/form-data"
                                                                    style="display: inline;">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="button" class="btn btn-warning mr-1"
                                                                        data-toggle="modal"
                                                                        data-target="#editModal{{ $value->id }}">
                                                                        <i class="far fa-edit"></i>
                                                                    </button>
                                                                    <!-- Modal Edit -->
                                                                    <div class="modal fade bs-example-modal-lg"
                                                                        id="editModal{{ $value->id }}" tabindex="-1"
                                                                        role="dialog"
                                                                        aria-labelledby="editModalLabel{{ $value->id }}"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog modal-lg" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="editModalLabel{{ $value->id }}">
                                                                                        Edit Project
                                                                                    </h5>
                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="form-group">
                                                                                        <label>Peserta</label>
                                                                                        <select name="magang_id"
                                                                                            class="form-control" required>
                                                                                            <option value="">Pilih
                                                                                                salah satu
                                                                                            </option>
                                                                                            @foreach ($pesertas as $key => $peserta)
                                                                                                @if ($peserta->magang)
                                                                                                    <option
                                                                                                        value="{{ $peserta->magang->id }}"
                                                                                                        selected>
                                                                                                        {{ $peserta->nama }}
                                                                                                    </option>
                                                                                                @else
                                                                                                    <option
                                                                                                        value="{{ $peserta->magang->id }}">
                                                                                                        {{ $peserta->nama }}
                                                                                                    </option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="editProject{{ $value->id }}">Project</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            id="editProject{{ $value->id }}"
                                                                                            name="nama_project"
                                                                                            value="{{ $value->nama_project }}"
                                                                                            required>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>Deskripsi</label>
                                                                                        <textarea id="deskripsi" name="deskripsi" required>{{ $value->deskripsi }}</textarea>
                                                                                        @error('deskripsi')
                                                                                            <span
                                                                                                class="text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="editProject{{ $value->id }}">Batas
                                                                                            Pengumpulan</label>
                                                                                        <input type="datetime-local"
                                                                                            class="form-control"
                                                                                            id="editProject{{ $value->id }}"
                                                                                            name="deadline"
                                                                                            value="{{ $value->deadline }}"
                                                                                            required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">Batal</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">Simpan
                                                                                        Perubahan</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                <form
                                                                    action="{{ route('data-project.destroy', ['id' => $value->uid, 'uid' => $lowongan_uid]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-toggle="modal"
                                                                        data-target="#confirmDelete{{ $value->id }}">
                                                                        <i class="far fa-trash-alt"></i>
                                                                    </button>
                                                                    <!-- Modal Konfirmasi Hapus -->
                                                                    <div class="modal fade"
                                                                        id="confirmDelete{{ $value->id }}" tabindex="-1"
                                                                        role="dialog" aria-labelledby="confirmDeleteLabel"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="confirmDeleteLabel">
                                                                                        Konfirmasi Hapus</h5>
                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    Apakah Anda yakin ingin menghapus item
                                                                                    ini?
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">Batal</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger">Ya,
                                                                                        Hapus</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                        <div class="card-body"
                                                            style="height: 100%; display: flex; flex-direction: column; background-color: #F7F7FD; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);">
                                                            <p class="card-text elm"
                                                                style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; height: 3.6em;">
                                                                {!! strip_tags($value->deskripsi) !!}
                                                            </p>

                                                            <form
                                                                action="{{ route('project.updateStatusAndFeedback', ['id' => $value->uid, 'uid' => $lowongan_uid]) }}"
                                                                method="POST" enctype="multipart/form-data"
                                                                style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                @if (\Carbon\Carbon::parse($value->deadline)->addDay()->isPast() && is_null($value->tgl_pengumpulan))
                                                                    <!-- Jika hari ini sudah melewati deadline -->
                                                                    <button type="button" class="btn btn-danger"
                                                                        style="cursor: default;">
                                                                        <i class="far fa-times-circle"></i> Tidak
                                                                        Mengumpulkan
                                                                    </button>
                                                                @elseif ($value->tgl_pengumpulan && ($value->status === null || $value->status == 2))
                                                                    <!-- Jika sudah dikumpulkan -->
                                                                    <button type="button" class="btn btn-info"
                                                                        data-toggle="modal"
                                                                        data-target="#editModalMentor{{ $value->id }}">
                                                                        <i class="far fa-clock"></i> Review Project
                                                                    </button>
                                                                @elseif ($value->tgl_pengumpulan === null && $value->status == 2)
                                                                    <button type="button" class="btn btn-warning"
                                                                        data-toggle="modal"
                                                                        data-target="#showModalReviewMentor{{ $value->id }}">
                                                                        <i class="far fa-edit"></i> Perlu Perbaikan
                                                                    </button>
                                                                @elseif ($value->tgl_pengumpulan && $value->status == 1)
                                                                    <!-- Jika sudah disetujui -->
                                                                    <button type="button" class="btn btn-success"
                                                                        data-toggle="modal"
                                                                        data-target="#showModalReviewMentor{{ $value->id }}">
                                                                        <i class="far fa-check-circle"></i> Disetujui
                                                                        Mentor
                                                                    </button>
                                                                @else
                                                                    <!-- Jika belum melewati deadline dan belum dikumpulkan -->
                                                                    <button type="button" class="btn btn-secondary"
                                                                        style="cursor: default;">
                                                                        <i class="far fa-edit"></i> Belum
                                                                        Mengumpulkan</button>
                                                                @endif
                                                                <!-- Modal Edit -->
                                                                <div class="modal fade bs-example-modal-lg"
                                                                    id="editModalMentor{{ $value->id }}" tabindex="-1"
                                                                    role="dialog"
                                                                    aria-labelledby="editModalLabel{{ $value->id }}"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="editModalLabel{{ $value->id }}">
                                                                                    Review
                                                                                    Project
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="mb-3">
                                                                                    <p class="card-text mb-1"><b>Nama
                                                                                            Peserta :</b>
                                                                                        {{ $value->magang->peserta['nama'] }}
                                                                                    </p>
                                                                                    <p class="card-text mb-1"><b>Project
                                                                                            :</b>
                                                                                        {{ $value->nama_project }}</p>
                                                                                    <p class="card-text mb-1"><b>Deskripsi
                                                                                            Project
                                                                                            :</b>
                                                                                        {!! $value->deskripsi !!}</p>
                                                                                    <p class="card-text mb-1"><b>Batas
                                                                                            Pengumpulan :</b>
                                                                                        {{ \Carbon\Carbon::parse($value->deadline)->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }}
                                                                                    </p>
                                                                                    <p class="card-text"><b>Tanggal Pengumpulan
                                                                                            :</b>
                                                                                        {{ \Carbon\Carbon::parse($value->tgl_pengumpulan)->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }}
                                                                                    </p>
                                                                                    @if ($value->tgl_pengumpulan && $value->status === 2)
                                                                                        <p class="card-text mb-3"><b>Feedback
                                                                                                :</b>
                                                                                            {!! $value->feedback !!}</p>
                                                                                    @endif

                                                                                    <a href="{{ $value->link_project }}"
                                                                                        target="_blank"><button type="button"
                                                                                            class="btn btn-secondary">
                                                                                            <i class="fas fa-link mr-1"></i>
                                                                                            Link Project</button></a>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Status</label>
                                                                                    <select id="changestatus"
                                                                                        class="form-control @error('status') is-invalid @enderror"
                                                                                        name="status">
                                                                                        <option value="1"
                                                                                            {{ $value->status == 1 ? 'selected' : '' }}>
                                                                                            Disetujui</option>
                                                                                        <option value="2"
                                                                                            {{ $value->status == 2 ? 'selected' : '' }}>
                                                                                            Perbaikan</option>
                                                                                    </select>
                                                                                    @error('status')
                                                                                        <span class="invalid-feedback"
                                                                                            role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-group" id="deadline_field"
                                                                                    style="display: {{ $value->status == 2 ? 'block' : 'none' }}">
                                                                                    <label for="deadline">Tanggal
                                                                                        Pengumpulan</label>
                                                                                    <input id="deadline{{ $value->id }}"
                                                                                        type="datetime-local"
                                                                                        class="form-control @error('deadline') is-invalid @enderror"
                                                                                        name="deadline"
                                                                                        value="{{ $value->deadline }}"
                                                                                        required>
                                                                                    @error('deadline')
                                                                                        <span class="invalid-feedback"
                                                                                            role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Feedback</label>
                                                                                    <div>
                                                                                        <textarea id="feedback" name="feedback" required></textarea>
                                                                                        @error('feedback')
                                                                                            <span
                                                                                                class="text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Batal</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Simpan</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal fade"
                                                                    id="showModalReviewMentor{{ $value->id }}"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="showModalReviewMentor{{ $value->id }}"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="showModalReviewMentor{{ $value->id }}">
                                                                                    Detail Project</h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="mb-3">
                                                                                    <p class="card-text mb-2"><b>Nama Peserta
                                                                                            :</b>
                                                                                        {{ $value->magang->peserta->nama }}</p>
                                                                                    <p class="card-text mb-2"><b>Project :</b>
                                                                                        {{ $value->nama_project }}</p>
                                                                                    <p class="card-text mb-2"><b>Deskripsi
                                                                                            Project
                                                                                            :</b>
                                                                                        {!! $value->deskripsi !!}</p>
                                                                                    <p class="card-text mb-2"><b>Batas
                                                                                            Pengumpulan
                                                                                            :</b>
                                                                                        {{ \Carbon\Carbon::parse($value->deadline)->translatedFormat('l, d F Y H:i') }}
                                                                                    </p>
                                                                                    <p class="card-text mb-2"><b>Tanggal
                                                                                            Pengumpulan
                                                                                            :</b>
                                                                                        {{ \Carbon\Carbon::parse($value->tgl_pengumpulan)->translatedFormat('l, d F Y H:i') }}
                                                                                    </p>
                                                                                    <p class="card-text mb-2"><b>Status :</b>
                                                                                        @if (is_null($value->status))
                                                                                            Menunggu review mentor
                                                                                        @elseif($value->status == 1)
                                                                                            Disetujui
                                                                                        @else
                                                                                            Perlu Perbaikan
                                                                                        @endif
                                                                                    </p>
                                                                                    <p class="card-text mb-3"><b>Feedback :</b>
                                                                                        {!! $value->feedback !!}</p>

                                                                                    @if (!empty($value->link_project))
                                                                                        <a href="{{ $value->link_project }}"
                                                                                            target="_blank">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary">
                                                                                                <i
                                                                                                    class="fas fa-link mr-1"></i>
                                                                                                Link Project
                                                                                            </button>
                                                                                        </a>
                                                                                    @endif

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-lg-12">
                                            @if ($groupedProjectsByPeserta->isEmpty())
                                                <div class="ex-page-content text-center">
                                                    <img src="{{ asset('admin/images/no_data.png') }}" alt="No Internships"
                                                        style="width: 200px; height: auto;">

                                                    <h4 class="">Belum ada Project</h4><br>
                                                </div>
                                            @else
                                                @foreach ($groupedProjectsByPeserta as $pesertaNama => $projects)
                                                    <p><strong>{{ $pesertaNama }}</strong></p>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama Project</th>
                                                                    <th>Deadline</th>
                                                                    <th>Tidak Mengumpulkan</th>
                                                                    <th>Belum Mengumpulkan</th>
                                                                    <th>Menunggu Review</th>
                                                                    <th>Perbaikan</th>
                                                                    <th>Selesai</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($projects as $project)
                                                                    <tr>
                                                                        <td>{{ $project->nama_project }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($project->deadline)->locale('id')->isoFormat('D MMMM Y') }}
                                                                        </td>
                                                                        <td>
                                                                            @if (\Carbon\Carbon::parse($project->deadline)->addDay()->isPast() && is_null($project->tgl_pengumpulan))
                                                                                <i class="far fa-times-circle text-danger"></i>
                                                                            @else
                                                                                <i class="far fa-circle"></i>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if (is_null($project->tgl_pengumpulan) &&
                                                                                    \Carbon\Carbon::parse($project->deadline)->addDay()->isFuture() &&
                                                                                    is_null($project->status))
                                                                                <i class="far fa-edit"
                                                                                    style="color: grey;"></i>
                                                                            @else
                                                                                <i class="far fa-circle"></i>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($project->tgl_pengumpulan && ($project->status === null || $project->status == 2))
                                                                                <i class="far fa-check-circle text-info"></i>
                                                                            @else
                                                                                <i class="far fa-circle"></i>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if (is_null($project->tgl_pengumpulan) && $project->status == 2)
                                                                                <i class="far fa-edit text-warning"></i>
                                                                            @else
                                                                                <i class="far fa-circle"></i>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($project->tgl_pengumpulan && $project->status == 1)
                                                                                <i
                                                                                    class="far fa-check-circle text-success"></i>
                                                                            @else
                                                                                <i class="far fa-circle"></i>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            @endIsMentor
            @IsAdmin
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <form method="GET"
                                            action="{{ route('data-project.index', ['uid' => $lowongan_uid]) }}">

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
                                    <div class="row">
                                        @if ($projects->isEmpty())
                                            <div class="col-lg-12">
                                                <div class="ex-page-content text-center">
                                                    <img src="{{ asset('admin/images/no_data.png') }}" alt="No Internships"
                                                        style="width: 200px; height: auto;">

                                                    <h4 class="">Belum ada Project</h4><br>
                                                </div>
                                            </div>
                                        @else
                                            @foreach ($projects as $key => $value)
                                                <div class="col-lg-4 mb-4">
                                                    <div class="card m-b-30" style="height: 100%;">
                                                        <div class="card-header d-flex justify-content-between align-items-center"
                                                            style="background-color: #322b62">
                                                            <h4 class="font-16 mt-0" style="color: white">
                                                                {{ $value->nama_project }} <span class="ml-1"
                                                                    style="font-size: 11px; font-style: italic">(Deadline :
                                                                    {{ \Carbon\Carbon::parse($value->deadline)->locale('id')->isoFormat('D MMMM Y') }})</span>
                                                            </h4>
                                                        </div>
                                                        <div class="card-body"
                                                            style="height: 100%; display: flex; flex-direction: column; background-color: #F7F7FD; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);">
                                                            <p class="card-text elm"
                                                                style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; height: 3.6em;">
                                                                {!! strip_tags($value->deskripsi) !!}
                                                            </p>

                                                            <form
                                                                action="{{ route('project.updateStatusAndFeedback', ['id' => $value->uid, 'uid' => $lowongan_uid]) }}"
                                                                method="POST" enctype="multipart/form-data"
                                                                style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                @if (\Carbon\Carbon::parse($project->deadline)->addDay()->isPast() && is_null($project->tgl_pengumpulan))
                                                                    <!-- Jika hari ini sudah melewati deadline -->
                                                                    <button type="button" class="btn btn-danger"
                                                                        style="cursor: default;">
                                                                        <i class="far fa-times-circle"></i> Tidak
                                                                        Mengumpulkan
                                                                    </button>
                                                                @elseif ($value->tgl_pengumpulan && ($value->status === null || $value->status == 2))
                                                                    <!-- Jika sudah dikumpulkan -->
                                                                    <button type="button" class="btn btn-info"
                                                                        data-toggle="modal"
                                                                        data-target="#showModalReview{{ $value->id }}">
                                                                        <i class="far fa-clock"></i> Menunggu Review Mentor
                                                                    </button>
                                                                @elseif ($value->tgl_pengumpulan === null && $value->status == 2)
                                                                    <button type="button" class="btn btn-warning"
                                                                        style="cursor: default;">
                                                                        <i class="far fa-edit"></i> Perlu Perbaikan
                                                                    </button>
                                                                @elseif ($value->tgl_pengumpulan && $value->status == 1)
                                                                    <!-- Jika sudah disetujui -->
                                                                    <button type="button" class="btn btn-success"
                                                                        data-toggle="modal"
                                                                        data-target="#showModalReview{{ $value->id }}">
                                                                        <i class="far fa-check-circle"></i> Disetujui
                                                                        Mentor
                                                                    </button>
                                                                @else
                                                                    <!-- Jika belum melewati deadline dan belum dikumpulkan -->
                                                                    <button type="button" class="btn btn-secondary"
                                                                        style="cursor: default;">
                                                                        <i class="far fa-edit"></i> Belum
                                                                        Mengumpulkan</button>
                                                                @endif

                                                                <div class="modal fade"
                                                                    id="showModalReview{{ $value->id }}" tabindex="-1"
                                                                    role="dialog"
                                                                    aria-labelledby="showModalReview{{ $value->id }}"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="showModalReview{{ $value->id }}">
                                                                                    Detail Project</h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="mb-3">
                                                                                    <p class="card-text mb-2"><b>Nama Peserta
                                                                                            :</b>
                                                                                        {{ $value->magang->peserta->nama }}
                                                                                    </p>
                                                                                    <p class="card-text mb-2"><b>Project :</b>
                                                                                        {{ $value->nama_project }}</p>
                                                                                    <p class="card-text mb-2"><b>Deskripsi
                                                                                            Project
                                                                                            :</b>
                                                                                        {!! $value->deskripsi !!}</p>
                                                                                    <p class="card-text mb-2"><b>Batas
                                                                                            Pengumpulan
                                                                                            :</b>
                                                                                        {{ \Carbon\Carbon::parse($value->deadline)->translatedFormat('l, d F Y H:i') }}
                                                                                    </p>
                                                                                    <p class="card-text mb-2"><b>Tanggal
                                                                                            Pengumpulan
                                                                                            :</b>
                                                                                        {{ \Carbon\Carbon::parse($value->tgl_pengumpulan)->translatedFormat('l, d F Y H:i') }}
                                                                                    </p>
                                                                                    <p class="card-text mb-2"><b>Status :</b>
                                                                                        @if (is_null($value->status))
                                                                                            Menunggu review mentor
                                                                                        @elseif($value->status == 1)
                                                                                            Disetujui
                                                                                        @else
                                                                                            Perlu Perbaikan
                                                                                        @endif
                                                                                    </p>
                                                                                    <p class="card-text mb-3"><b>Feedback :</b>
                                                                                        {!! $value->feedback !!}</p>

                                                                                    @if (!empty($value->link_project))
                                                                                        <a href="{{ $value->link_project }}"
                                                                                            target="_blank">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary">
                                                                                                <i
                                                                                                    class="fas fa-link mr-1"></i>
                                                                                                Link Project
                                                                                            </button>
                                                                                        </a>
                                                                                    @endif

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-lg-12">
                                            @if ($groupedProjectsByPeserta->isEmpty())
                                                <div class="ex-page-content text-center">
                                                    <img src="{{ asset('admin/images/no_data.png') }}" alt="No Internships"
                                                        style="width: 200px; height: auto;">

                                                    <h4 class="">Belum ada Project</h4><br>
                                                </div>
                                            @else
                                                @foreach ($groupedProjectsByPeserta as $pesertaNama => $projects)
                                                    <p><strong>{{ $pesertaNama }}</strong></p>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama Project</th>
                                                                    <th>Deadline</th>
                                                                    <th>Tidak Mengumpulkan</th>
                                                                    <th>Belum Mengumpulkan</th>
                                                                    <th>Menunggu Review</th>
                                                                    <th>Perbaikan</th>
                                                                    <th>Selesai</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($projects as $project)
                                                                    <tr>
                                                                        <td>{{ $project->nama_project }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($project->deadline)->locale('id')->isoFormat('D MMMM Y') }}
                                                                        </td>
                                                                        <td>
                                                                            @if (\Carbon\Carbon::parse($project->deadline)->addDay()->isPast() && is_null($project->tgl_pengumpulan))
                                                                                <i class="far fa-times-circle text-danger"></i>
                                                                            @else
                                                                                <i class="far fa-circle"></i>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if (is_null($project->tgl_pengumpulan) &&
                                                                                    \Carbon\Carbon::parse($project->deadline)->addDay()->isFuture() &&
                                                                                    is_null($project->status))
                                                                                <i class="far fa-edit"
                                                                                    style="color: grey;"></i>
                                                                            @else
                                                                                <i class="far fa-circle"></i>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($project->tgl_pengumpulan && ($project->status === null || $project->status == 2))
                                                                                <i class="far fa-check-circle text-info"></i>
                                                                            @else
                                                                                <i class="far fa-circle"></i>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if (is_null($project->tgl_pengumpulan) && $project->status == 2)
                                                                                <i class="far fa-edit text-warning"></i>
                                                                            @else
                                                                                <i class="far fa-circle"></i>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($project->tgl_pengumpulan && $project->status == 1)
                                                                                <i
                                                                                    class="far fa-check-circle text-success"></i>
                                                                            @else
                                                                                <i class="far fa-circle"></i>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endIsAdmin

        </div> <!-- content -->
    </div>


    <script>
        document.getElementById('changestatus').addEventListener('change', function() {
            var statusValue = this.value;
            var deadlineField = document.getElementById('deadline_field');

            if (statusValue === '2') {
                deadlineField.style.display = 'block';
            } else {
                deadlineField.style.display = 'none';
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let tableCells = document.querySelectorAll(".elm");

            tableCells.forEach(function(cell) {
                cell.style.whiteSpace = "normal";
                cell.style.wordWrap = "break-word";
            });
        });
    </script>
@endsection

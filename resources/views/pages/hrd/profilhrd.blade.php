@extends('inc.main')

@section('page-title')
    Profil
@endsection

@section('breadcrumb-title')
    Profil
@endsection

@section('content')
    <style>
        .email-container {
            display: flex;
        }
    </style>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 email-container">
                    <!-- Left sidebar -->
                    <div class="email-leftbar card">
                        <div class="mb-3 text-center">
                            @if ($hrd && $hrd->image)
                                <img class="" src="{{ asset('storage/images/' . $hrd->image) }}" alt="Profil Picture"
                                    style="width: 150px; height: 150px; border: 2px solid #ccc; padding: 4px;">
                            @else
                                <img class="" src="{{ asset('admin/images/users/user.png') }}"
                                    alt="Default Profil Picture"
                                    style="width: 150px; height: 150px; border: 2px solid #ccc; padding: 4px;">
                            @endif
                        </div>
                    </div>
                    <!-- End Left sidebar -->

                    <!-- Right Sidebar -->
                    <div class="email-rightbar card">

                        <div class="card-body">
                            <div class="btn-toolbar" role="toolbar">
                                <a href="{{ route('profil-hrd.edit', $user->uid) }}"
                                    class="btn btn-primary waves-effect waves-light">Edit Profil</a>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-9">
                                    <p class="col-form-label">{{ $hrd ? $hrd->nama : '-' }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <p class="col-form-label">{{ $user->email }} {!! $user->email_verified_at ? '<i class="fas fa-check-circle text-success"></i>' : '' !!}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                <p class="col-sm-9 col-form-label">
                                    @if ($hrd->jenis_kelamin == 1)
                                        Laki-Laki
                                    @elseif ($hrd->jenis_kelamin == 2)
                                        Perempuan
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            {{-- <div class="form-group row">
                                    <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                    <p class="col-sm-9 col-form-label">{{ $hrd->alamat ?? 'N/A' }}</p>
                                </div>
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 col-form-label">No HP</label>
                                    <p class="col-sm-9 col-form-label">{{ $hrd->no_hp ?? 'N/A' }}</p>
                                </div>
                                <div class="form-group row">
                                    <label for="pendidikan_terakhir" class="col-sm-3 col-form-label">Pendidikan
                                        Terakhir</label>
                                    <p class="col-sm-9 col-form-label">{{ $peserta->pendidikan_terakhir ?? 'N/A' }}</p>
                                </div>
                                <div class="form-group row">
                                    <label for="institusi_pendidikan_terakhir" class="col-sm-3 col-form-label">Institusi
                                        Pendidikan Terakhir</label>
                                    <p class="col-sm-9 col-form-label">
                                        {{ $peserta->institusi_pendidikan_terakhir ?? 'N/A' }}</p>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggal_mulai_studi" class="col-sm-3 col-form-label">Tanggal Mulai Studi</label>
                                    <p class="col-sm-9 col-form-label">{{ $peserta->tanggal_mulai_studi_formatted ?? 'N/A' }}</p>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggal_berakhir_studi" class="col-sm-3 col-form-label">Tanggal Berakhir Studi</label>
                                    <p class="col-sm-9 col-form-label">{{ $peserta->tanggal_berakhir_studi_formatted ?? 'N/A' }}</p>
                                </div>
                                <div class="form-group row">
                                    <label for="kartu_identitas_studi" class="col-sm-3 col-form-label">Kartu Identitas Studi</label>
                                    <div class="col-sm-9">
                                        <!-- Tampilkan nama file kartu identitas studi -->
                                        <a href="{{ asset('kartu_identitas_studi/' . $peserta->kartu_identitas_studi) }}" target="_blank">{{ basename($peserta->kartu_identitas_studi) }}</a>
                                    </div> --}}
                        </div>

                        <!-- Tambahkan informasi lainnya sesuai kebutuhan -->
                    </div>

                </div> <!-- end Col-9 -->

            </div>

        </div><!-- End row -->

    </div>
    </div>
@endsection

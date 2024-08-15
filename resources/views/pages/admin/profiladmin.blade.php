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
                                <img class="" src="{{ asset('admin/images/users/user.png') }}" alt="Default Profil Picture" style="width: 150px; height: 150px; border: 2px solid #ccc; padding: 4px;">
                        </div>
                    </div>
                    <!-- End Left sidebar -->

                    <!-- Right Sidebar -->
                    <div class="email-rightbar card">

                            <div class="card-body">
                                <div class="btn-toolbar" role="toolbar">
                                    <a href="{{ route('profil-admin.edit', $user->uid) }}"
                                        class="btn btn-primary waves-effect waves-light">Edit Profil</a>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label">Nama</label>
                                    <div class="col-sm-9">
                                        <p class="col-form-label">{{ $user->name }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <p class="col-form-label">{{ $user->email }} {!! $user->email_verified_at ? '<i class="fas fa-check-circle text-success"></i>' : '' !!}</p>
                                    </div>
                                </div>

                                <!-- Tambahkan informasi lainnya sesuai kebutuhan -->
                            </div>

                    </div> <!-- end Col-9 -->

                </div>

            </div><!-- End row -->

        </div>
    </div>
@endsection

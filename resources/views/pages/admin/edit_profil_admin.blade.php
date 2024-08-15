@extends('inc.main')

@section('page-title')
    Edit Profil
@endsection

@section('breadcrumb-title')
    Edit Profil
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <form action="{{ route('profil-admin.update', $user->uid) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $user->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        data-parsley-minlength="8" placeholder="Min 8 chars.">
                                    <small id="passwordHelp" class="form-text text-muted">Kosongkan jika
                                        tidak ingin
                                        mengubah password.</small>
                                </div>

                                <!-- Tambahkan input lainnya sesuai kebutuhan -->
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('image').addEventListener('change', function() {
            var file = this.files[0];
            var imagePreview = document.getElementById('image_preview');

            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                imagePreview.style.display = 'none';
            }
        });
    </script>
    <script>
        function showImageModal(imageUrl) {
            var fullImage = document.getElementById('fullImage');
            fullImage.src = imageUrl;
            $('#imageModal').modal('show');
        }
    </script>
@endsection

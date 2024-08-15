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
                            <form action="{{ route('profil-hrd.update', $user->uid) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ $hrd->nama }}" data-parsley-pattern="^[a-zA-Z\s\-]+$" required>
                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $hrd->user->email) }}"
                                        parsley-type="email" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Min 8 chars.">
                                    <small id="passwordHelp" class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="1" {{ $hrd->jenis_kelamin == 1 ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="2" {{ $hrd->jenis_kelamin == 2 ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="image">Foto Profil</label>
                                    @if ($hrd->image)
                                        <div>
                                            <img src="{{ asset('storage/images/' . $hrd->image) }}" alt="Foto Profil"
                                                style="max-width: 100px; margin-bottom: 8px; border-radius: 8px; border: 2px solid #ccc; padding: 4px;"
                                                onclick="showImageModal('{{ asset('storage/images/' . $hrd->image) }}')">
                                        </div>

                                        <!-- Modal untuk menampilkan gambar dengan ukuran penuh -->
                                        <div id="imageModal" class="modal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <img id="fullImage" src="" class="img-fluid"
                                                            alt="Foto Profil">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control filestyle @error('foto') is-invalid @enderror"
                                        id="image" name="image" data-buttonname="btn-secondary"
                                        data-parsley-fileaccept="image/jpeg, image/png, image/jpg"
                                        data-parsley-max-file-size="2048" accept=".jpg, .jpeg, .png">
                                    <small class="form-text text-muted">File JPG, JPEG,
                                        atau PNG maksimal 2MB.</small>
                                    <div id="fileError" class="invalid-feedback">
                                    </div>
                                    @error('foto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- @if ($peserta->image)
                                        <small class="form-text text-muted">Foto saat ini: {{ basename($peserta->image) }}</small>
                                        <input type="hidden" name="existing_image" value="{{ $peserta->image }}">
                                    @endif --}}
                                    <img id="image_preview"
                                        src="{{ $hrd->image ? asset($hrd->image) : 'placeholder.jpg' }}" alt="Foto Profil"
                                        class="img-fluid mt-2" style="max-width: 200px; display: none;">
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

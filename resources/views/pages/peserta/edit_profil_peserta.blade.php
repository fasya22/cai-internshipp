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
                            <form action="{{ route('profil-peserta.update', $user->uid) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                id="nama" name="nama" value="{{ old('nama', $peserta->nama) }}"
                                                pattern="[a-zA-Z\s\-]+" required>
                                            @error('nama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email"
                                                value="{{ old('email', $peserta->user->email) }}" parsley-type="email"
                                                required>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">

                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                data-parsley-minlength="8" placeholder="Min 8 chars.">
                                            <small id="passwordHelp" class="form-text text-muted">Kosongkan jika
                                                tidak ingin
                                                mengubah password.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="5">{{ old('alamat', $peserta->alamat) }}</textarea>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="no_hp">No HP</label>
                                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                                value="{{ old('no_hp', $peserta->no_hp) }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                                id="jenis_kelamin" name="jenis_kelamin">
                                                <option value="1"
                                                    {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 1 ? 'selected' : '' }}>
                                                    Laki-laki</option>
                                                <option value="2"
                                                    {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 2 ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                                            <input type="text"
                                                class="form-control @error('pendidikan_terakhir') is-invalid @enderror"
                                                id="pendidikan_terakhir" name="pendidikan_terakhir"
                                                value="{{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir) }}">
                                            @error('pendidikan_terakhir')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="institusi_pendidikan_terakhir">Institusi Pendidikan Terakhir</label>
                                            <input type="text" class="form-control" id="institusi_pendidikan_terakhir"
                                                name="institusi_pendidikan_terakhir"
                                                value="{{ old('institusi_pendidikan_terakhir', $peserta->institusi_pendidikan_terakhir) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="prodi">Program Studi</label>
                                            <input type="text" class="form-control" id="prodi" name="prodi"
                                                value="{{ old('prodi', $peserta->prodi) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="ipk">IPK</label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('ipk') is-invalid @enderror" id="ipk"
                                                name="ipk" value="{{ old('ipk', $peserta->ipk) }}">
                                            @error('ipk')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="tanggal_mulai_studi">Tanggal Mulai Studi</label>
                                            <input type="date" class="form-control" id="tanggal_mulai_studi"
                                                name="tanggal_mulai_studi"
                                                value="{{ old('tanggal_mulai_studi', $peserta->tanggal_mulai_studi) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="tanggal_berakhir_studi">Tanggal Berakhir Studi</label>
                                            <input type="date" class="form-control" id="tanggal_berakhir_studi"
                                                name="tanggal_berakhir_studi"
                                                value="{{ old('tanggal_berakhir_studi', $peserta->tanggal_berakhir_studi) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="kartu_identitas_studi">Kartu Identitas Studi</label>
                                            @if ($peserta->kartu_identitas_studi)
                                                <div style="margin-bottom: 10px">
                                                    <a href="{{ asset('storage/kartu_identitas_studi/' . $peserta->kartu_identitas_studi) }}"
                                                        target="_blank"><i
                                                            class="fas fa-file-alt"></i>{{ $peserta->kartu_identitas_studi }}</a>
                                                </div>
                                                <input type="file" class="filestyle" id="kartu_identitas_studi"
                                                    name="kartu_identitas_studi" data-buttonname="btn-secondary"
                                                    accept=".pdf">
                                                <small class="form-text text-muted">File PDF</small>
                                            @else
                                                <input type="file" class="filestyle" id="kartu_identitas_studi"
                                                    name="kartu_identitas_studi" data-buttonname="btn-secondary"
                                                    accept=".pdf">
                                                <small class="form-text text-muted">File PDF</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="image">Foto Profil</label>
                                            @if ($peserta->image)
                                                <div>
                                                    <img src="{{ asset('storage/images/' . $peserta->image) }}" alt="Foto Profil"
                                                        style="max-width: 100px; margin-bottom: 8px; border-radius: 8px; border: 2px solid #ccc; padding: 4px;"
                                                        onclick="showImageModal('{{ asset('storage/images/' . $peserta->image) }}')">
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
                                            <input type="file"
                                                class="form-control filestyle @error('foto') is-invalid @enderror"
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
                                            <img id="image_preview"
                                                src="{{ $peserta->image ? asset($peserta->image) : 'placeholder.jpg' }}"
                                                alt="Foto Profil" class="img-fluid mt-2"
                                                style="max-width: 200px; display: none;">
                                        </div>
                                    </div>
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

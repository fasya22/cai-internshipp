@extends('front.layouts.main')

@section('content')

<style>
    .portfolio-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem; /* Adjust margin as needed */
    }
    .portfolio-item input {
        flex: 1; /* Make input take up remaining space */
    }
    .portfolio-item button {
        margin-left: 0.5rem; /* Space between input and button */
    }
</style>

    <header class="site-header">
        <div class="section-overlay"></div>

        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12 text-center">
                    <h1 class="text-white">{{ $lowongan->posisi->posisi }}</h1>

                    {{-- <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $lowongan->posisi->posisi }}</li>
                        </ol>
                    </nav> --}}
                </div>
            </div>
        </div>
    </header>

    <section class="login-section section-padding section-padding-btm">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12 mx-auto">
                    <form class="custom-form contact-form" role="form" method="POST"
                        action="{{ route('apply-job.store', ['lowongan_uid' => $lowongan->uid]) }}"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="nama">Nama <span class="text-danger">*</span></label>
                                <input id="nama" type="text" class="form-control" name="nama"
                                    value="{{ $peserta->nama }}" required autocomplete="nama" disabled>
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input id="email" type="text" class="form-control" name="email"
                                    value="{{ $peserta->user->email }}" required autocomplete="email" disabled>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Form tambahan dari PesertaModel -->
                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                          name="alamat" rows="4" autocomplete="alamat"  required>{{ old('alamat', $peserta->alamat ?? '') }}</textarea>
                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select id="jenis_kelamin"
                                        class="form-control form-select @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="1" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == '1' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="2" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == '2' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                                @error('jenis_kelamin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>



                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="no_hp">Nomor HP <span class="text-danger">*</span></label>
                                <input id="no_hp" type="number"
                                       class="form-control @error('no_hp') is-invalid @enderror" name="no_hp"
                                       value="{{ old('no_hp', $peserta->no_hp ?? '') }}" autocomplete="no_hp" required maxlength="15">
                                @error('no_hp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="pendidikan_terakhir">Pendidikan Terakhir <span class="text-danger">*</span></label>
                                <select id="pendidikan_terakhir"
                                        class="form-control @error('pendidikan_terakhir') is-invalid @enderror"
                                        name="pendidikan_terakhir"
                                        autocomplete="pendidikan_terakhir"
                                        required>
                                    <option value="" disabled selected>Pilih Pendidikan Terakhir</option>
                                    <option value="SMA" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == 'SMA' ? 'selected' : '' }}>SMA/SMK</option>
                                    <option value="D2" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == 'D2' ? 'selected' : '' }}>D2</option>
                                    <option value="D3" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="D4" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == 'D4' ? 'selected' : '' }}>D4</option>
                                    <option value="S1" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == 'S1' ? 'selected' : '' }}>S1</option>
                                    {{-- <option value="S2" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == 'S3' ? 'selected' : '' }}>S3</option> --}}
                                </select>
                                @error('pendidikan_terakhir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="institusi_pendidikan_terakhir">Institusi Pendidikan Terakhir <span class="text-danger">*</span></label>
                                <input id="institusi_pendidikan_terakhir" type="text"
                                    class="form-control @error('institusi_pendidikan_terakhir') is-invalid @enderror"
                                    name="institusi_pendidikan_terakhir"
                                    value="{{ old('institusi_pendidikan_terakhir', $peserta->institusi_pendidikan_terakhir ?? '') }}"
                                    autocomplete="institusi_pendidikan_terakhir" maxlength="50" required>
                                @error('institusi_pendidikan_terakhir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="prodi">Jurusan/ Program Studi <span class="text-danger">*</span></label>
                                <input id="prodi" type="text"
                                    class="form-control @error('prodi') is-invalid @enderror"
                                    name="prodi"
                                    value="{{ old('prodi', $peserta->prodi ?? '') }}"
                                    autocomplete="prodi" maxlength="50" required>
                                @error('prodi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="ipk">IPK <span class="text-danger">*</span></label>
                                <input id="ipk" type="number" step="0.01"
                                    class="form-control @error('ipk') is-invalid @enderror"
                                    name="ipk"
                                    value="{{ old('ipk', $peserta->ipk ?? '') }}"
                                    required>
                                @error('ipk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="tanggal_mulai_studi">Tanggal Mulai Studi <span class="text-danger">*</span></label>
                                <input id="tanggal_mulai_studi" type="date"
                                    class="form-control @error('tanggal_mulai_studi') is-invalid @enderror"
                                    name="tanggal_mulai_studi" value="{{ old('tanggal_mulai_studi', $peserta->tanggal_mulai_studi ?? '') }}"
                                    autocomplete="tanggal_mulai_studi" required>
                                @error('tanggal_mulai_studi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="tanggal_berakhir_studi">Tanggal Berakhir Studi <span class="text-danger">*</span></label>
                                <input id="tanggal_berakhir_studi" type="date"
                                    class="form-control @error('tanggal_berakhir_studi') is-invalid @enderror"
                                    name="tanggal_berakhir_studi" value="{{ old('tanggal_berakhir_studi', $peserta->tanggal_berakhir_studi ?? '') }}"
                                    autocomplete="tanggal_berakhir_studi" required>
                                @error('tanggal_berakhir_studi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="kartu_identitas_studi">Kartu Identitas Studi (PDF) <span class="text-danger">*</span></label>
                                <input id="kartu_identitas_studi" type="file"
                                    class="form-control form-control-file @error('kartu_identitas_studi') is-invalid @enderror"
                                    name="kartu_identitas_studi" accept=".pdf" required>
                                @error('kartu_identitas_studi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="surat_lamaran_magang">Surat Lamaran Magang (PDF)<span class="text-danger">*</span></label>
                                {{-- <small class="form-text text-muted">Tidak ada format khusus</small> --}}
                                <input id="surat_lamaran_magang" type="file"
                                    class="form-control form-control-file @error('surat_lamaran_magang') is-invalid @enderror"
                                    name="surat_lamaran_magang" accept=".pdf" required>
                                @error('surat_lamaran_magang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="cv">Curriculum Vitae (PDF) <span class="text-danger">*</span></label>
                                <input id="cv" type="file"
                                    class="form-control form-control-file @error('cv') is-invalid @enderror" name="cv" accept=".pdf" required>
                                @error('cv')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @if ($lowongan->requires_english == 1)
                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="english_certificate_id">Jenis Sertifikat Bahasa Inggris</label>
                                <select id="english_certificate_id"
                                        class="form-control form-select @error('english_certificate_id') is-invalid @enderror"
                                        name="english_certificate_id">
                                    <option value="">Pilih Sertifikat</option>
                                    @foreach ($english_certificates as $certificate)
                                        <option value="{{ $certificate->id }}"
                                                {{ old('english_certificate_id') == $certificate->id ? 'selected' : '' }}>
                                            {{ $certificate->jenis_sertifikat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('english_certificate_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="nilai_bahasa_inggris">Nilai Bahasa Inggris</label>
                                <input id="nilai_bahasa_inggris" type="number"
                                    class="form-control @error('nilai_bahasa_inggris') is-invalid @enderror"
                                    name="nilai_bahasa_inggris" value="{{ old('nilai_bahasa_inggris') }}">
                                @error('nilai_bahasa_inggris')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-4">
                                <label for="sertifikat_bahasa_inggris">Sertifikat Bahasa Inggris (PDF)</label>
                                <input id="sertifikat_bahasa_inggris" type="file"
                                    class="form-control form-control-file @error('sertifikat_bahasa_inggris') is-invalid @enderror"
                                    name="sertifikat_bahasa_inggris" accept=".pdf">
                                @error('sertifikat_bahasa_inggris')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @endif

                            <hr>
                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="keahlian_yang_dimiliki" class="mb-3">Keahlian yang Dimiliki :</label>
                                <div class="row">
                                    @php
                                        $keahlianArray = [];

                                        // Cek jika keahlian_yang_dibutuhkan berupa JSON, ubah menjadi array
                                        if (is_string($lowongan->keahlian_yang_dibutuhkan)) {
                                            $keahlianArray = json_decode($lowongan->keahlian_yang_dibutuhkan, true);

                                            // Jika gagal decode, anggap string dipisahkan koma
                                            if (json_last_error() !== JSON_ERROR_NONE) {
                                                $keahlianArray = explode(',', $lowongan->keahlian_yang_dibutuhkan);
                                            }
                                        }
                                    @endphp

                                    @foreach ($keahlianArray as $keahlian)
                                        <div class="col-lg-4 col-md-6 col-12 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input @error('keahlian_yang_dimiliki') is-invalid @enderror"
                                                    type="checkbox" name="keahlian_yang_dimiliki[]" id="keahlian_{{ $loop->index }}"
                                                    value="{{ $keahlian }}" {{ in_array(trim($keahlian), old('keahlian_yang_dimiliki', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="keahlian_{{ $loop->index }}">
                                                    {{ trim($keahlian) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('keahlian_yang_dimiliki')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <hr>
                            <div class="col-lg-12 col-md-12 col-12 d-flex align-items-center mb-3">
                                <label for="soft_komunikasi" class="flex-grow-1 mb-0">Memiliki kemampuan komunikasi yang baik</label>
                                <input type="checkbox" class="form-check-input" id="soft_komunikasi" name="soft_komunikasi" value="1" {{ old('soft_komunikasi') ? 'checked' : '' }}>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12 d-flex align-items-center mb-3">
                                <label for="soft_tim" class="flex-grow-1 mb-0">Mampu bekerja secara individu maupun tim</label>
                                <input type="checkbox" class="form-check-input" id="soft_tim" name="soft_tim" value="1" {{ old('soft_tim') ? 'checked' : '' }}>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12 d-flex align-items-center mb-3">
                                <label for="soft_adaptable" class="flex-grow-1 mb-0">Mampu beradaptasi dengan lingkungan baru</label>
                                <input type="checkbox" class="form-check-input" id="soft_adaptable" name="soft_adaptable" value="1" {{ old('soft_adaptable') ? 'checked' : '' }}>
                            </div>

                            <hr>

                            <div class="col-lg-12 col-md-12 col-12 mt-3 mb-3">
                                <label for="portfolio">Link Portfolio <span class="text-danger">*</span></label>
                                <div id="portfolio-container">
                                    <!-- Input awal -->
                                    @foreach (old('link_portfolio', ['']) as $index => $value)
                                        <div class="portfolio-item mb-2 d-flex align-items-center">
                                            <input type="url"
                                                   class="form-control @error('link_portfolio.' . $index) is-invalid @enderror"
                                                   name="link_portfolio[]"
                                                   placeholder="Masukkan link portfolio Anda"
                                                   value="{{ $value }}"
                                                   required>
                                            <button type="button" class="btn btn-danger btn-sm remove-portfolio ms-2">-</button>

                                        </div>
                                        {{-- <div> --}}
                                            @error('link_portfolio.' . $index)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        {{-- </div> --}}
                                    @endforeach
                                </div>
                                <button type="button" id="add-portfolio" class="btn custom-btn">Tambah Portfolio</button>
                            </div>


                            <div class="col-lg-4 col-md-4 col-6 mx-auto mt-4">
                                <button type="submit" class="form-control">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="section-overlay"></div>

        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12 text-center">
                    <h3 class="text-white mb-3">Empowering Careers, Shaping Futures: Explore Opportunities with Us!</h3>

                    <p class="text-white">Melalui program magang, kami tidak hanya menawarkan kesempatan untuk belajar dan
                        berkembang, tetapi juga menciptakan lingkungan yang mendukung untuk mengejar impian Anda. Dengan
                        bimbingan dari para ahli di industri dan akses ke proyek-proyek yang menarik, Anda dapat
                        mengembangkan keterampilan dan pengalaman yang diperlukan untuk mencapai kesuksesan di masa depan.
                        Temukan peluang magang yang menarik dan mulailah perjalanan Anda menuju karier yang cemerlang
                        bersama kami!</p>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
  <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin/js/metisMenu.min.js') }}"></script>
  <script src="{{ asset('admin/js/jquery.slimscroll.js') }}"></script>
  <script src="{{ asset('admin/js/waves.min.js') }}"></script>

  <script src="{{ asset('admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/parsleyjs/parsley.min.js') }}"></script>

  <script src="{{ asset('admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
  <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}"></script>
  <script src="{{ asset('admin/pages/form-advanced.js') }}"></script>

  <script src="{{ asset('admin/js/app.js') }}"></script>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pendidikanSelect = document.getElementById('pendidikan_terakhir');
        const tanggalInput = document.getElementById('tanggal_mulai_studi');

        function updateMinDate() {
            const pendidikan = pendidikanSelect.value;
            const today = new Date();
            let minDate;

            switch (pendidikan) {
                case 'SMA':
                    minDate = new Date(today.setFullYear(today.getFullYear() - 3));
                    break;
                case 'D2':
                    minDate = new Date(today.setFullYear(today.getFullYear() - 2));
                    break;
                case 'D3':
                    minDate = new Date(today.setFullYear(today.getFullYear() - 3));
                    break;
                case 'S1':
                    minDate = new Date(today.setFullYear(today.getFullYear() - 4));
                    break;
                case 'D4':
                    minDate = new Date(today.setFullYear(today.getFullYear() - 4));
                    break;
                default:
                    minDate = new Date(today.setFullYear(today.getFullYear() - 1)); // Default case, if needed
            }

            tanggalInput.setAttribute('max', minDate.toISOString().split('T')[0]);
        }

        pendidikanSelect.addEventListener('change', updateMinDate);

        // Initialize the minimum date based on the currently selected value
        updateMinDate();
    });
</script>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const pendidikanSelect = document.getElementById('pendidikan_terakhir');
        const tanggalMulaiInput = document.getElementById('tanggal_mulai_studi');
        const tanggalBerakhirInput = document.getElementById('tanggal_berakhir_studi');

        function updateBerakhirDate() {
            const pendidikan = pendidikanSelect.value;
            const tanggalMulaiValue = tanggalMulaiInput.value;

            if (tanggalMulaiValue) {
                const tanggalMulai = new Date(tanggalMulaiValue);
                let berakhirDate;

                // Menentukan durasi studi berdasarkan jenjang pendidikan
                switch (pendidikan) {
                    case 'SMA':
                        berakhirDate = new Date(tanggalMulai.setFullYear(tanggalMulai.getFullYear() + 3));
                        break;
                    case 'D2':
                        berakhirDate = new Date(tanggalMulai.setFullYear(tanggalMulai.getFullYear() + 2));
                        break;
                    case 'D3':
                        berakhirDate = new Date(tanggalMulai.setFullYear(tanggalMulai.getFullYear() + 3));
                        break;
                    case 'S1':
                        berakhirDate = new Date(tanggalMulai.setFullYear(tanggalMulai.getFullYear() + 4));
                        break;
                    case 'D4':
                        berakhirDate = new Date(tanggalMulai.setFullYear(tanggalMulai.getFullYear() + 4));
                        break;
                    default:
                        berakhirDate = null; // Atur sesuai kebutuhan
                }

                if (berakhirDate) {
                    tanggalBerakhirInput.value = berakhirDate.toISOString().split('T')[0];
                }
            }
        }

        pendidikanSelect.addEventListener('change', updateBerakhirDate);
        tanggalMulaiInput.addEventListener('change', updateBerakhirDate);

        // Initialize the end date based on the currently selected values
        updateBerakhirDate();
    });
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const pendidikanSelect = document.getElementById('pendidikan_terakhir');
    const tanggalMulaiInput = document.getElementById('tanggal_mulai_studi');
    const tanggalBerakhirInput = document.getElementById('tanggal_berakhir_studi');

    function updateMinDate() {
        const pendidikan = pendidikanSelect.value;
        const today = new Date();
        let maxDate;

        switch (pendidikan) {
            case 'SMA':
                maxDate = new Date(today.getFullYear() - 4, 11, 31);
                break;
            case 'D2':
                maxDate = new Date(today.getFullYear() - 2, 11, 31);
                break;
            case 'D3':
                maxDate = new Date(today.getFullYear() - 3, 11, 31);
                break;
            case 'S1':
                maxDate = new Date(today.getFullYear() - 4, 11, 31);
                break;
            case 'D4':
                maxDate = new Date(today.getFullYear() - 4, 11, 31);
                break;
            default:
                maxDate = new Date(today.getFullYear() - 1, 11, 31);
        }

        tanggalMulaiInput.setAttribute('max', maxDate.toISOString().split('T')[0]);
    }

    function updateEndDate() {
        const startDate = new Date(tanggalMulaiInput.value);
        if (isNaN(startDate.getTime())) return; // Jika tanggal tidak valid, keluar dari fungsi

        let endYear;
        switch (pendidikanSelect.value) {
            case 'SMA':
                endYear = startDate.getFullYear() + 3;
                break;
            case 'D2':
                endYear = startDate.getFullYear() + 2;
                break;
            case 'D3':
                endYear = startDate.getFullYear() + 3;
                break;
            case 'S1':
                endYear = startDate.getFullYear() + 4;
                break;
            case 'D4':
                endYear = startDate.getFullYear() + 4;
                break;
            default:
                endYear = startDate.getFullYear() + 1;
        }

        const endDate = new Date(endYear, startDate.getMonth(), startDate.getDate());
        const maxEndDate = new Date(endYear, 11, 31); // Sampai akhir Desember di tahun berakhir

        tanggalBerakhirInput.value = endDate.toISOString().split('T')[0];
        tanggalBerakhirInput.setAttribute('min', startDate.toISOString().split('T')[0]);
        tanggalBerakhirInput.setAttribute('max', maxEndDate.toISOString().split('T')[0]);
    }

    pendidikanSelect.addEventListener('change', updateMinDate);
    tanggalMulaiInput.addEventListener('change', updateEndDate);

    // Initialize the maximum date based on the currently selected value
    updateMinDate();
    // Set initial end date if a start date is already selected
    if (tanggalMulaiInput.value) {
        updateEndDate();
    }
});

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addButton = document.getElementById('add-portfolio');
        const container = document.getElementById('portfolio-container');

        addButton.addEventListener('click', function() {
            const newDiv = document.createElement('div');
            newDiv.classList.add('portfolio-item', 'mb-2', 'd-flex', 'align-items-center');

            const newInput = document.createElement('input');
            newInput.type = 'url';
            newInput.classList.add('form-control');
            newInput.name = 'link_portfolio[]';
            newInput.placeholder = 'Masukkan link portfolio Anda';
            newInput.required = true;

            const errorSpan = document.createElement('span');
            errorSpan.classList.add('invalid-feedback');
            errorSpan.role = 'alert';
            errorSpan.style.display = 'none';
            errorSpan.innerHTML = '<strong>Link portfolio wajib diisi dan harus berupa URL yang valid.</strong>';

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'remove-portfolio', 'ms-2');
            removeButton.textContent = '-';

            newDiv.appendChild(newInput);
            newDiv.appendChild(errorSpan);
            newDiv.appendChild(removeButton);

            container.appendChild(newDiv);
        });

        container.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-portfolio')) {
                const itemToRemove = event.target.closest('.portfolio-item');
                if (itemToRemove) {
                    itemToRemove.remove();
                }
            }
        });

        container.addEventListener('input', function(event) {
            if (event.target.type === 'url') {
                const input = event.target;
                const errorSpan = input.nextElementSibling;

                if (!input.validity.valid) {
                    errorSpan.style.display = 'block';
                } else {
                    errorSpan.style.display = 'none';
                }
            }
        });
    });
</script>


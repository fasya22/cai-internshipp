@extends('front.layouts.main')

@section('content')
    <header class="site-header">
        <div class="section-overlay"></div>

        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12 text-center">
                    <h1 class="text-white">Job Details</h1>

                    {{-- <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>

                            <li class="breadcrumb-item active" aria-current="page">Job Details</li>
                        </ol>
                    </nav> --}}
                </div>

            </div>
        </div>
    </header>


    <section class="job-section section-padding section-padding-btm">
        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-12">
                    <h2 class="job-title mb-0">{{ $lowongan->posisi->posisi }}<span>
                            @if ($lowongan->level == 1)
                                (Junior)
                            @elseif ($lowongan->level == 2)
                                (Intermediate)
                            @elseif ($lowongan->level == 3)
                                (Senior)
                            @endif
                        </span></h2>

                    <div class="job-thumb job-thumb-detail">
                        <div class="d-flex flex-wrap align-items-center border-bottom pt-lg-3 pt-2 pb-3 mb-4">
                            <p class="job-location mb-0">
                                <i class="bi bi-geo-alt me-1"></i>
                                @if ($lowongan->metode == 1)
                                    Remote
                                @elseif ($lowongan->metode == 2)
                                    Onsite
                                @else
                                    Hybrid
                                @endif
                            </p>
                            <p class="job-location mb-0">
                                <i class="bi bi-clock me-1"></i>
                                {{ \Carbon\Carbon::parse($lowongan->periode->batas_pendaftaran)->translatedFormat('j F Y') }}
                            </p>
                            <p class="job-deadline mb-0">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $lowongan->periode['judul_periode'] }}
                                ({{ \Carbon\Carbon::parse($lowongan->periode['tanggal_mulai'])->translatedFormat('j F Y') }}
                                -
                                {{ \Carbon\Carbon::parse($lowongan->periode['tanggal_selesai'])->translatedFormat('j F Y') }})
                            </p>
                        </div>


                        <h4 class="mt-4 mb-2">Job Description</h4>

                        <p>{!! $lowongan->deskripsi !!}</p>

                        <h4 class="mt-4 mb-3">Requirements</h4>

                        <p>{!! $lowongan->kualifikasi !!}</p>

                        @if ($lowongan->keahlian_yang_dibutuhkan)
                            <h4 class="mt-4 mb-3">Required Skills</h4>
                            <ul>
                                @foreach (json_decode($lowongan->keahlian_yang_dibutuhkan) as $keahlian)
                                    <li>{{ $keahlian }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="d-flex justify-content-center flex-wrap mt-5 border-top pt-4">
                            @if (\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($lowongan->periode->batas_pendaftaran)))
                                <div class="alert alert-danger mb-0" role="alert">
                                    <strong>Pendaftaran Ditutup!</strong> Maaf, pendaftaran untuk lowongan ini telah
                                    ditutup.
                                </div>
                            @elseif($hasApplied)
                                <div class="alert alert-info mb-0" role="alert">
                                    <strong>Anda sudah melamar!</strong> Anda telah mengajukan lamaran untuk lowongan ini.
                                </div>
                            @else
                                <a href="{{ route('apply-job', $lowongan->uid) }}" class="custom-btn btn mt-2">Apply now</a>
                            @endif


                            <div class="job-detail-share d-flex align-items-center">
                                <p class="mb-0 me-lg-4 me-3">Share:</p>

                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}"
                                    target="_blank" class="bi-facebook"></a>

                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}"
                                    target="_blank" class="bi-twitter mx-3"></a>

                                <a href="https://api.whatsapp.com/send?text={{ urlencode(Request::url()) }}" target="_blank"
                                    class="bi-whatsapp"></a>

                                <a href="https://www.addtoany.com/share?url={{ urlencode(Request::url()) }}"
                                    target="_blank" class="bi-share mx-3"></a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12 mt-5 mt-lg-0">
                    <div class="job-thumb job-thumb-detail-box bg-white shadow-lg">

                        <h6 class="mt-4 mb-3">Contact Information</h6>

                        <p class="mb-2">
                            <i class="custom-icon bi-globe me-1"></i>

                            <a href="https://centralai.my.id/" class="site-footer-link">
                                centralai.my.id
                            </a>
                        </p>

                        <p>
                            <i class="custom-icon bi-envelope me-1"></i>

                            <a href="mailto:contact.centralai@gmail.com" class="site-footer-link">
                                contact.centralai@gmail.com
                            </a>
                        </p>
                    </div>
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
@endsection

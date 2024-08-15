@extends('front.layouts.main')

@section('content')
    <header class="site-header">
        <div class="section-overlay"></div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 text-center">
                    <h1 class="text-white">Job Listings</h1>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Job Listings</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section class="job-section section-padding">
        <div class="container">
            <div class="row align-items-center">
                @foreach ($lowongan as $job)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="job-thumbs job-thumbs-box">
                            <div class="job-body">
                                <h4 class="job-title">
                                    <a href="{{ route('job-details', $job->uid) }}" class="job-title-link">
                                        {{ $job->posisi->posisi }}
                                    </a>
                                </h4>

                                <div class="d-flex align-items-center">
                                    <p class="job-location">
                                        <i class="custom-icon bi-geo-alt me-1"></i>
                                        @switch($job->metode)
                                            @case(1)
                                                Remote
                                                @break
                                            @case(2)
                                                Onsite
                                                @break
                                            @default
                                                Hybrid
                                        @endswitch
                                    </p>
                                </div>

                                <div class="d-flex align-items-center border-top pt-3">
                                    @if (\Carbon\Carbon::now()->lte(\Carbon\Carbon::parse($job->periode->batas_pendaftaran)))
                                        @if ($job->days_left > 0)
                                            <span class="badge bg-success text-white">Batas Pendaftaran: {{ $job->days_left }} hari lagi</span>
                                        @elseif (isset($job->hours_left))
                                            <span class="badge bg-success text-white">Batas Pendaftaran: {{ $job->hours_left }} jam lagi</span>
                                        @else
                                            <span class="badge bg-success text-white">Batas Pendaftaran: Hari ini</span>
                                        @endif
                                    @else
                                        <span class="badge bg-danger text-white">Pendaftaran Ditutup</span>
                                    @endif

                                    <a href="{{ route('job-details', $job->uid) }}" class="custom-btn btn ms-auto">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-lg-12 col-12 mb-5">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-5">
                            @if ($lowongan->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">Prev</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $lowongan->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">Prev</span>
                                    </a>
                                </li>
                            @endif

                            @for ($i = 1; $i <= $lowongan->lastPage(); $i++)
                                @if ($i == $lowongan->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $lowongan->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            @if ($lowongan->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $lowongan->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">Next</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">Next</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
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
                    <p class="text-white">Melalui program magang, kami tidak hanya menawarkan kesempatan untuk belajar dan berkembang, tetapi juga menciptakan lingkungan yang mendukung untuk mengejar impian Anda. Dengan bimbingan dari para ahli di industri dan akses ke proyek-proyek yang menarik, Anda dapat mengembangkan keterampilan dan pengalaman yang diperlukan untuk mencapai kesuksesan di masa depan. Temukan peluang magang yang menarik dan mulailah perjalanan Anda menuju karier yang cemerlang bersama kami!</p>
                </div>
            </div>
        </div>
    </section>
@endsection

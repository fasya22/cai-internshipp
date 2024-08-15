@extends('front.layouts.main')

@section('content')
    <section class="hero-section d-flex justify-content-center align-items-center">
        <div class="section-overlay"></div>

        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12 mb-5 mb-lg-0 text-center">
                    <div class="hero-section-text mt-5">
                        <h5 class="text-white">Ready to Launch Your Career? Explore CAI-Internship!</h5>

                        <h3 class="hero-title text-white mt-4 mb-4">Unlock Your Potential with Valuable Internship
                            Experiences and Kickstart Your Professional Journey Today</h3>

                        <a href="#job-section" class="custom-btn custom-border-btn btn">Browse Job Listings</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section section-padding">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-12">
                    <div class="linkedin-block">
                        <img src="{{ asset('front/images/horizontal-shot-happy-mixed-race-females.jpg') }}"
                            class="about-image custom-border-radius-start img-fluid" alt="">

                        <div class="linkedin-block-text">
                            <a href="https://www.linkedin.com/company/centralai" class="custom-btn btn">
                                <i class="bi-linkedin"></i>
                                @centralai
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="custom-text-block">
                        <h3 class="text-white mb-2">Introduction Central AI</h3>

                        <p class="text-white">CENTRAL AI adalah digital startup yang berfokus dalam hal membantu pelayanan
                            cepat dan efektif untuk UMKM, perusahaan yang memiliki aplikasi atau website, universitas,
                            organisasi lain berbadan hukum maupun sejenisnya dengan menyediakan produk-produk berbasis
                            Artificial Intelligence seperti Chatbot, OCR, Point of Sales, Notula.</p>

                        <div class="custom-border-btn-wrap d-flex align-items-center mt-5">
                            <a href="/about" class="custom-btn custom-border-btn btn me-4">Get to know us</a>

                            <a href="#job-section" class="custom-link smoothscroll">Explore Jobs</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-12">
                    <div class="instagram-block">
                        <img src="{{ asset('front/images/horizontal-shot-happy-mixed-race-females.jpg') }}"
                            class="about-image custom-border-radius-end img-fluid" alt="">

                        <div class="instagram-block-text">
                            <a href="https://www.instagram.com/central_ai/" class="custom-btn btn">
                                <i class="bi-instagram"></i>
                                @central_ai
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="job-section job-featured-section section-padding section-padding-btm" id="job-section">
        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-12 text-center mx-auto mb-4">
                    <h2>Current Job Vacancies</h2>

                    <p>Bergabunglah dengan tim kami dan mulailah perjalanan menuju kesuksesan bersama kami! Di sini, kami
                        percaya bahwa setiap individu memiliki potensi yang luar biasa untuk mencapai impian dan tujuannya.
                    </p>
                </div>

                <div class="col-lg-12 col-12">
                    @foreach ($lowongan as $key => $value)
                        <div class="job-thumb d-flex">
                            <div class="job-image-wrap bg-white shadow-lg">
                                <img src="{{ asset('front/images/logos/job1.png') }}" class="job-image img-fluid"
                                    alt="">
                            </div>

                            <div class="job-body d-flex flex-wrap flex-auto align-items-center ms-4">
                                <div>
                                    <h4 class="job-title mb-lg-2">
                                        <a href="{{ route('job-details', $value->uid) }}"
                                            class="job-title-link">{{ $value->posisi->posisi }}
                                        </a>
                                    </h4>

                                    <div class="d-flex flex-wrap align-items-center">
                                        <p class=" job-location mb-0">
                                            <i class="custom-icon bi-calendar-event me-1"></i>

                                            {{ \Carbon\Carbon::parse($value->periode->batas_pendaftaran)->translatedFormat('j F Y') }}
                                        </p>
                                        </p>
                                        <p class="job-location mb-0">
                                            <i class="custom-icon bi-geo-alt me-1"></i>
                                            @if ($value->metode == 1)
                                                Remote
                                            @elseif ($value->metode == 2)
                                                Onsite
                                            @else
                                                Hybrid
                                            @endif
                                        </p>
                                        <p class="job-location mb-0">
                                            <i class="custom-icon bi-layers"></i>
                                            @if ($value->level == 1)
                                                Junior
                                            @elseif ($value->level == 2)
                                                Intermediate
                                            @elseif ($value->level == 3)
                                                Senior
                                            @endif
                                        </p>

                                    </div>
                                </div>

                                <div class="job-section-btn-wrap">
                                    <a href="{{ route('job-details', $value->uid) }}" class="custom-btn btn">Apply now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="col-lg-12 col-12 recent-jobs-bottom text-center">
                        <a href="/jobs" class="custom-btn btn ms-lg-auto">Browse Other Job Listings</a>
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

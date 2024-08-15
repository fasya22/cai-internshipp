@extends('front.layouts.main')

@section('content')
    <header class="site-header">
        <div class="section-overlay"></div>

        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12 text-center">
                    <h1 class="text-white">About Us</h1>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>

                            <li class="breadcrumb-item active" aria-current="page">About</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </header>


    <section class="about-section section-padding">
        <div class="container">
            <div class="row justify-content-center align-items-center">

                <div class="col-lg-5 col-12">
                    <div class="about-info-text">
                        <h2 class="mb-4">Introducing Central AI</h2>

                        {{-- <h4 class="mb-2">Get your new job</h4> --}}

                        <p style="line-height: 1.6; text-align: justify">CENTRAL AI adalah digital startup yang berfokus dalam hal membantu pelayanan cepat dan efektif untuk UMKM, perusahaan yang memiliki aplikasi atau website, universitas, organisasi lain berbadan hukum maupun sejenisnya dengan menyediakan produk-produk berbasis Artificial Intelligence seperti Chatbot, OCR, Point of Sales, Notula.</p>
                    </div>
                </div>

                <div class="col-lg-5 col-12 mt-5 mt-lg-0">
                    <div class="about-image-wrap">
                        <img src="{{asset('front/images/horizontal-shot-happy-mixed-race-females.jpg')}}" class="about-image about-image-border-radius img-fluid" alt="">

                        <div class="about-info d-flex align-items-center mt-4">
                            <a href="#services-section" class="custom-btn btn btn me-4">Explore Project</a>

                            <a href="/contact" class="custom-link smoothscroll"><b>Contact</b></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="services-section section-padding" id="services-section">
        <div class="container">
            <div class="row mb-5">

                <div class="col-lg-12 col-12 text-center">
                    <h2 class="mb-5">Our Experience Projects</h2>
                </div>

                <div class="services-block-wrap col-lg-4 col-md-6 col-12 mb-4">
                    <div class="services-block">
                        <div class="services-block-title-wrap">
                            <i class="services-block-icon bi-twitch"></i>

                            <h4 class="services-block-title">Chatbot</h4>
                        </div>

                        <div class="services-block-body">
                            <p>Aplikasi Chatbot kami menggunakan kecerdasan buatan untuk berinteraksi dengan pengguna secara real-time. Dengan antarmuka ramah pengguna, Chatbot kami memberikan solusi cepat dan efisien untuk pertanyaan dan permintaan pengguna.</p>
                        </div>
                    </div>
                </div>

                <div class="services-block-wrap col-lg-4 col-md-6 col-12 mb-4">
                    <div class="services-block">
                        <div class="services-block-title-wrap">
                            <i class="services-block-icon bi-twitch"></i>

                            <h4 class="services-block-title">Point of Sales</h4>
                        </div>

                        <div class="services-block-body">
                            <p>Sistem Point of Sales kami dirancang untuk memudahkan proses transaksi di berbagai jenis bisnis. Dengan fitur manajemen stok dan laporan penjualan yang canggih, aplikasi ini membantu efisiensi operasional dan pengambilan keputusan strategis.</p>
                        </div>
                    </div>
                </div>

                <div class="services-block-wrap col-lg-4 col-md-6 col-12 mb-4">
                    <div class="services-block">
                        <div class="services-block-title-wrap">
                            <i class="services-block-icon bi-play-circle-fill"></i>

                            <h4 class="services-block-title">Optical Character Recognition (OCR)</h4>
                        </div>

                        <div class="services-block-body">
                            <p>Aplikasi Optical Character Recognition (OCR) kami menggunakan teknologi canggih untuk mengenali dan mengonversi teks dari gambar atau dokumen fisik ke format digital.</p>
                        </div>
                    </div>
                </div>
                <div class="services-block-wrap col-lg-4 col-md-6 col-12 mb-4">
                    <div class="services-block">
                        <div class="services-block-title-wrap">
                            <i class="services-block-icon bi-window"></i>

                            <h4 class="services-block-title">Traffic Management System</h4>
                        </div>

                        <div class="services-block-body">
                            <p>Sistem Manajemen Lalu Lintas kami membantu mengoptimalkan aliran lalu lintas di berbagai area. Dengan pemantauan real-time dan analisis data, aplikasi ini meningkatkan efisiensi pengaturan lalu lintas dan mengurangi kemacetan.</p>
                        </div>
                    </div>
                </div>

                <div class="services-block-wrap col-lg-4 col-md-6 col-12 mb-4">
                    <div class="services-block">
                        <div class="services-block-title-wrap">
                            <i class="services-block-icon bi-twitch"></i>

                            <h4 class="services-block-title">Sentiment Analysis</h4>
                        </div>

                        <div class="services-block-body">
                            <p>Aplikasi Sentiment Analysis kami menggunakan kecerdasan buatan untuk menganalisis sentimen dari teks atau data pengguna. Ini memberikan wawasan berharga tentang persepsi dan tanggapan pengguna terhadap suatu topik atau produk.</p>
                        </div>
                    </div>
                </div>

                <div class="services-block-wrap col-lg-4 col-md-6 col-12 mb-4">
                    <div class="services-block">
                        <div class="services-block-title-wrap">
                            <i class="services-block-icon bi-play-circle-fill"></i>

                            <h4 class="services-block-title">Blog System</h4>
                        </div>

                        <div class="services-block-body">
                            <p>Sistem Blog kami memberikan platform yang mudah digunakan untuk membuat dan mengelola konten blog. Dengan fitur pengeditan yang intuitif, pengguna dapat dengan mudah berbagi ide, informasi, dan pengalaman.</p>
                        </div>
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

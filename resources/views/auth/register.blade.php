@extends('front.layouts.main')

@section('content')

<header class="site-header">
    <div class="section-overlay"></div>

    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12 text-center">
                <h1 class="text-white">Register</h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>

                        <li class="breadcrumb-item active" aria-current="page">Register</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>
</header>

<section class="login-section section-padding section-padding-btm">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12 mx-auto">
                <form class="custom-form contact-form" role="form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12 mb-3">
                            <label for="name">Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 mb-3">
                            <label for="email">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 mb-3">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 mb-3">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="col-lg-4 col-md-4 col-6 mx-auto">
                            <button type="submit" class="form-control">Register</button>
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

                <p class="text-white">Melalui program magang, kami tidak hanya menawarkan kesempatan untuk belajar dan berkembang, tetapi juga menciptakan lingkungan yang mendukung untuk mengejar impian Anda. Dengan bimbingan dari para ahli di industri dan akses ke proyek-proyek yang menarik, Anda dapat mengembangkan keterampilan dan pengalaman yang diperlukan untuk mencapai kesuksesan di masa depan. Temukan peluang magang yang menarik dan mulailah perjalanan Anda menuju karier yang cemerlang bersama kami!</p>
            </div>
        </div>
    </div>
</section>

@endsection

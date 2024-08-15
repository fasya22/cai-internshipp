@extends('front.layouts.main')

@section('content')
    <header class="site-header">
        <div class="section-overlay"></div>

        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12 text-center">
                    <h1 class="text-white">Login</h1>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>

                            <li class="breadcrumb-item active" aria-current="page">Login</li>
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
                    <form class="custom-form contact-form" role="form" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="email">Email Address</label>

                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback mb-1 mt-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="password">Password</label>

                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @if (Route::has('password.request'))
                            <div class="form-group m-t-10 mb-3 row">
                                <div class="col-12 m-t-20 text-center">
                                    <a href="{{ route('password.request') }}" class="text-muted"><i class="fa fa-lock"></i> {{ __('Forgot Your Password?') }}</a>
                                </div>
                            </div>

                            @endif
                            <div class="col-lg-4 col-md-4 col-6 mx-auto">
                                <button type="submit" class="form-control">LOGIN</button>
                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
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
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var emailInput = document.getElementById('email');
            var passwordInput = document.getElementById('password');

            emailInput.oninvalid = function(event) {
                if (!event.target.validity.valid) {
                    if (event.target.validity.valueMissing) {
                        event.target.setCustomValidity('Email harus diisi.');
                    } else if (event.target.validity.typeMismatch) {
                        event.target.setCustomValidity('Format email tidak valid.');
                    }
                }
            }

            emailInput.oninput = function(event) {
                event.target.setCustomValidity('');
            }

            passwordInput.oninvalid = function(event) {
                if (!event.target.validity.valid) {
                    event.target.setCustomValidity('Password harus diisi.');
                }
            }

            passwordInput.oninput = function(event) {
                event.target.setCustomValidity('');
            }
        });
    </script> --}}
@endsection

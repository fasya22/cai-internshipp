<nav class="navbar navbar-expand-lg fixed-top" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{asset('front/images/logo.png')}}" class="img-fluid logo-image">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav align-items-center ms-lg-5">
                <li class="nav-item">
                    <a class="nav-link active" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/about">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/jobs">Jobs</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/contact">Contact</a>
                </li>

                @if(auth()->check())
                <li class="nav-item ms-lg-auto me-2">
                    <a class="nav-link custom-btn btn" href="/home">Dashboard</a>
                </li>
                <li class="nav-item ">
                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
                        @csrf <!-- Tambahkan token CSRF untuk perlindungan form -->
                    </form>
                    <a class="nav-link custom-btn btn" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
                @else
                    <li class="nav-item ms-lg-auto">
                        <a class="nav-link" href="/register">Register</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link custom-btn btn" href="/login">Login</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

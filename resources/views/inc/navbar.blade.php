{{-- <div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <a href="/" class="logo">
            <span>
                <img src="{{asset('front/images/logo.png')}}" alt="" height="18">
            </span>
            <i>
                <img src="{{asset('front/images/icon.png')}}" alt="" height="22">
            </i>
        </a>
    </div>

    <nav class="navbar-custom">

        <ul class="navbar-right d-flex list-inline float-right mb-0">

            <li class="dropdown notification-list">
                <div class="dropdown notification-list nav-pro-img">
                    <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ asset('dashboard/images/users/user-4.jpg') }}" alt="user"
                            class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                        <!-- item-->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="mdi mdi-power text-danger"></i> {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </li>


        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left waves-effect">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>
        </ul>

    </nav>

  </div> --}}
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">

                <a href="/" class="logo">
                    <img src="{{ asset('front/images/logo.png') }}" alt="" class="logo-small">
                    <img src="{{ asset('front/images/logo.png') }}" alt="" class="logo-large">
                </a>

            </div>
            <!-- End Logo container-->


            <div class="menu-extras topbar-custom">

                <ul class="float-right list-unstyled mb-0 ">
                    <li class="dropdown notification-list">
                        <div class="dropdown notification-list nav-pro-img">
                            @IsPeserta
                                <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown"
                                    href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    @if (Auth::user()->peserta && Auth::user()->peserta->image)
                                        <img src="{{ asset('storage/images/' . Auth::user()->peserta->image) }}" alt="user"
                                            class="rounded-circle">
                                    @else
                                        <img src="{{ asset('admin/images/users/user.png') }}" alt="user"
                                            class="rounded-circle">
                                    @endif
                                </a>
                            @endIsPeserta
                            @IsMentor
                                <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown"
                                    href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    @if (Auth::user()->mentor && Auth::user()->mentor->image)
                                        <img src="{{ asset('storage/images/' . Auth::user()->mentor->image) }}" alt="user"
                                            class="rounded-circle">
                                    @else
                                        <img src="{{ asset('admin/images/users/user.png') }}" alt="user"
                                            class="rounded-circle">
                                    @endif
                                </a>
                            @endIsMentor
                            @IsHrd
                                <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown"
                                    href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    @if (Auth::user()->hrd && Auth::user()->hrd->image)
                                        <img src="{{ asset('storage/images/' . Auth::user()->hrd->image) }}" alt="user"
                                            class="rounded-circle">
                                    @else
                                        <img src="{{ asset('admin/images/users/user.png') }}" alt="user"
                                            class="rounded-circle">
                                    @endif
                                </a>
                            @endIsHrd
                            @IsAdmin
                                <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown"
                                    href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="{{ asset('admin/images/users/user.png') }}" alt="user"
                                        class="rounded-circle">
                                </a>
                            @endIsAdmin
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown w-auto">
                                <!-- item-->
                                @IsPeserta
                                <a class="dropdown-item">
                                    <i class="mdi mdi-account-box text-primary m-r-5"></i> {{ Auth::user()->name }}
                                </a>
                                    <a class="dropdown-item"
                                        href="{{ route('profil-peserta.show', ['uid' => Auth::user()->uid]) }}">
                                        <i class="mdi mdi-tooltip-edit text-primary m-r-5"></i> Edit Profile
                                    </a>
                                @endIsPeserta
                                @IsMentor
                                <a class="dropdown-item">
                                    <i class="mdi mdi-account-box text-primary m-r-5"></i> {{ Auth::user()->name }}
                                </a>
                                    <a class="dropdown-item"
                                        href="{{ route('profil-mentor.show', ['uid' => Auth::user()->uid]) }}">
                                        <i class="mdi mdi-tooltip-edit text-primary m-r-5"></i> Edit Profile
                                    </a>
                                @endIsMentor
                                @IsHrd
                                <a class="dropdown-item">
                                    <i class="mdi mdi-account-box text-primary m-r-5"></i> {{ Auth::user()->name }}
                                </a>
                                    <a class="dropdown-item"
                                        href="{{ route('profil-hrd.show', ['uid' => Auth::user()->uid]) }}">
                                        <i class="mdi mdi-tooltip-edit text-primary m-r-5"></i> Edit Profile
                                    </a>
                                @endIsHrd
                                @IsAdmin
                                <a class="dropdown-item">
                                    <i class="mdi mdi-account-box text-primary m-r-5"></i> {{ Auth::user()->name }}
                                </a>
                                    <a class="dropdown-item"
                                        href="{{ route('profil-admin.show', ['uid' => Auth::user()->uid]) }}">
                                        <i class="mdi mdi-tooltip-edit text-primary m-r-5"></i> Edit Profile
                                    </a>
                                @endIsAdmin
                                <div class="dropdown-divider"></div>
                                {{-- <a class="dropdown-item text-danger" href="#"><i class="mdi mdi-power text-danger"></i> Logout</a> --}}
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="mdi mdi-power text-danger"></i> {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>

                    </li>
                    <li class="menu-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link" id="mobileToggle">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>
                </ul>
            </div>
            <!-- end menu-extras -->

            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">@yield('page-title')</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                        {{-- <li class="breadcrumb-item"><a href="javascript:void(0);">@yield('breadcrumb-section')</a></li> --}}
                        <li class="breadcrumb-item active">@yield('breadcrumb-title')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- MENU Start -->
    <div class="navbar-custom">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                    @IsAdmin
                        <li class="has-submenu">
                            <a href="/home">
                                <i class="mdi mdi-view-dashboard"></i><span> Dashboard </span>
                            </a>
                        </li>
                        <li class="has-submenu">
                            <a href="javascript:void(0);">
                                <i class="mdi mdi-database"></i>Data Master
                            </a>
                            <ul class="submenu">
                                <li><a href="/periode">Periode</a></li>
                                <li><a href="/posisi">Posisi</a></li>
                                <li><a href="/aspek-penilaian">Aspek Penilaian</a></li>
                                <li><a href="/english-certificates">Jenis Sertifikat</a></li>
                            </ul>
                        </li>
                        {{-- <li class="has-submenu">
                            <a href="javascript:void(0);">
                                <i class="mdi mdi-format-list-bulleted-type"></i>Mentor</a>
                            <ul class="submenu">
                                <li><a href="/mentor">Data Mentor</a></li>
                                <li><a href="/user-mentor">Akun Mentor</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="javascript:void(0);">
                                <i class="mdi mdi-format-list-bulleted-type"></i>HRD</a>
                            <ul class="submenu">
                                <li><a href="/hrd">Data HRD</a></li>
                                <li><a href="/user-hrd">Akun HRD</a></li>
                            </ul>
                        </li> --}}
                        <li class="has-submenu">
                            <a href="/mentor">
                                <i class="mdi mdi-account-card-details"></i><span> Mentor </span>
                            </a>
                        </li>
                        <li class="has-submenu">
                            <a href="/hrd">
                                <i class="mdi mdi-account-card-details"></i><span> HRD </span>
                            </a>
                        </li>

                        <li class="has-submenu">
                            <a href="/lowongan">
                                <i class="mdi mdi-briefcase"></i><span> Lowongan </span>
                            </a>
                        </li>
                        <li class="has-submenu">
                            <a href="/list-pendaftar">
                                <i class="mdi mdi-account-multiple"></i><span> Daftar Pelamar </span>
                            </a>
                        </li>
                        <li class="has-submenu">
                            <a href="/peserta-magang">
                                <i class="mdi mdi-account-check"></i><span> Peserta Magang </span>
                            </a>
                        </li>
                        <li class="has-submenu">
                            <a href="/kegiatan-magang">
                                <i class="mdi mdi-history"></i><span> History Magang </span>
                            </a>
                        </li>
                    @endIsAdmin
                    @IsMentor
                        <li class="has-submenu">
                            <a href="/home">
                                <i class="mdi mdi-view-dashboard"></i><span> Dashboard </span>
                            </a>
                        </li>
                        <li class="has-submenu">
                            <a href="/kegiatan-magang">
                                <i class="mdi mdi-history"></i><span> History Magang </span>
                            </a>
                        </li>
                    @endIsMentor
                    @IsHrd
                        <li class="has-submenu">
                            <a href="/home">
                                <i class="mdi mdi-view-dashboard"></i><span> Dashboard </span>
                            </a>
                        </li>
                        <li class="has-submenu">
                            <a href="/daftar-pelamar">
                                <i class="mdi mdi-history"></i><span> Daftar Pelamar </span>
                            </a>
                        </li>
                    @endIsHrd
                    @IsPeserta
                        <li class="has-submenu">
                            <a href="/home">
                                <i class="mdi mdi-view-dashboard"></i><span> Dashboard </span>
                            </a>
                        </li>
                        <li class="has-submenu">
                            <a href="/history-magang">
                                <i class="mdi mdi-history"></i><span> History Magang </span>
                            </a>
                        </li>
                    @endIsPeserta
                </ul>
                <!-- End navigation menu -->
            </div> <!-- end navigation -->
        </div> <!-- end container-fluid -->
    </div> <!-- end navbar-custom -->
</header>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
    var submenuToggle = document.querySelectorAll('.has-submenu > a');

    submenuToggle.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            var submenu = this.nextElementSibling;

            if (submenu.classList.contains('open')) {
                submenu.classList.remove('open');
            } else {
                // Close other open submenus
                document.querySelectorAll('.submenu.open').forEach(function(openSubmenu) {
                    openSubmenu.classList.remove('open');
                });
                submenu.classList.add('open');
            }
        });
    });
});

</script> --}}

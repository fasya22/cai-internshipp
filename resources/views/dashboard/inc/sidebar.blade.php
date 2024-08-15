<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                {{-- <li class="menu-title">Main</li> --}}
                @IsAdmin
                    <li>
                        <a href="/home" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Dashboard </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="waves-effect"><i
                                class="mdi mdi-format-list-bulleted-type"></i><span> Data Master <span
                                    class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                        <ul class="submenu">
                            <li><a href="/periode">Periode</a></li>
                            <li><a href="/posisi">Posisi</a></li>
                            <li><a href="/aspek-penilaian">Aspek Penilaian</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="waves-effect"><i
                                class="mdi mdi-format-list-bulleted-type"></i><span> Mentor <span
                                    class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                        <ul class="submenu">
                            <li><a href="/mentor">Data Mentor</a></li>
                            <li><a href="/user-mentor">Akun Mentor</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="/peserta" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Peserta </span>
                        </a>
                    </li>
                    <li>
                        <a href="/lowongan" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Lowongan </span>
                        </a>
                    </li>
                    <li>
                        <a href="/list-pendaftar" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> List Pendaftar </span>
                        </a>
                    </li>
                    <li>
                        <a href="/peserta-magang" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Peserta Magang </span>
                        </a>
                    </li>
                    <li>
                        <a href="/project" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Project </span>
                        </a>
                    </li>
                    <li>
                        <a href="/penilaian" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Penilaian </span>
                        </a>
                    </li>
                    <li>
                        <a href="/logbook" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Aktivitas Harian </span>
                        </a>
                    </li>
                @endIsAdmin
                @IsPeserta
                    <li>
                        <a href="/home" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Dashboard </span>
                        </a>
                    </li>
                    <li>
                        <a href="/history-magang" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Riwayat Magang </span>
                        </a>
                    </li>
                    <li>
                        <a href="/project" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Project </span>
                        </a>
                    </li>
                    <li>
                        <a href="/penilaian" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Penilaian </span>
                        </a>
                    </li>
                    <li>
                        <a href="/logbook" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Aktivitas Harian </span>
                        </a>
                    </li>
                @endIsPeserta
                @IsMentor
                    <li>
                        <a href="/home" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Dashboard </span>
                        </a>
                    </li>
                    <li>
                        <a href="/history-magang" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Riwayat Magang </span>
                        </a>
                    </li>
                    <li>
                        <a href="/peserta" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Peserta </span>
                        </a>
                    </li>
                    <li>
                        <a href="/penilaian" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Penilaian </span>
                        </a>
                    </li>
                    <li>
                        <a href="/project" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Project </span>
                        </a>
                    </li>
                    <li>
                        <a href="/logbook" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Aktivitas Harian </span>
                        </a>
                    </li>
                @endIsMentor

            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>

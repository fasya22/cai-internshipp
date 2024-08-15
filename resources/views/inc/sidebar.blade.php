<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                @IsAdmin
                    <li id="admin-dashboard">
                        <a href="/home" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Dashboard </span>
                        </a>
                    </li>
                    <li id="admin-data-master">
                        <a href="javascript:void(0);" class="waves-effect">
                            <i class="mdi mdi-format-list-bulleted-type"></i><span> Data Master <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span>
                        </a>
                        <ul class="submenu">
                            <li><a href="/periode">Periode</a></li>
                            <li><a href="/posisi">Posisi</a></li>
                            <li><a href="/aspek-penilaian">Aspek Penilaian</a></li>
                            <li><a href="/english-certificates">Jenis Sertifikat</a></li>
                        </ul>
                    </li>
                    <li id="admin-mentor">
                        <a href="javascript:void(0);" class="waves-effect">
                            <i class="mdi mdi-format-list-bulleted-type"></i><span> Mentor <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span>
                        </a>
                        <ul class="submenu">
                            <li><a href="/mentor">Data Mentor</a></li>
                            <li><a href="/user-mentor">Akun Mentor</a></li>
                        </ul>
                    </li>
                    <li id="admin-hrd">
                        <a href="javascript:void(0);" class="waves-effect">
                            <i class="mdi mdi-format-list-bulleted-type"></i><span> HRD <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span>
                        </a>
                        <ul class="submenu">
                            <li><a href="/hrd">Data HRD</a></li>
                            <li><a href="/user-hrd">Akun HRD</a></li>
                        </ul>
                    </li>
                    {{-- <li id="admin-peserta">
                        <a href="/peserta" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Peserta </span>
                        </a>
                    </li> --}}
                    <li id="admin-lowongan">
                        <a href="/lowongan" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Lowongan </span>
                        </a>
                    </li>
                    <li id="admin-list-pendaftar">
                        <a href="/list-pendaftar" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> List Pendaftar </span>
                        </a>
                    </li>
                    <li id="admin-peserta-magang">
                        <a href="/peserta-magang" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Peserta Magang </span>
                        </a>
                    </li>
                    <li id="">
                        <a href="kegiatan-magang" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Riwayat Magang </span>
                        </a>
                    </li>
                @endIsAdmin
                @IsPeserta
                    <li id="peserta-dashboard">
                        <a href="/home" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Dashboard </span>
                        </a>
                    </li>
                    <li id="peserta-history-magang">
                        <a href="/history-magang" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Riwayat Magang </span>
                        </a>
                    </li>
                    {{-- <li id="peserta-project">
                        <a href="/project" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Project </span>
                        </a>
                    </li>
                    <li id="peserta-penilaian">
                        <a href="/penilaian" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Penilaian </span>
                        </a>
                    </li>
                    <li id="peserta-logbook">
                        <a href="/logbook" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Aktivitas Harian </span>
                        </a>
                    </li> --}}

                @endIsPeserta
                @IsMentor
                    <li id="mentor-dashboard">
                        <a href="/home" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Dashboard </span>
                        </a>
                    </li>
                    <li id="">
                        <a href="kegiatan-magang" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Riwayat Magang </span>
                        </a>
                    </li>
                @endIsMentor
                @IsHrd
                    <li id="hrd-dashboard">
                        <a href="/home" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Dashboard </span>
                        </a>
                    </li>
                    <li id="hrd-list-pendaftar">
                        <a href="/list-pendaftar" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> List Pendaftar </span>
                        </a>
                    </li>
                @endIsHrd
            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var path = window.location.pathname;

        // Peserta pages
        if (path === '/home') {
            document.getElementById('peserta-project').style.display = 'none';
            document.getElementById('peserta-penilaian').style.display = 'none';
            document.getElementById('peserta-logbook').style.display = 'none';
        } else {
            document.getElementById('peserta-dashboard').style.display = 'none';
            document.getElementById('peserta-history-magang').style.display = 'none';
            // document.getElementById('peserta-project').style.display = 'block';
            // document.getElementById('peserta-penilaian').style.display = 'block';
            // document.getElementById('peserta-logbook').style.display = 'block';
        }

    });
</script> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Logbook</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 120px;
            height: auto;
            margin-bottom: 10px;
        }

        .info-table {
            margin-bottom: 20px;
        }

        .info-table td,
        .info-table th {
            padding-right: 10px;
        }

        .ttd {
            margin-top: 30px;
            text-align: center;
            margin-left: 60%
        }

        .line {
            border: 1px solid black;
            width: 75%;
            margin: auto;
        }

        .ttd-isi {
            margin-top: 60px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="https://res.cloudinary.com/dvwsffyzc/image/upload/v1717855439/aer7ftzvs1gjiqdb56zh.png"
                alt="Logo">
        </div>
        <h4>Aktivitas Harian Magang</h4>
        <h4>PT Central Artificial Intelligence</h4>
    </div>
    <table class="info-table">
        <tr>
            <td>Nama Peserta</td>
            <td>:</td>
            <td>{{ $logbooks->first()->magang->peserta->nama }}</td>
        </tr>
        <tr>
            <td>Posisi</td>
            <td>:</td>
            <td>{{ $logbooks->first()->magang->lowongan->posisi->posisi }}</td>
        </tr>
        <tr>
            <td>Periode</td>
            <td>:</td>
            <td>{{ $logbooks->first()->magang->periode['judul_periode'] }}
                ({{ \Carbon\Carbon::parse($logbooks->first()->magang->periode['tanggal_mulai'])->translatedFormat('j F Y') }}
                -
                {{ \Carbon\Carbon::parse($logbooks->first()->magang->periode['tanggal_selesai'])->translatedFormat('j F Y') }})
            </td>
        </tr>
    </table>

    <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dates as $date)
                    @php
                        $logbook = $logbooks->where('tanggal', $date)->first();
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($date)->translatedFormat('j F Y') }}</td>
                        <td>{!! $logbook ? ($logbook->aktivitas) : 'Tidak ada aktivitas' !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="ttd">
        <p>{{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}
        </p>
        <div class="ttd-isi">
            <p style="margin-bottom: 4px">Salwa Ziada Salsabiila</p>
            <div class="line"></div>
            <p>CEO PT Central Artificial Intelligence</p>
        </div>
    </div>

</body>

</html>

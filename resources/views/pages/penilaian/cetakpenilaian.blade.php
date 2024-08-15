<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Penilaian</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tambahkan gaya CSS yang diperlukan untuk mencetak */
        /* Misalnya, Anda dapat menyembunyikan elemen-elemen yang tidak ingin dicetak */
        /* @media print {
            @page {
                size: A4 landscape;
            }
            .no-print {
                display: none !important;
            }
        } */
        @page {
            size: A4 landscape;
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
        }

        .line {
            border: 1px solid black;
            width: 20%;
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
        <h4>Penilaian Hasil Magang</h4>
        <h4>PT Central Artificial Intelligence</h4>
    </div>
    @foreach ($penilaians as $penilaian)
        <table class="info-table">
            <tr>
                <td>Nama Peserta</td>
                <td>:</td>
                <td>{{ $penilaian->magang->peserta['nama'] }}</td>
            </tr>
            <tr>
                <td>Posisi</td>
                <td>:</td>
                <td>{{ $penilaian->magang->lowongan->posisi->posisi }}</td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>:</td>
                <td>{{ $penilaian->magang->periode['judul_periode'] }}
                    ({{ \Carbon\Carbon::parse($penilaian->magang->periode['tanggal_mulai'])->translatedFormat('j F Y') }}
                    -
                    {{ \Carbon\Carbon::parse($penilaian->magang->periode['tanggal_selesai'])->translatedFormat('j F Y') }})
                </td>
            </tr>
        </table>
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <tbody>
                    <tr>
                        <td><b>Aspek Penilaian</b></td>
                        <td><b>Bobot (%)</b></td>
                        <td><b>Nilai</b></td>
                        <td><b>Hasil</b></td>
                    </tr>

                    @foreach ($aspeks as $aspek)
                        <tr>
                            <td>{{ $aspek->aspek }}</td>
                            <td>{{ number_format($aspek->bobot, 0) }}%</td>
                            <td>
                                {{ isset($penilaian->nilai[$aspek->id]) ? $penilaian->nilai[$aspek->id] : '0' }}
                            </td>
                            <td>
                                {{ number_format(($aspek->bobot / 100) * (isset($penilaian->nilai[$aspek->id]) ? $penilaian->nilai[$aspek->id] : 0), 2) }}
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="3">Total Nilai</td>
                        <td>{{ $penilaians->sum('total_nilai') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach
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

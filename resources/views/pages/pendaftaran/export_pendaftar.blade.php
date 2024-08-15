<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pendaftar Magang</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Daftar Pendaftar Magang</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Posisi</th>
                <th>Tahap Seleksi</th>
                <th>Nilai Seleksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($magangData as $key => $value)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $value->peserta->nama }}</td>
                    <td>{{ $value->lowongan->posisi->posisi }}</td>
                    <td>
                        @if (is_null($value->status_rekomendasi))
                            Seleksi Berkas
                        @elseif ($value->status_rekomendasi === 1)
                            @if (is_null($value->status_penerimaan))
                                Technical Test
                            @elseif ($value->status_penerimaan === 1)
                                Lolos Seleksi
                            @elseif ($value->status_penerimaan === 2)
                                Tidak Lolos
                            @endif
                        @elseif ($value->status_rekomendasi === 3)
                            Tidak Direkomendasikan
                        @endif
                    </td>
                    <td>
                        @if ($value->seleksi)
                            {{ $value->seleksi->nilai_seleksi }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

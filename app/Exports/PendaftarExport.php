<?php

namespace App\Exports;

use App\Models\MagangModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftarExport implements FromCollection, WithHeadings
{
    protected $posisi;
    protected $periode;

    public function __construct($posisi, $periode)
    {
        $this->posisi = $posisi;
        $this->periode = $periode;
    }

    public function collection()
    {
        $query = MagangModel::with(['peserta', 'lowongan.posisi']);

        if ($this->posisi) {
            $query->whereHas('lowongan', function ($q) {
                $q->where('posisi_id', $this->posisi);
            });
        }

        if ($this->periode) {
            $query->whereHas('lowongan', function ($q) {
                $q->where('periode_id', $this->periode);
            });
        }

        $results = $query->orderBy('created_at', 'desc')->get();

        return $results->map(function ($value, $key) {
            return [
                'No' => $key + 1,
                'Nama' => $value->peserta->nama,
                'Posisi' => $value->lowongan->posisi->posisi,
                'Tahap Seleksi' => $this->getTahapSeleksi($value),
                'Nilai Seleksi' => $value->seleksi ? $value->seleksi->nilai_seleksi : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Posisi',
            'Tahap Seleksi',
            'Nilai Seleksi',
        ];
    }

    protected function getTahapSeleksi($value)
    {
        if (is_null($value->status_rekomendasi)) {
            return 'Seleksi Berkas';
        } elseif ($value->status_rekomendasi === 1) {
            if (is_null($value->status_penerimaan)) {
                return 'Technical Test';
            } elseif ($value->status_penerimaan === 1) {
                return 'Lolos Seleksi';
            } elseif ($value->status_penerimaan === 2) {
                return 'Tidak Lolos';
            }
        } elseif ($value->status_rekomendasi === 3) {
            return 'Tidak Direkomendasikan';
        }
    }
}

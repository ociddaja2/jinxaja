<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * Get the collection of peminjamans to export.
     */
    public function collection()
    {
        return Peminjaman::with(['user', 'alat'])
            ->latest()
            ->get();
    }

    /**
     * Define the headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'No',
            'Peminjam',
            'Alat',
            'Tanggal Pinjam',
            'Tgl Kembali Rencana',
            'Tgl Kembali Realisasi',
            'Status',
            'Catatan',
            'Dibuat Pada',
        ];
    }

    /**
     * Map the data for each row.
     */
    public function map($peminjaman): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $peminjaman->user->name,
            $peminjaman->alat->nama_alat,
            $peminjaman->tanggal_pinjam,
            $peminjaman->tanggal_kembali_rencana,
            $peminjaman->tanggal_kembali_realisasi ?? '-',
            ucfirst($peminjaman->status),
            $peminjaman->catatan ?? '-',
            $peminjaman->created_at->format('d/m/Y H:i'),
        ];
    }

    /**
     * Style the worksheet.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

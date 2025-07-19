<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $from;
    protected $to;
    protected $totalPendapatan;

    public function __construct($from = null, $to = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->totalPendapatan = 0;
    }

    public function collection()
    {
        $query = Order::with(['detailOrders.menu', 'user']);
        if ($this->from && $this->to) {
            $query->whereBetween('tgl', [$this->from, $this->to]);
        }
        $orders = $query->get();
        $rows = collect();
        $this->totalPendapatan = 0;
        foreach ($orders as $order) {
            $pemasukan = $order->detailOrders->sum('subtotal');
            $this->totalPendapatan += $pemasukan;
            foreach ($order->detailOrders as $detail) {
                $rows->push([
                    'tgl' => $order->tgl,
                    'user_name' => $order->user->user_name,
                    'menu' => $detail->menu->nama_menu,
                    'qty' => $detail->qty,
                    'harga_satuan' => $detail->harga_satuan,
                    'subtotal' => $detail->subtotal,
                    'jml_bayar' => $order->jml_bayar,
                    'kembalian' => $order->kembalian,
                    'pemasukan' => $pemasukan,
                ]);
            }
        }
        return $rows;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Kasir',
            'Menu',
            'Qty',
            'Harga Satuan',
            'Subtotal',
            'Jumlah Bayar',
            'Kembalian',
            'Pemasukan',
        ];
    }

    public function map($row): array
    {
        return [
            Carbon::parse($row['tgl'])->translatedFormat('d F Y'),
            $row['user_name'],
            $row['menu'],
            $row['qty'],
            'Rp ' . number_format($row['harga_satuan'], 0, ',', '.'),
            'Rp ' . number_format($row['subtotal'], 0, ',', '.'),
            'Rp ' . number_format($row['jml_bayar'], 0, ',', '.'),
            'Rp ' . number_format($row['kembalian'], 0, ',', '.'),
            'Rp ' . number_format($row['pemasukan'], 0, ',', '.'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Insert 4 rows at the top for title, periode, spacing, header at row 5
        $sheet->insertNewRowBefore(1, 4);

        // Title (D1:H1)
        $sheet->setCellValue('D1', 'Laporan Transaksi');
        $sheet->mergeCells('D1:H1');
        $sheet->getStyle('D1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Periode (A2:K2)
        $periodeText = 'Periode: ';
        if ($this->from && $this->to) {
            $periodeText .= Carbon::parse($this->from)->translatedFormat('d F Y') . ' - ' . Carbon::parse($this->to)->translatedFormat('d F Y');
        } else {
            $periodeText .= 'Semua Waktu';
        }
        $sheet->setCellValue('A2', $periodeText);
        $sheet->mergeCells('A2:K2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getRowDimension(2)->setRowHeight(20);

        // Spacing rows 3 & 4
        $sheet->getRowDimension(3)->setRowHeight(5);
        $sheet->getRowDimension(4)->setRowHeight(5);

        // Header styling row 5
        $sheet->getStyle('A5:I5')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1F497D'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);
        $sheet->getRowDimension(5)->setRowHeight(30);

        // Data styling A6:K last row (abu abu muda)
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle("A6:I{$highestRow}")->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFF2F2F2'],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Set column widths (adjust untuk A4 landscape)
        foreach(range('A', 'I') as $columnID) {
            if (in_array($columnID, ['E', 'F', 'G', 'H', 'I'])) {
                $sheet->getColumnDimension($columnID)->setWidth(15);
            } else {
                $sheet->getColumnDimension($columnID)->setWidth(10);
            }
        }

        // Footer total pendapatan 2 baris setelah data terakhir
        $footerRow = $highestRow + 2;
        $sheet->setCellValue("J{$footerRow}", 'Total Pendapatan:');
        $sheet->setCellValue("K{$footerRow}", 'Rp ' . number_format($this->totalPendapatan, 0, ',', '.'));
        $sheet->getStyle("J{$footerRow}:K{$footerRow}")->getFont()->setBold(true);
        $sheet->getStyle("K{$footerRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Atur orientasi dan ukuran kertas A4 landscape di sini
        $pageSetup = $sheet->getPageSetup();
        $pageSetup->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $pageSetup->setPaperSize(PageSetup::PAPERSIZE_A4);
    }
}

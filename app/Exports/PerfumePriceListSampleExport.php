<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PerfumePriceListSampleExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithTitle
{
    public function title(): string
    {
        return 'Perfume Price List';
    }

    public function headings(): array
    {
        return [
            'Name',
            'Impression Of',
            'SKU',
            'Category',
            'Gender',
            '30ml Price (PKR)',
            '50ml Price (PKR)',
            '60ml Price (PKR)',
            '100ml Price (PKR)',
            'Stock',
        ];
    }

    public function array(): array
    {
        return [
            [
                'Oud Royale Extrait',
                'Imperial Agarwood & Rose',
                'PC-OUD-01',
                'Woody & Oriental',
                'Unisex',
                1850,
                2850,
                3450,
                4950,
                45,
            ],
            [
                'Baroque Rouge 540',
                'Baccarat Rouge 540 by MFK',
                'PC-BR-02',
                'Amber & Warm',
                'Unisex',
                1950,
                2950,
                3650,
                5200,
                35,
            ],
            [
                'Santal Desire',
                'Santal 33 by Le Labo',
                'PC-SAN-03',
                'Woody & Smoky',
                'Unisex',
                1750,
                2750,
                3350,
                4800,
                40,
            ],
            [
                'Smoked Birch & Leather',
                'Tuscan Leather by Tom Ford',
                'PC-LTHR-04',
                'Smoky & Leathery',
                'Men',
                1850,
                2850,
                3450,
                4950,
                30,
            ],
            [
                'Taif Velvet Rose',
                'Velvet Rose & Oud by Jo Malone',
                'PC-ROSE-05',
                'Floral & Oriental',
                'Women',
                1650,
                2550,
                3150,
                4500,
                25,
            ],
            [
                'Murree Mist',
                'Silver Mountain Water by Creed',
                'PC-MIST-06',
                'Fresh & Citrus',
                'Unisex',
                1500,
                2400,
                2950,
                4200,
                50,
            ],
            [
                'Executive Gentleman',
                'Tuxedo by YSL',
                'PC-TUX-07',
                'Spicy & Amber',
                'Men',
                1950,
                2950,
                3650,
                5200,
                20,
            ],
            [
                'Gourmand Tonka Vanilla',
                'Tobacco Vanille by Tom Ford',
                'PC-VNL-08',
                'Sweet & Gourmand',
                'Unisex',
                1850,
                2850,
                3450,
                4950,
                30,
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling (Royal Wine & Gold)
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '541B29'], // Luxury royal wine
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '851029'],
                ],
            ],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(28);

        // Center align SKU, Category, Gender, Prices and Stock
        $sheet->getStyle('C2:J9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}

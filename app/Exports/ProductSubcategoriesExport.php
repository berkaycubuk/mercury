<?php

namespace App\Exports;

use Core\Models\Product\Subcategory;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductSubcategoriesExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $arrayData;

    public function __construct(array $arrayData)
    {
        $this->arrayData = $arrayData;
    }

    public function array(): array
    {
        return $this->arrayData;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Başlık',
            'Üst Kategori',
        ];
    }
}

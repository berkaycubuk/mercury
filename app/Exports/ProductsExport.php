<?php

namespace App\Exports;

use Core\Models\Product\Product;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromArray, WithHeadings
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
            'Kısa Açıklama',
            'Açıklama',
            'Kategori',
            'Alt Kategori',
            'Fiyat',
            'KDV',
            'Online Sipariş Edilebilir',
            'Yemek Menüsünde Göster'
        ];
    }
}

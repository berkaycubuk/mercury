<?php

namespace App\Exports;

use Core\Models\Product\ProductCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductCategoriesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return ProductCategory::select(
            'id',
            'name',
            'slug',
        )->where('id', '!=', 0)->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Başlık',
            'Slug',
        ];
    }
}

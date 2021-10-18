<?php

namespace App\Exports;

use Core\Models\Auth\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select(
            'id',
            'first_name',
            'last_name',
            'email',
            'phone',
            'role'
        )->where('id', '!=', 0)->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Ad',
            'Soyad',
            'E-posta',
            'Telefon',
            'Yetki',
        ];
    }
}

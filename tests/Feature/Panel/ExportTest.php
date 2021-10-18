<?php

namespace Tests\Feature\Panel;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Core\Models\Auth\User;
use App\Exports\ProductsExport;
use App\Exports\UsersExport;
use App\Exports\ProductCategoriesExport;
use App\Exports\ProductSubcategoriesExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportTest extends TestCase
{
    public function test_user_can_download_products_export()
    {
        Excel::fake();

        $user = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->actingAs($user)
            ->get(route('panel.products.products.export'));

        Excel::assertDownloaded('urunler.xlsx', function(ProductsExport $export) {
            return true;
        });
    }

    public function test_user_can_download_product_categories_export()
    {
        Excel::fake();

        $user = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->actingAs($user)
            ->get(route('panel.products.categories.export'));

        Excel::assertDownloaded('urun-kategorileri.xlsx', function(ProductCategoriesExport $export) {
            return true;
        });
    }

    public function test_user_can_download_product_subcategories_export()
    {
        Excel::fake();

        $user = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->actingAs($user)
            ->get(route('panel.products.subcategories.export'));

        Excel::assertDownloaded('urun-altkategorileri.xlsx', function(ProductSubcategoriesExport $export) {
            return true;
        });
    }

    public function test_user_can_download_users_export()
    {
        Excel::fake();

        $user = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->actingAs($user)
            ->get(route('panel.users.export'));

        Excel::assertDownloaded('kullanicilar.xlsx', function(UsersExport $export) {
            return true;
        });
    }
}

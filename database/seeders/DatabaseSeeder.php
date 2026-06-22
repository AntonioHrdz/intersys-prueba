<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $cat1 = Category::create(['name' => 'Electrónica', 'description' => 'Dispositivos y gadgets']);
        $cat2 = Category::create(['name' => 'Línea Blanca', 'description' => 'Electrodomésticos de hogar']);
        $cat3 = Category::create(['name' => 'Accesorios', 'description' => 'Cables y complementos']);

        // 2. Productos
        $p1 = Product::create(['category_id' => $cat1->id, 'name' => 'Laptop Pro 14', 'sku' => 'LAP-001', 'stock' => 15, 'price' => 899.99]);
        $p2 = Product::create(['category_id' => $cat1->id, 'name' => 'Smartphone X', 'sku' => 'PHN-002', 'stock' => 30, 'price' => 499.99]);
        $p3 = Product::create(['category_id' => $cat2->id, 'name' => 'Microondas 20L', 'sku' => 'MIC-003', 'stock' => 8, 'price' => 120.00]);
        $p4 = Product::create(['category_id' => $cat3->id, 'name' => 'Mouse Inalámbrico', 'sku' => 'MOU-004', 'stock' => 100, 'price' => 25.50]);
        $p5 = Product::create(['category_id' => $cat1->id, 'name' => 'Monitor Gamer 27', 'sku' => 'MON-005', 'stock' => 12, 'price' => 299.99]);
        $p6 = Product::create(['category_id' => $cat1->id, 'name' => 'Auriculares Bluetooth', 'sku' => 'AUD-006', 'stock' => 45, 'price' => 79.90]);
        $p7 = Product::create(['category_id' => $cat2->id, 'name' => 'Refrigerador No Frost', 'sku' => 'REF-007', 'stock' => 5, 'price' => 650.00]);
        $p8 = Product::create(['category_id' => $cat2->id, 'name' => 'Licuadora de Alta Potencia', 'sku' => 'LIC-008', 'stock' => 20, 'price' => 45.00]);
        $p9 = Product::create(['category_id' => $cat3->id, 'name' => 'Teclado Mecánico RGB', 'sku' => 'TEC-009', 'stock' => 25, 'price' => 65.00]);
        $p10 = Product::create(['category_id' => $cat3->id, 'name' => 'Cargador Rápido GaN 65W', 'sku' => 'CAR-010', 'stock' => 60, 'price' => 34.99]);

        //ventas
        $now = Carbon::now();
        $products = Product::all();

        for($i = 0; $i < 20; $i++) {
            $product = $products->random();
            $quantity = rand(1, 4);


            Sale::create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'total_price' => $product->price * $quantity,
                'sale_date' => $now->copy()->subDays(rand(0, $now->day - 1))->setTime(rand(9, 18), rand(0, 59)),
            ]);
        }

    }
}

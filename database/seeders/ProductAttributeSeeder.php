<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            ProductAttribute::create([
                'product_id' => 1,
                'size'       => 'SM',
                'price'      => 100,
                'stock'      => 10,
                'sku'        => 'SM-1', 
            ]);
            
            ProductAttribute::create([
                'product_id' => 1,
                'size'       => 'M',
                'price'      => 200,
                'stock'      => 20,
                'sku'        => 'M-1', 
            ]);

            ProductAttribute::create([
                'product_id' => 1,
                'size'       => 'L',
                'price'      => 250,
                'stock'      => 15,
                'sku'        => 'L-l', 
            ]);
       
    }
}

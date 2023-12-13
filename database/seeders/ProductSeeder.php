<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facker = Factory::create();

        foreach (range(1,10) as $item) {
            Product::create([
                'section_id'     => rand(1,3),
                'category_id'    => rand(1,10),
                'name'           => $facker->unique()->name,
                'slug'           => Str::slug($facker->unique()->name),
                'featured_image' => $facker->imageUrl(),
                'price'          => 200,
                'code'           => Str::slug($facker->unique()->name),
                'url'            => Str::slug($facker->unique()->name),
                'status'         => $this->randomStatus()
            ]);
        }
    }

    public function randomStatus(){
        $status = [
            '0' => 0,
            '1' => 1
        ];

        return array_rand($status);
    }
}

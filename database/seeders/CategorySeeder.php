<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
            Category::create([
                'section_id' => rand(1,3),
                'name'       => $facker->unique()->name,
                'slug'       => Str::slug($facker->unique()->name),
                'image'      => '',
                'url'        => Str::slug($facker->unique()->name),
                'status'     => $this->randomStatus()
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

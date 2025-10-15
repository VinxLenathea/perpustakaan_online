<?php

namespace Database\Seeders;

use App\Models\CategoryModel;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'karya_tulis_ilmiah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'poster',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'penelitian_eksternal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'penelitian_internal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'e_book',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        CategoryModel::insert($categories);
    }
}

<?php

namespace Database\Seeders;

use App\Models\DocumentModel;
use App\Models\CategoryModel;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $category = CategoryModel::where('category_name', 'karya_tulis_ilmiah')->first();

        if ($category) {
            $documents = [
                [
                    'title' => 'Penelitian tentang Kesehatan Masyarakat',
                    'author' => 'Dr. Ahmad Santoso',
                    'year_published' => 2023,
                    'category_id' => $category->id,
                    'abstract' => 'Abstrak penelitian ini membahas tentang isu kesehatan masyarakat di Indonesia.',
                    'file_url' => 'documents/sample1.pdf',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Analisis Data Epidemiologi',
                    'author' => 'Prof. Siti Nurhaliza',
                    'year_published' => 2022,
                    'category_id' => $category->id,
                    'abstract' => 'Studi kasus analisis data epidemiologi selama pandemi.',
                    'file_url' => 'documents/sample2.pdf',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            DocumentModel::insert($documents);
        }
    }
}

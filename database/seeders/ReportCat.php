<?php

namespace Database\Seeders;

use App\Models\ReportCategory;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ReportCat extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        ReportCategory::truncate();

        $data = [
            [
                'cat_name' => 'Melanggar Aturan'
            ],
            [
                'cat_name' => 'Salah Kategori'
            ],
            [
                'cat_name' => 'Spam'
            ],
            [
                'cat_name' => 'Lainnya'
            ],
        ];

        ReportCategory::insert($data);
        Schema::enableForeignKeyConstraints();
    }
}

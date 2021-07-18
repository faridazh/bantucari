<?php

namespace Database\Seeders;

use App\Models\Category;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();

        $data = [
            [
                'cat_name' => 'Barang',
                'created_at' => date('Y-m-d h:i:s', time()),
                'updated_at' => date('Y-m-d h:i:s', time()),
            ],
            [
                'cat_name' => 'Kendaraan',
                'created_at' => date('Y-m-d h:i:s', time()),
                'updated_at' => date('Y-m-d h:i:s', time()),
            ],
            [
                'cat_name' => 'Orang',
                'created_at' => date('Y-m-d h:i:s', time()),
                'updated_at' => date('Y-m-d h:i:s', time()),
            ],
        ];

        Category::insert($data);
        Schema::enableForeignKeyConstraints();
    }
}

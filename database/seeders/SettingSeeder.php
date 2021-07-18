<?php

namespace Database\Seeders;

use App\Models\Setting;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        Setting::truncate();

        $created_at = date('Y-m-d h:i:s', time());
        $updated_at = date('Y-m-d h:i:s', time());

        $data = [
            [
                'name' => 'user_avatar_size',
                'value' => 250,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'name' => 'user_avatar_width',
                'value' => 250,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'name' => 'user_avatar_height',
                'value' => 250,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'name' => 'laporan_photo_count',
                'value' => 5,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'name' => 'laporan_photo_size',
                'value' => 1024,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'name' => 'laporan_photo_width',
                'value' => 500,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'name' => 'laporan_photo_height',
                'value' => 500,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            // [
            //     'name' => '',
            //     'value' => '',
            //     'created_at' => $created_at,
            //     'updated_at' => $updated_at,
            // ],
        ];

        Setting::insert($data);
    }
}

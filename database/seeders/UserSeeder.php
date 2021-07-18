<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    public function run()
    {
        Storage::disk('public')->deleteDirectory('uploads');

        Storage::disk('public')->makeDirectory('uploads/avatars');
        Storage::disk('public')->makeDirectory('uploads/posts');

        Schema::disableForeignKeyConstraints();
        User::truncate();

        $data = [
            [
                'username' => 'FarAzh',
                'role' => 'Admin',
                'name' => 'Farid Azhar Kusuma',
                'email' => 'faridazhar777@gmail.com',
                'password' => Hash::make('111222333'),
                'birthdate' => '1998-05-14',
                'phone' => '2514425694',
                'address' => Crypt::encryptString('Ds. Sumberarum Gg. Timur VII No. 301, Sleman'),
                'states' => 'Jawa Tengah',
                'zipcode' => '55563',
                'email_verified_at' => date('Y-m-d h:i:s', time()),
                'remember_token' => Str::random(60),
                'created_at' => date('Y-m-d h:i:s', time()),
                'updated_at' => date('Y-m-d h:i:s', time()),
            ],
            [
                'username' => 'Fauzia',
                'role' => 'Moderator',
                'name' => 'Fauzia Azizah Kusuma',
                'email' => 'fauzia@gmail.com',
                'password' => Hash::make('111222333'),
                'birthdate' => '2000-12-23',
                'phone' => '2514425694',
                'address' => Crypt::encryptString('Ds. Sumberarum Gg. Timur VII No. 301, Sleman'),
                'states' => 'Jawa Tengah',
                'zipcode' => '55563',
                'email_verified_at' => date('Y-m-d h:i:s', time()),
                'remember_token' => Str::random(60),
                'created_at' => date('Y-m-d h:i:s', time()),
                'updated_at' => date('Y-m-d h:i:s', time()),
            ],
            [
                'username' => 'Rizaaa',
                'role' => 'Staff',
                'name' => 'Fairiza Azmi Kusuma',
                'email' => 'riza@gmail.com',
                'password' => Hash::make('111222333'),
                'birthdate' => '2005-01-16',
                'phone' => '2514425694',
                'address' => Crypt::encryptString('Ds. Sumberarum Gg. Timur VII No. 301, Sleman'),
                'states' => 'Jawa Tengah',
                'zipcode' => '55563',
                'email_verified_at' => date('Y-m-d h:i:s', time()),
                'remember_token' => Str::random(60),
                'created_at' => date('Y-m-d h:i:s', time()),
                'updated_at' => date('Y-m-d h:i:s', time()),
            ],
            [
                'username' => 'Rizky',
                'role' => 'Member',
                'name' => 'Fairizky Azrul Kusuma',
                'email' => 'rizky@gmail.com',
                'password' => Hash::make('111222333'),
                'birthdate' => '2007-11-15',
                'phone' => '2514425694',
                'address' => Crypt::encryptString('Ds. Sumberarum Gg. Timur VII No. 301, Sleman'),
                'states' => 'Jawa Tengah',
                'zipcode' => '55563',
                'email_verified_at' => date('Y-m-d h:i:s', time()),
                'remember_token' => Str::random(60),
                'created_at' => date('Y-m-d h:i:s', time()),
                'updated_at' => date('Y-m-d h:i:s', time()),
            ],
            [
                'username' => 'Mufidianto',
                'role' => 'Banned',
                'name' => 'Rifqy Mufidianto',
                'email' => 'mufidz@gmail.com',
                'password' => Hash::make('111222333'),
                'birthdate' => '2007-11-15',
                'phone' => '2514425694',
                'address' => Crypt::encryptString('Ds. Sumberarum Gg. Timur VII No. 301, Sleman'),
                'states' => 'Jawa Tengah',
                'zipcode' => '55563',
                'email_verified_at' => date('Y-m-d h:i:s', time()),
                'remember_token' => Str::random(60),
                'created_at' => date('Y-m-d h:i:s', time()),
                'updated_at' => date('Y-m-d h:i:s', time()),
            ],
        ];

        /** Example
         * 'username' => 'USERNAME',                                    // alpha_numeric()
         * 'role' => 'ROLE',                                            // Administrator, Moderator, Staff, Member, Banned
         * 'name' => 'NAMA_LENGKAP',                                    // string()
         * 'email' => 'EMAIL',                                          // Mengandung '@' dan '.com', '.net', 'org' & dll
         * 'password' => Hash::make('PASSWORD'),                        // Minimal 8 karakter/char
         * 'birthdate' => 'ULTAH',                                      // YYYY-MM-DD
         * 'phone' => 'NMRHP',
         * 'address' => Crypt::encryptString('ALAMAT'),
         * 'states' => 'PROVINSI',
         * 'zipcode' => 'KODEPOS',
         * 'email_verified_at' => date('Y-m-d h:i:s', time()),          // JANGAN DIUBAH
         * 'remember_token' => Str::random(60),                         // DEFAULT - 60
         * 'created_at' => date('Y-m-d h:i:s', time()),                 // JANGAN DIUBAH
         * 'updated_at' => date('Y-m-d h:i:s', time()),                 // JANGAN DIUBAH
         */

        User::insert($data);
        Schema::enableForeignKeyConstraints();
    }
}

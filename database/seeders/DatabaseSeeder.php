<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('districts')->insert([
            ['name' => 'Hải Châu', 'slug' => 'hai-chau'],
            ['name' => 'Thanh Khê', 'slug' => 'thanh-khe'],
            ['name' => 'Sơn Trà', 'slug' => 'son-tra'],
            ['name' => 'Ngũ Hành Sơn', 'slug' => 'ngu-hanh-son'],
            ['name' => 'Liên Chiểu', 'slug' => 'lien-chieu'],
            ['name' => 'Cẩm Lệ', 'slug' => 'cam-le'],
        ]);

        $this->call(CategoriesSeeder::class);
    }
}

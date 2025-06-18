<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class CategoriesSeeder
 * @package Database\Seeders
 */

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Phòng trọ cho thuê', 'slug' => 'phong-tro-cho-thue'],
            ['name' => 'Ở ghép', 'slug' => 'o-ghep'],
            ['name' => 'Nhà nguyên căn', 'slug' => 'nha-nguyen-can'],
            ['name' => 'Chung cư', 'slug' => 'chung-cu']
        ]);
    }
}

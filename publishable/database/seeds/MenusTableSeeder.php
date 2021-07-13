<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;

class MenusTableSeeder extends Seeder
{

    public function run()
    {
        Menu::firstOrCreate([
            'name' => 'admin',
        ]);
    }
}

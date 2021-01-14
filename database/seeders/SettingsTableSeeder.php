<?php

use App\Models\Setting;
use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $configs = [
            [
                'name'    => 'year',
                'value' => date('Y'),
            ]
            ];

        Setting::insert($configs);
    }
}

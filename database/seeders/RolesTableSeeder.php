<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $items = [
            ['id' => 1, 'name' => 'admin', 'guard_name'=>'web'],
            ['id' => 2, 'name' => 'Accounts Role', 'guard_name'=>'web'],
            ['id' => 3, 'name' => 'Allocator Role', 'guard_name'=>'web'],
            ['id' => 4, 'name' => 'Sales Role', 'guard_name'=>'web'],
            ['id' => 5, 'name' => 'Drivers Role', 'guard_name'=>'web'],
            ['id' => 6, 'name' => 'Safety Role', 'guard_name'=>'web'],
        ];

        foreach ($items as $item) {
            $role = Role::find($item['id']);
            if ($role) {
                $role->update($item);
            } else {
                Role::create($item);
            }
        }
    }
}

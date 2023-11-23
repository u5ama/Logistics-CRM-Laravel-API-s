<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->where('email','james@starbuckgroup.com.au')->delete();
        $Super = User::create([
            'name' => 'James Starbuck',
            'email' => 'james@starbuckgroup.com.au',
            'password' => Hash::make('password'),
            'user_type' => 1,
            'user_status' => 'active',
        ]);
        $role = Role::updateOrCreate(['id' => 1],
            [
                'name' =>'admin',
                'guard_name'=>'web'
            ]);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $Super->assignRole([$role->id]);
    }
}

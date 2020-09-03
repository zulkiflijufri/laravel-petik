<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCreate = User::create([
            'name'      => 'Zulkifli',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('ummikalsum')
        ]);

        // assigment permission to role
        $permission = Permission::all();

        $role = Role::find(1);
        $role->syncPermissions($permission);

        // assigment role with permission to user
        $user = User::find(1);
        $user->assignRole($role->name);
    }
}

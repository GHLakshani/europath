<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Hansini',
            'email' => 'ghlakshani@gmail.com',
            'password' => bcrypt('mg@2025')
        ]);

        $role = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        // $user->assignRole([$role->id]);
        $user->assignRole('Super Admin');
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard',

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
        ];
        $dynamicID = [
            '1',

            '152',
            '152',
            '152',
            '152',

            '151',
            '151',
            '151',
            '151',
        ];

        for ($i = 0; $i < count($permissions); $i++) {
            Permission::updateOrInsert(
                ['name' => $permissions[$i]], // Match by 'name'
                [
                    'dynamic_menu_id' => $dynamicID[$i],
                    'guard_name' => 'web',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    // If you have other fields to update, add them here
                ]
            );
        }
    }
}

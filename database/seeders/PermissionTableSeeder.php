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

            'country-list',
            'country-create',
            'country-edit',
            'country-delete',

            'job-list',
            'job-create',
            'job-edit',
            'job-delete',

            'agent-list',
            'agent-create',
            'agent-edit',
            'agent-delete',

            'sub-dealer-list',
            'sub-dealer-create',
            'sub-dealer-edit',
            'sub-dealer-delete',

            'document-type-list',
            'document-type-create',
            'document-type-edit',
            'document-type-delete',

            'candidate-list',
            'candidate-create',
            'candidate-edit',
            'candidate-delete',

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

            '3',
            '3',
            '3',
            '3',

            '4',
            '4',
            '4',
            '4',

            '5',
            '5',
            '5',
            '5',

            '6',
            '6',
            '6',
            '6',

            '7',
            '7',
            '7',
            '7',

            '20',
            '20',
            '20',
            '20',

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

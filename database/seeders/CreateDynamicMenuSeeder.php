<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CreateDynamicMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu = [
            //dashboard
            [
                'id' => 1,
                'icon' => 'fal fa-lg fa-fw fa-chart-pie',
                'title' => 'Dashboard',
                'page_id' => 1,
                'url' => 'hanara-cms/dashboard',
                'parent_id' => 1,
                'is_parent' => 1,
                'show_menu' => 1,
                'parent_order' => 1,
                'child_order' => 1,
                'fOrder' => 1.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            //master data
            [
                'id' => 2,
                'icon' => 'fal fa-lg fa-fw fa-user',
                'title' => 'Master Data',
                'page_id' => 2,
                'url' => '#',
                'parent_id' => 0,
                'is_parent' => 1,
                'show_menu' => 1,
                'parent_order' => 2,
                'child_order' => 0,
                'fOrder' => 2.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'icon' => '',
                'title' => 'Country',
                'page_id' => 3,
                'url' => 'hanara-cms/country',
                'parent_id' => 2,
                'is_parent' => 0,
                'show_menu' => 1,
                'parent_order' => NULL,
                'child_order' => 1,
                'fOrder' => 2.01,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'icon' => '',
                'title' => 'Job',
                'page_id' => 4,
                'url' => 'hanara-cms/job',
                'parent_id' => 2,
                'is_parent' => 0,
                'show_menu' => 1,
                'parent_order' => NULL,
                'child_order' => 2,
                'fOrder' => 2.02,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'icon' => '',
                'title' => 'Agent',
                'page_id' => 5,
                'url' => 'hanara-cms/agent',
                'parent_id' => 2,
                'is_parent' => 0,
                'show_menu' => 1,
                'parent_order' => NULL,
                'child_order' => 3,
                'fOrder' => 2.03,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 6,
                'icon' => '',
                'title' => 'Sub Dealer',
                'page_id' => 6,
                'url' => 'hanara-cms/sub-dealer',
                'parent_id' => 2,
                'is_parent' => 0,
                'show_menu' => 1,
                'parent_order' => NULL,
                'child_order' => 4,
                'fOrder' => 2.04,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 7,
                'icon' => '',
                'title' => 'Document Types',
                'page_id' => 7,
                'url' => 'hanara-cms/document-type',
                'parent_id' => 2,
                'is_parent' => 0,
                'show_menu' => 1,
                'parent_order' => NULL,
                'child_order' => 5,
                'fOrder' => 2.05,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            //candidate
            [
                'id' => 20,
                'icon' => 'fal fa-lg fa-fw fa-plus',
                'title' => 'Candidate',
                'page_id' => 20,
                'url' => 'hanara-cms/candidate',
                'parent_id' => 20,
                'is_parent' => 1,
                'show_menu' => 1,
                'parent_order' => 20,
                'child_order' => 1,
                'fOrder' => 20.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            //admin
            [
                'id' => 150,
                'icon' => 'fal fa-lg fa-fw fa-user',
                'title' => 'Admin',
                'page_id' => 150,
                'url' => '#',
                'parent_id' => 0,
                'is_parent' => 1,
                'show_menu' => 1,
                'parent_order' => 150,
                'child_order' => 0,
                'fOrder' => 150.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 151,
                'icon' => '',
                'title' => 'User',
                'page_id' => 151,
                'url' => 'hanara-cms/users-list',
                'parent_id' => 150,
                'is_parent' => 0,
                'show_menu' => 1,
                'parent_order' => NULL,
                'child_order' => 1,
                'fOrder' => 150.01,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 152,
                'icon' => '',
                'title' => 'Role',
                'page_id' => 152,
                'url' => 'hanara-cms/roles-list',
                'parent_id' => 150,
                'is_parent' => 0,
                'show_menu' => 1,
                'parent_order' => NULL,
                'child_order' => 2,
                'fOrder' => 150.02,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        foreach ($menu as $item) {
            DB::table('dynamic_menus')->updateOrInsert(
                ['id' => $item['id']],
                [
                    'icon' => $item['icon'],
                    'title' => $item['title'],
                    'page_id' => $item['page_id'],
                    'url' => $item['url'],
                    'parent_id' => $item['parent_id'],
                    'is_parent' => $item['is_parent'],
                    'show_menu' => $item['show_menu'],
                    'parent_order' => $item['parent_order'],
                    'child_order' => $item['child_order'],
                    'fOrder' => $item['fOrder'],
                    'updated_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

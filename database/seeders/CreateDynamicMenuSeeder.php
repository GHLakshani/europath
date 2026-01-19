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
                'url' => 'mg-cms/dashboard',
                'parent_id' => 1,
                'is_parent' => 1,
                'show_menu' => 1,
                'parent_order' => 1,
                'child_order' => 1,
                'fOrder' => 1.00,
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
                'url' => 'mg-cms/users-list',
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
                'url' => 'mg-cms/roles-list',
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

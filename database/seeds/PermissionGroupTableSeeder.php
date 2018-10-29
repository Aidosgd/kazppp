<?php

use Illuminate\Database\Seeder;

use App\Models\PermissionGroup;
use Illuminate\Support\Facades\DB;

class PermissionGroupTableSeeder extends Seeder
{
    private $permissionGroup;

    public function __construct(PermissionGroup $permissionGroup)
    {
        $this->permissionGroup = $permissionGroup;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            [
                'id' => 1,
                'owner' => 'admin',
                'name' => 'Пользователи'
            ],

            [
                'id' => 2,
                'owner' => 'admin',
                'name' => 'Примеры работы в StarterKit'
            ]
        ];

        DB::table('permission_groups')->truncate();

        foreach ($groups as $group) {
            DB::table('permission_groups')->insert($group);
        }
    }

}

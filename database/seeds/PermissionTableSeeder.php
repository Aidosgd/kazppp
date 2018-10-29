<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    private $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'id' => 1,
                'owner' => 'admin',
                'group_id' => 1,
                'alias' => 'manage_admins',
                'name' => 'Управление администраторами',
                'desc' => 'Позволяет создавать администраторов и назначать им роли'
            ],

            [
                'id' => 2,
                'owner' => 'admin',
                'group_id' => 2,
                'alias' => 'examples_contact_list',
                'name' => 'Управление контакт листом',
                'desc' => 'Позволяет создавать/редактировать записи контакт листа'
            ]

        ];

        DB::table('permissions')->truncate();

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }
    }
}

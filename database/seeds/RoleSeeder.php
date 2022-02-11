<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [[
            'name' => "admin",


        ], [
            'name' => "supervisor",


        ]];
        if (DB::table('roles')->get()->count() == 0) {
            DB::table('roles')->insert($roles);
        }
    }
}

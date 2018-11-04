<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role   = Role::create(
		[
            'name'  		=> 'Users',   
            'guard_name'  	=> 'web'   
        ],
		[
            'name'  		=> 'writer',   
            'guard_name'  	=> 'web'   
        ]
		);
    }
}

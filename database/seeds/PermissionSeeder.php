<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission   = Permission::create(
		[
            'name'  		=> 'role manage',   
            'guard_name'  	=> 'web'   
        ],
		[
            'name'  		=> 'user manage',   
            'guard_name'  	=> 'web'   
        ]
		);
    }
}

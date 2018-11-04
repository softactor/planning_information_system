<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class configurationType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configuration_type')->insert([
                [
                    'id' => 1,
                    'name' => 'Proposal'
                ],
                [
                    'id' => 2,
                    'name' => 'Project'
                ],
                [
                    'id' => 3,
                    'name' => 'Meeting'
                ],
                [
                    'id' => 4,
                    'name' => 'Donor Country'
                ],
                [
                    'id' => 5,
                    'name' => 'Donor'
                ],
                [
                    'id' => 6,
                    'name' => 'Mode Of Finace'
                ],
                [
                    'id' => 7,
                    'name' => 'Document'
                ],
                [
                    'id' => 8,
                    'name' => 'Screen'
                ],
                [
                    'id' => 9,
                    'name' => 'Gis Object'
                ],
				[
                    'id' => 10,
                    'name' => 'Progress Type'
                ]
        ]);
    }
}

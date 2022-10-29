<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SetupSeeder extends Seeder
{
    protected $toTruncate = ['users', 'document_types'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach($this->toTruncate as $table) {
            \DB::table($table)->truncate();
        }
        //\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

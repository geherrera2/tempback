<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Deparment;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::unprepared(file_get_contents(__DIR__ . '/sql/departments_202011160904.sql'));
        \DB::unprepared(file_get_contents(__DIR__ . '/sql/municipalities_202011160905.sql'));
        \DB::unprepared(file_get_contents(__DIR__ . '/sql/village_202011160931.sql'));
        // \DB::unprepared(file_get_contents(__DIR__ . '/sql/villages_202011160905.sql'));
    }
}

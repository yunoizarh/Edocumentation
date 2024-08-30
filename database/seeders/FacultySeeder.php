<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculties = [
            [
                'faculty_title' => 'Faculty of Natural Science',
                'faculty_code' => 'FNS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'faculty_title' => 'Faculty of Languages and Communication',
                'faculty_code' => 'FLC',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'faculty_title' => 'Faculty of Applied Sciences',
                'faculty_code' => 'FAS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'faculty_title' => 'Faculty of Management and Social Sciences',
                'faculty_code' => 'FMS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'faculty_title' => 'Faculty of Agriculture',
                'faculty_code' => 'FAG',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'faculty_title' => 'Faculty of Eduaction and Arts',
                'faculty_code' => 'FAE',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more faculties as needed
        ];

        DB::table('faculty')->insert($faculties);
    }
}

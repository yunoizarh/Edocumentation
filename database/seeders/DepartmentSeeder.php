<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get faculties from the faculty table
        $faculties = DB::table('faculty')->get();

        foreach ($faculties as $faculty) {
            if ($faculty->faculty_id == 1) {
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 1
                    'dept_title' => 'Biochemistry',
                    'dept_code' => 'BCH',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 1
                    'dept_title' => 'Biology',
                    'dept_code' => 'BIO',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 1
                    'dept_title' => 'Chemistry',
                    'dept_code' => 'CHM',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 1
                    'dept_title' => 'Computer Science',
                    'dept_code' => 'CSC',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 1
                    'dept_title' => 'Geography',
                    'dept_code' => 'GEO',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            } elseif ($faculty->faculty_id == 2) {
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 3
                    'dept_title' => 'English',
                    'dept_code' => 'ENG',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 3
                    'dept_title' => 'Mass Communication',
                    'dept_code' => 'MCM',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            } elseif ($faculty->faculty_id == 3) {
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 3
                    'dept_title' => 'Biotechnology',
                    'dept_code' => 'BTG',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 3
                    'dept_title' => 'Geology',
                    'dept_code' => 'MCM',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            } elseif ($faculty->faculty_id == 4) {
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 3
                    'dept_title' => 'Accounting',
                    'dept_code' => 'ACC',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 3
                    'dept_title' => 'Economics',
                    'dept_code' => 'ECO',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            } elseif ($faculty->faculty_id == 5) {
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 3
                    'dept_title' => 'Agriculture',
                    'dept_code' => 'AGR',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            } elseif ($faculty->faculty_id == 6) {
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 3
                    'dept_title' => 'Science  Education',
                    'dept_code' => 'SED',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $departments[] = [
                    'faculty_id' => $faculty->faculty_id, // faculty_id is 3
                    'dept_title' => 'History and International Studies',
                    'dept_code' => 'HIS',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            // Add more conditions if needed
        }


        // Insert departments into the table
        DB::table('departments')->insert($departments);
    }
}

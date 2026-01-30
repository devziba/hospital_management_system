<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LabTest;

class LabTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tests = [
            [
                'test_code' => 'LAB001',
                'test_name' => 'Complete Blood Count (CBC)',
                'category' => 'Hematology',
                'price' => 500.00,
                'description' => 'Measures checking red blood cells, white blood cells, and platelets.',
                'normal_range' => 'Varies',
                'turnaround_time' => 24,
            ],
            [
                'test_code' => 'LAB002',
                'test_name' => 'Lipid Profile',
                'category' => 'Biochemistry',
                'price' => 800.00,
                'description' => 'Cholesterol, triglycerides, HDL, LDL.',
                'normal_range' => '< 200 mg/dL',
                'turnaround_time' => 24,
            ],
            [
                'test_code' => 'LAB003',
                'test_name' => 'Blood Sugar (Fasting)',
                'category' => 'Biochemistry',
                'price' => 200.00,
                'description' => 'Glucose level after fasting.',
                'normal_range' => '70-100 mg/dL',
                'turnaround_time' => 4,
            ],
        ];

        foreach ($tests as $test) {
            LabTest::create($test);
        }
    }
}

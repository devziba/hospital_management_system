<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            [
                'medicine_code' => 'MED001',
                'name' => 'Paracetamol',
                'generic_name' => 'Acetaminophen',
                'manufacturer' => 'GSK',
                'category' => 'Painkiller',
                'unit' => 'Tablet',
                'price' => 5.00,
                'stock_quantity' => 1000,
                'expiry_date' => now()->addYear(),
            ],
            [
                'medicine_code' => 'MED002',
                'name' => 'Amoxicillin',
                'generic_name' => 'Amoxicillin',
                'manufacturer' => 'Pfizer',
                'category' => 'Antibiotic',
                'unit' => 'Capsule',
                'price' => 12.00,
                'stock_quantity' => 500,
                'expiry_date' => now()->addYear(),
            ],
            [
                'medicine_code' => 'MED003',
                'name' => 'Ibuprofen',
                'generic_name' => 'Ibuprofen',
                'manufacturer' => 'Abbott',
                'category' => 'Painkiller',
                'unit' => 'Tablet',
                'price' => 8.00,
                'stock_quantity' => 800,
                'expiry_date' => now()->addYear(),
            ],
        ];

        foreach ($medicines as $med) {
            Medicine::create($med);
        }
    }
}

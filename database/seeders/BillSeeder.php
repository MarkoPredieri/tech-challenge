<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bill;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bill::truncate();
        
        $bills = [
            [
                'user_id'          => 2,
                'supply_type'      => 'electricity',
                'consumption'      => 312.5,
                'consumption_unit' => 'kWh',
                'total_amount'     => 89.50,
                'period_start'     => '2025-12-01',
                'period_end'       => '2026-02-01',
                'provider_name'    => 'Enel Energia',
                'invoice_number'   => 'INV-2025-001',
                'due_date'         => '2026-02-15',
            ],
            [
                'user_id'          => 3,
                'supply_type'      => 'electricity',
                'consumption'      => 240.5,
                'consumption_unit' => 'kWh',
                'total_amount'     => 102.50,
                'period_start'     => '2026-01-01',
                'period_end'       => '2026-02-01',
                'provider_name'    => 'Octopus Energy',
                'invoice_number'   => 'INV-2025-002',
                'due_date'         => '2026-03-10',
            ],
            [
                'user_id'          => 2,
                'supply_type'      => 'gas',
                'consumption'      => 376,
                'consumption_unit' => 'Smc',
                'total_amount'     => 404.64,
                'period_start'     => '2025-11-01',
                'period_end'       => '2025-12-31',
                'provider_name'    => 'ENI gas e luce',
                'invoice_number'   => 'INV-2025-003',
                'due_date'         => '2026-01-29',
            ],
            [
                'user_id'          => 3,
                'supply_type'      => 'gas',
                'consumption'      => 45.8,
                'consumption_unit' => 'Smc',
                'total_amount'     => 67.20,
                'period_start'     => '2026-01-01',
                'period_end'       => '2026-01-31',
                'provider_name'    => 'Iren',
                'invoice_number'   => 'INV-2026-001',
                'due_date'         => '2026-02-29',
            ],
        ];

        foreach ($bills as $bill) {
            Bill::create($bill);
        }
    }
}

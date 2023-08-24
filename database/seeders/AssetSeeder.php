<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = [
            [
                'name' => 'Hydraulic Excavators',
                'total_unit' => 8,
                'category_id' => 1
            ],
            [
                'name' => 'Rock Drills',
                'total_unit' => 10,
                'category_id' => 1
            ],
            [
                'name' => 'Draglines',
                'total_unit' => 6,
                'category_id' => 1
            ],
            [
                'name' => 'Tunnel Boring Machines',
                'total_unit' => 4,
                'category_id' => 1
            ],
            [
                'name' => 'Backhoes',
                'total_unit' => 8,
                'category_id' => 1
            ],
            [
                'name' => 'Longwall Shearers',
                'total_unit' => 6,
                'category_id' => 1
            ],
            [
                'name' => 'Augers',
                'total_unit' => 6,
                'category_id' => 1
            ],
            [
                'name' => 'Blasthole Drills',
                'total_unit' => 10,
                'category_id' => 1
            ],
            [
                'name' => 'Mining Trucks',
                'total_unit' => 12,
                'category_id' => 2
            ],
            [
                'name' => 'Conveyor Belts',
                'total_unit' => 8,
                'category_id' => 2
            ],
            [
                'name' => 'Haulage Systems',
                'total_unit' => 6,
                'category_id' => 2
            ],
            [
                'name' => 'Rail Transport Systems',
                'total_unit' => 6,
                'category_id' => 2
            ],
            [
                'name' => 'Off-Highway Vehicles',
                'total_unit' => 8,
                'category_id' => 2
            ],
            [
                'name' => 'Crushers',
                'total_unit' => 10,
                'category_id' => 3
            ],
            [
                'name' => 'Grinders',
                'total_unit' => 8,
                'category_id' => 3
            ],
            [
                'name' => 'Separators',
                'total_unit' => 6,
                'category_id' => 3
            ],
            [
                'name' => 'Flotation Machines',
                'total_unit' => 6,
                'category_id' => 3
            ],
            [
                'name' => 'Smelting Furnaces',
                'total_unit' => 6,
                'category_id' => 3
            ],
            [
                'name' => 'Screening Equipment',
                'total_unit' => 8,
                'category_id' => 3
            ],
            [
                'name' => 'Hard Hats',
                'total_unit' => 12,
                'category_id' => 4
            ],
            [
                'name' => 'Respirators',
                'total_unit' => 10,
                'category_id' => 4
            ],
            [
                'name' => 'Safety Goggles',
                'total_unit' => 8,
                'category_id' => 4
            ],
            [
                'name' => 'Protective Clothing',
                'total_unit' => 12,
                'category_id' => 4
            ],
            [
                'name' => 'Gas Detectors',
                'total_unit' => 6,
                'category_id' => 4
            ],
            [
                'name' => 'Total Stations',
                'total_unit' => 8,
                'category_id' => 5
            ],
            [
                'name' => 'Laser Scanners',
                'total_unit' => 6,
                'category_id' => 5
            ],
            [
                'name' => 'GPS Survey Equipment',
                'total_unit' => 10,
                'category_id' => 5
            ],
            [
                'name' => 'Digital Levels',
                'total_unit' => 6,
                'category_id' => 5
            ],
            [
                'name' => 'Mine Mapping Software',
                'total_unit' => 6,
                'category_id' => 5
            ],
            [
                'name' => 'Ventilation Fans',
                'total_unit' => 8,
                'category_id' => 6
            ],
            [
                'name' => 'Air Purification Systems',
                'total_unit' => 6,
                'category_id' => 6
            ],
            [
                'name' => 'Dust Suppression Equipment',
                'total_unit' => 8,
                'category_id' => 6
            ],
            [
                'name' => 'Air Quality Monitoring',
                'total_unit' => 6,
                'category_id' => 6
            ],
            [
                'name' => 'Generators',
                'total_unit' => 10,
                'category_id' => 7
            ],
            [
                'name' => 'Substations',
                'total_unit' => 6,
                'category_id' => 7
            ],
            [
                'name' => 'High Voltage Switchgear',
                'total_unit' => 6,
                'category_id' => 7
            ],
            [
                'name' => 'Power Cables',
                'total_unit' => 10,
                'category_id' => 7
            ],
            [
                'name' => 'Roof Bolters',
                'total_unit' => 8,
                'category_id' => 8
            ],
            [
                'name' => 'Rock Reinforcement Systems',
                'total_unit' => 6,
                'category_id' => 8
            ],
            [
                'name' => 'Ground Monitoring Instruments',
                'total_unit' => 8,
                'category_id' => 8
            ],
            [
                'name' => 'Rockfall Protection Nets',
                'total_unit' => 6,
                'category_id' => 8
            ],
            [
                'name' => 'Welding Equipment',
                'total_unit' => 10,
                'category_id' => 9
            ],
            [
                'name' => 'Hydraulic Tools',
                'total_unit' => 8,
                'category_id' => 9
            ],
            [
                'name' => 'Lubrication Systems',
                'total_unit' => 6,
                'category_id' => 9
            ],
            [
                'name' => 'Diagnostic Instruments',
                'total_unit' => 8,
                'category_id' => 9
            ],
            [
                'name' => 'Water Pumps',
                'total_unit' => 10,
                'category_id' => 10
            ],
            [
                'name' => 'Water Treatment Systems',
                'total_unit' => 8,
                'category_id' => 10
            ],
            [
                'name' => 'Sediment Control Equipment',
                'total_unit' => 6,
                'category_id' => 10
            ],
            [
                'name' => 'Tailings Management Tools',
                'total_unit' => 6,
                'category_id' => 10
            ]
        ];

        $i = 1;
        foreach ($assets as $asset) {
            Asset::factory()->create($asset);

            Unit::factory($asset['total_unit'])->create(['asset_id' => $i]);
            $i++;
        }
    }
}

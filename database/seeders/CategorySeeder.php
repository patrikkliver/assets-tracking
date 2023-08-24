<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Excavation and Drilling Equipment'],
            ['name' => 'Hauling and Transport'],
            ['name' => 'Material Processing Machinery'],
            ['name' => 'Safety and Personal Protection'],
            ['name' => 'Mine Surveying Tools'],
            ['name' => 'Ventilation and Air Quality Control'],
            ['name' => 'Electrical and Power Distribution'],
            ['name' => 'Rock Support and Ground Control'],
            ['name' => 'Maintenance and Repair Tools'],
            ['name' => 'Water Management and Treatment'],
        ];

        foreach ($categories as $category) {
            Category::factory()->create($category);
        }
    }
}

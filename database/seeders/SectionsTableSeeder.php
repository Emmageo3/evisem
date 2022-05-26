<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionRecords = [
            ['id'=>1, 'name'=>'Hommes', 'status'=>1],
            ['id'=>2, 'name'=>'Femmes', 'status'=>1],
            ['id'=>3, 'name'=>'Enfants', 'status'=>1],
            ['id'=>4, 'name'=>'Beauté', 'status'=>1],
            ['id'=>5, 'name'=>'Maison', 'status'=>1],
        ];

        Section::insert($sectionRecords);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderStatusRecords = [
            ['id'=>1, 'name'=>'Nouveau'],
            ['id'=>2, 'name'=>'En cours'],
            ['id'=>3, 'name'=>'En attente'],
            ['id'=>4, 'name'=>'Annulé'],
            ['id'=>5, 'name'=>'Payé'],
            ['id'=>6, 'name'=>'En cours de livraison'],
            ['id'=>7, 'name'=>'livré'],
        ];

        OrderStatus::insert($orderStatusRecords);
    }
}

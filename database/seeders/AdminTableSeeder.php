<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            ['id'=>1,'name'=>'admin','type'=>'admin','mobile'=>'+221771166073','email'=>'admin@gmail.com','password'=>'','image'=>'','status'=>1],
        ];

        foreach ($adminRecords as $key => $record) {
            \App\Admin::create($record);
        }
    }
}

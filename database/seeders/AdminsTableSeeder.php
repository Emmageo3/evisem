<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
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
            [
                'id'=>1, 'name'=>'admin', 'type'=>'admin', 'mobile'=>'+221767687911', 'email'=>'evisem22@gmail.com', 'password'=>'$2y$10$dGyJQJ8kkhxrGwbQDpD2BuYEm4GPkHdcnn9nofJgJ19Nen4neJ1fq', 'image'=>'', 'status'=>1
            ]
            ];

            DB::table('admins')->insert($adminRecords);
    }


}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        DB::table('admins')->insert([
            ['id'=>2,
            'name'=>'subadmin',
            'type'=>'subadmin',
            'mobile'=>'+221776900713',
            'email'=>'subadmin@gmail.com',
            'password'=>'$2y$10$NQKu.3XAxewfpVFkb.zyReHExtMgzXqzR7N31nA6Jy8rcWyM5TV.q',
            'image'=>'',
            'status'=>1],
         ]);
    }
}

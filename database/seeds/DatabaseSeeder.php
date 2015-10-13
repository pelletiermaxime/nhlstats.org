<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Eloquent::unguard();

        // $this->call('UserTableSeeder');
        $this->call('DivisionsTableSeeder');
        $this->call('TeamTableSeeder');
    }
}

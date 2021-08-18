<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class C19_PtkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i = 1; $i <= 50; $i++)
        {
            DB::table('c19_ptk')->insert([
                'di_rs' => $faker->numberBetween(1,100),
                'probable' => $faker->numberBetween(1,100),
                'discarded' => $faker->numberBetween(1,100),
                'isolasi' => $faker->numberBetween(1,100),
                'sembuh' => $faker->numberBetween(1,100),
                'meninggal' => $faker->numberBetween(1,100),
                'tgl' => $faker -> date($format = 'Y-m-d', $max = 'now')
            ]);
        }
    }
}
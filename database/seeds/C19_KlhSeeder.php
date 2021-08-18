<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class C19_KlhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for($i = 1; $i <= 20; $i++)
        {
            DB::table('klh_cvd')->insert([
                'id_kelurahan' => $faker->numberBetween(1,29),
                'kontak_erat' => $faker->numberBetween(1, 100),
                'suspek' => $faker->numberBetween(1, 100),
                'positif' => $faker->numberBetween(1, 100),
                'sembuh' => $faker->numberBetween(1, 100),
                'meninggal' => $faker->numberBetween(1, 100),
                'tgl' => $faker -> date($format = 'Y-m-d', $max = 'now')
            ]);
        }
    }
}
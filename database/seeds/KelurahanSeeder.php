<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i = 1; $i <= 29; $i++)
        {
            DB::table('kelurahan')->insert([
                'id_kecamatan' => $faker->numberBetween(1,6),
                'nama' => $faker->name,
                'kontak_erat' => $faker->numberBetween(100, 500),
                'suspek' => $faker->numberBetween(100, 200),
                'positif' => $faker->numberBetween(100, 200),
                'sembuh' => $faker->numberBetween(100, 200),
                'meninggal' => $faker->numberBetween(100, 200),
                'tgl' => $faker->date($format = 'Y-m-d', $max = 'now')
            ]);
        }
    }
}
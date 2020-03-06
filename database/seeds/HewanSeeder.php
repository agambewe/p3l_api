<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class HewanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i = 1; $i <= 5; $i++):
            DB::table('hewan')
                ->insert([
                    'id_customer' => $i,
                    'id_jenis' => $i,
                    'id_pegawai' => $i,
                    'nama' => $faker->name,
                    'tanggal_lahir' => $faker->date($format = 'Y-m-d', $max = 'now'),
                    'created_by' => "cs dummy",
                    'updated_by' => "cs dummy 2",
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
            ]);
        endfor;
    }
}

<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
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
            DB::table('customer')
                ->insert([
                    // 'id_pegawai' => $i,
                    'nama' => $faker->name,
                    'alamat' => $faker->address,
                    'tanggal_lahir' => $faker->date($format = 'Y-m-d', $max = 'now'),
                    'telepon' => $faker->e164PhoneNumber,
                    'created_by' => "cs dummy",
                    'updated_by' => "cs dummy 2",
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
            ]);
        endfor;
    }
}

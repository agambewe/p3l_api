<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i = 1; $i <= 5; $i++)
        {
            DB::table('supplier')
                ->insert([
                    'nama' => $faker->company,
                    'alamat' => $faker->address,
                    'telepon' => $faker->e164PhoneNumber,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}

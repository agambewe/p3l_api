<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderRestockSeeder extends Seeder
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
            DB::table('order_restock')
                ->insert([
                    'id' => 'PO-2020-03-01-0'.$i,
                    'id_supplier' => $i,
                    'tanggal_restock' => $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now'),
                    'total_bayar' => $faker->randomElement($array = array ("100000", "150000", "200000", "250000", "105000", "205000")),
                    'status_order' => $faker->randomElement($array = array (1, 0)),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
            ]);
        endfor;
    }
}

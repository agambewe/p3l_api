<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DetailOrderRestockSeeder extends Seeder
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
            DB::table('detail_order_restock')
                ->insert([
                    'id_produk' => $i,
                    'id_order_restock' => 'PO-2020-03-01-0'.$i,
                    'jumlah' => $faker->numberBetween(1,12),
                    'subtotal' => $faker->randomElement($array = array ("100000", "150000", "200000", "250000", "105000", "205000")),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}

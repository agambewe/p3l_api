<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DetailTransaksiProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $namas = [3, 4];
        $i=1;
        foreach($namas as $nama){
            DB::table('detail_transaksi_produk')
                ->insert([
                    'id_produk' => $i++,
                    'id_transaksi' => 'PR-200120-0'.$nama,
                    'jumlah' => $faker->numberBetween(1,12),
                    'subtotal' => $faker->randomElement($array = array ("100000", "150000", "200000", "250000", "105000", "205000"))
            ]);
        }
    }
}

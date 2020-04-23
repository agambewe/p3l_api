<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DetailTransaksiLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $namas = [3, 3, 3];
        $i=1;
        $j=1;
        foreach($namas as $nama){
            DB::table('detail_transaksi_layanan')
                ->insert([
                    'id_transaksi' => 'LY-200120-0'.$nama,
                    'id_layanan' => $i++,
                    'id_hewan' => $j,
                    // 'jumlah' => $faker->numberBetween(1,12),
                    'subtotal' => $faker->randomElement($array = array ("100000", "150000", "200000", "250000", "105000", "205000"))
            ]);
        }
    }
}

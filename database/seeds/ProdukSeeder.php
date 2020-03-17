<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $namas = ['Blackwood Lamb', 'Maxima Shampo', 'Pawloshopy Shampo', 'Jerry High Lamb', 'Jerky Stick Carrot'];
        foreach($namas as $nama){
            DB::table('produk')
                ->insert([
                    'nama' => $nama,
                    'satuan' => $faker->randomElement($array = array ('pack', 'botol')),
                    'stok' => $faker->numberBetween(7,20),
                    'minimal' => 5,
                    'harga' => $faker->randomElement($array = array (350000, 400000, 500000)),
                    'foto' => 'default.png',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}

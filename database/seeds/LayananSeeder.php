<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $i = 1;

        $namas = ['Grooming Mandi Kutu', 'Potong Kuku', 'Sunat', 'Potong Bulu', 'Suntik vitamin', 'Pijit Urut', 'Latihan Renang', 'Trackmil', 'Kawin'];
        foreach($namas as $nama){
            DB::table('layanan')
                ->insert([
                    'id_ukuran' => $faker->numberBetween(1,5),
                    'nama' => $nama,
                    'harga' => $faker->randomElement($array = array (350000, 400000, 500000)),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}

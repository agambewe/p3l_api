<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UkuranHewanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $namas = ['S', 'M', 'L', 'XL', 'XXL'];
        foreach($namas as $nama){
            DB::table('ukuran_hewan')
                ->insert([
                    'nama' => $nama,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}

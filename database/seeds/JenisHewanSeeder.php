<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class JenisHewanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $namas = ['anjing', 'kucing', 'binturong', 'musang', 'kura-kura'];
        foreach($namas as $nama){
            DB::table('jenis_hewan')
                ->insert([
                    'nama' => $nama,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}

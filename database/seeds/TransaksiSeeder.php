<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        DB::table('transaksi')
                ->insert([
                    'id_transaksi' => 'LY-200120-01',
                    'status_layanan' => 0,
                    // 'id_hewan'=>1,
                    'cs'=> $faker->userName,
                    'kasir'=> $faker->userName,
                    'total_harga'=>$faker->randomElement($array = array ("100000", "150000", "200000", "250000", "105000", "205000")),
                    'status_bayar'=>1,
                    'status_layanan'=>1,
                    'diskon'=>20000,
                    'tanggal_transaksi'=>date("Y-m-d H:i:s"),
                    'created_by' => 'kouveecs',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
            ]);
        DB::table('transaksi')
            ->insert([
                'id_transaksi' => 'LY-200120-02',
                'status_layanan' => 0,
                // 'id_hewan'=>2, 
                'cs'=> $faker->userName,
                // 'status_bayar'=>0,
                'status_layanan'=>1,
                'diskon'=>10000,
                'tanggal_transaksi'=>date("Y-m-d H:i:s"),
                'created_by' => 'kouveecs',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        DB::table('transaksi')
            ->insert([
                'id_transaksi' => 'PR-200120-01',
                'cs'=> $faker->userName,
                // 'status_bayar'=>0,
                'tanggal_transaksi'=>date("Y-m-d H:i:s"),
                'created_by' => 'kouveecs',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        DB::table('transaksi')
        ->insert([
                'id_transaksi' => 'PR-200120-02',
                'cs'=> $faker->userName,
                'kasir'=> $faker->userName,
                'total_harga'=>$faker->randomElement($array = array ("100000", "150000", "200000", "250000", "105000", "205000")),
                'status_bayar'=>1,
                'tanggal_transaksi'=>date("Y-m-d H:i:s"),
                'created_by' => 'kouveecs',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        DB::table('transaksi')
            ->insert([
                'id_transaksi' => 'LY-200120-03',
                // 'id_hewan'=>5,
                'status_layanan' => 0,
                'cs'=> $faker->userName,
                'tanggal_transaksi'=>date("Y-m-d H:i:s"),
                'created_by' => 'kouveecs',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
                ]);
    }
}

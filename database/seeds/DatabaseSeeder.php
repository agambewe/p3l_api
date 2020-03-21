<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            JenisHewanSeeder::class,
            PegawaiSeeder::class,
            UkuranHewanSeeder::class,
            CustomerSeeder::class,
            ProdukSeeder::class,
            SupplierSeeder::class,
            LayananSeeder::class,
            HewanSeeder::class,
            DetailTransaksiProdukSeeder::class,
            DetailTransaksiLayananSeeder::class,
            OrderRestockSeeder::class,
            DetailOrderRestockSeeder::class,
            TransaksiSeeder::class,
            UsersTableSeeder::class
        ]);
    }
}

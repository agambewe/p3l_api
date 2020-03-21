<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PegawaiSeeder extends Seeder
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
            DB::table('pegawai')
                ->insert([
                    'nama' => $faker->name,
                    'username' => $faker->userName,
                    'alamat' => $faker->address,
                    'tanggal_lahir' => $faker->date($format = 'Y-m-d', $max = 'now'),
                    'telepon' => $faker->e164PhoneNumber,
                    // 'role' => $faker->randomElement($array = array ('CS', 'KASIR')),
                    'role' => $faker->randomElement($array = array ('CS', 'KASIR')),
                    // 'password' => Hash::make($faker->password),
                    'password' => Hash::make('password'),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        DB::table('pegawai')
            ->insert([
                'nama' => "Agam Bagaswanda",
                'username' => "agambewe",
                'alamat' => "Miami Beach, Florida ",
                'tanggal_lahir' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'telepon' => $faker->e164PhoneNumber,
                // 'role' => $faker->randomElement($array = array ('CS', 'KASIR')),
                'role' => "OWNER",
                // 'password' => Hash::make($faker->password),
                'password' => Hash::make('password'),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}

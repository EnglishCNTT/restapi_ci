<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        $numberOfRecords = 10;
        // creare seeder random data user
        for ($i = 0; $i < $numberOfRecords; $i++) {
            $data = [
                'name' => $faker->name,
                'email' => $faker->email,
                'address' => $faker->address,
                // create_at and update_at
                'created_at' => $faker->date('Y-m-d H:i:s'),
                'updated_at' => $faker->date('Y-m-d H:i:s'),
            ];
            // Using Query Builder
            $this->db->table('users')->insert($data);
        };
    }
}

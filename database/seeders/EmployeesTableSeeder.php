<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1, 10) as $index) {
            Employee::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
            ]);
        }
    }
}

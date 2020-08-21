<?php

use App\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $data = [];
        for ($i=0; $i < 20000; $i++) { 
            $data[]=[
                'name' => $faker->firstname,
                'estado' => $faker->randomElement($array = array ('1','0')),
                'email' => $faker->unique()->freeEmail,
                'password' => md5(Str::random(8))
            ];
        }
        $chunks = array_chunk($data,5000);
        foreach ($chunks as $chunk) {
            User::insert($chunk);
        }
        // foreach (range(1,20000) as $index) {
        //     DB::table('users')->insert([
        //         'name' => $faker->firstname,
        //         'estado' => $faker->randomElement($array = array ('1','0')),
        //         'email' => $faker->unique()->freeEmail,
        //         'password' =>md5( Str::random(8) ),
        //     ]);
        // }
    }
}

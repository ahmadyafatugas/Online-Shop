<?php

namespace Database\Seeders;

use App\Models\Addresses;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where("id", 16)->first();
        Addresses::create([
            'user_id' => $user->id,
            'name' => 'shanks',
            'address' => "jl.bunga14",
            'zipcode' => '13440',
            'city' => "JAKARTA",
            'country' => "INDONESIA"
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obj = new Client();
        $obj->name = 'Client';
        $obj->email = 'client@gmail.com';
        $obj->password = Hash::make('Client123');
        $obj->save();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

//Modelos
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('usuario', 'admin')->first();
        if(!$user)
        {
            User::create([
                'nombre' => 'Administrador',
                'usuario' => 'admin',
                'password' => Hash::make('admin24#'),
                'is_admin' => true,
            ]);
        }else{
            echo "El usuario admin ya existe.";
        }
    }
}

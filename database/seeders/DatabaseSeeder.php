<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\User::create([
            'name'=>"Administrador",
            'email'=>"Admnistrador@disso.com",
            'password'=>Hash::make("12345678"),
            'nivel'=>"Administrador",
        ]);
        for($contador=1; $contador<101;$contador++){
            \App\Models\Epoca::create([
                'nome'=>$contador,
            ]);
        }
        // Array com os nomes das fases
        $fases = [
            'Fase de Grupos',
            'Oitavas de Final',
            'Quartas de Final',
            'Semifinais',
            'Final'
        ];

        // Loop para criar instâncias de Epoca para cada fase
        foreach ($fases as $nomeFase) {
            \App\Models\Epoca::create([
                'nome' => $nomeFase,
            ]);
        }

    }
}

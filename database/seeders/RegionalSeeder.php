<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RegionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Obtener el tiempo actual para los campos timestamps
        $now = Carbon::now();

        $regionals = [
            [
                'id' => 101, // El ID se maneja explícitamente en tu controlador
                'name_regional' => 'POPAYAN',
                'ubication_regional' => 'Popayan Cauca',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 102,
                'name_regional' => 'El Bordo',
                'ubication_regional' => 'Cauca',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 103,
                'name_regional' => 'Santander',
                'ubication_regional' => 'Cauca',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 104,
                'name_regional' => 'Ambienta',
                'ubication_regional' => 'Cauca',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 105,
                'name_regional' => 'Popayan La 7',
                'ubication_regional' => 'Cauca',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 106,
                'name_regional' => 'Puerto Tejada',
                'ubication_regional' => 'Cauca',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 201,
                'name_regional' => 'Cali',
                'ubication_regional' => 'Valle del Cauca',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 301,
                'name_regional' => 'Pasto',
                'ubication_regional' => 'Nariño',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 303,
                'name_regional' => 'Tuquerres',
                'ubication_regional' => 'Nariño',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 701,
                'name_regional' => 'Huila',
                'ubication_regional' => 'Huila',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 999,
                'name_regional' => 'Nacional',
                'ubication_regional' => 'Cauca',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Usar el Query Builder para insertar los datos de forma eficiente
        DB::table('regionals')->insert($regionals);

        // Opcional: Reiniciar el auto-incremento (si la tabla usa auto-incremento)
        // Solo es necesario si la tabla usa auto-incremento y no has insertado el ID manualmente.
        // Si la columna 'id' no tiene auto-incremento (como parece ser el caso), omite esto.

        $this->command->info('Regionales creadas exitosamente.');
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CostCenterSeeder extends Seeder
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

        // 🚨 NOTA IMPORTANTE:
        // Asegúrate de que los 'regional_id' (1, 2, 3, etc.) existan en tu tabla 'regionals'.

        $costCenters = [
            // Centros de Costo para la Regional 1
            [
                'id'=>'10101',
                'cost_center_name' => 'Popayan principal',
                'regional_id' => 101,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'10102',
                'cost_center_name' => 'Calle 5ta',
                'regional_id' => 101,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            
            // Centros de Costo para la Regional 2
            [
                'id'=>'10105',
                'cost_center_name' => 'Piendamo',
                'regional_id' => 101,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'10106',
                'cost_center_name' => 'Timbio',
                'regional_id' => 101,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Centros de Costo para la Regional 3
            [
                'id'=>'10107',
                'cost_center_name' => 'El Tambo',
                'regional_id' => 101,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'10111',
                'cost_center_name' => 'Correrias popayan',
                'regional_id' => 101,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'10201',
                'cost_center_name' => 'El Bordo principal',
                'regional_id' => 102,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'10204',
                'cost_center_name' => 'Correrias bordo',
                'regional_id' => 102,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'10301',
                'cost_center_name' => 'Santander principal',
                'regional_id' => 103,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'10305',
                'cost_center_name' => 'Corinto',
                'regional_id' => 103,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'10308',
                'cost_center_name' => 'Suarez',
                'regional_id' => 103,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'10310',
                'cost_center_name' => 'Correrias Santander Jose Luis',
                'regional_id' => 103,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'10401',
                'cost_center_name' => 'Ambienta principal',
                'regional_id' => 104,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'10402',
                'cost_center_name' => 'Correria ambienta',
                'regional_id' => 104,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'10403',
                'cost_center_name' => 'Ambienta calle 7',
                'regional_id' => 104,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'10601',
                'cost_center_name' => 'Puerto Tejada',
                'regional_id' => 106,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'20101',
                'cost_center_name' => 'Cali principal',
                'regional_id' => 201,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'20102',
                'cost_center_name' => 'Desepaz',
                'regional_id' => 201,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'20103',
                'cost_center_name' => 'Palmira',
                'regional_id' => 201,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'20105',
                'cost_center_name' => 'Yumbo',
                'regional_id' => 201,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'20106',
                'cost_center_name' => 'La Cumbre',
                'regional_id' => 201,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'30101',
                'cost_center_name' => 'Pasto principal',
                'regional_id' => 301,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'30102',
                'cost_center_name' => 'La Union',
                'regional_id' => 301,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'30105',
                'cost_center_name' => 'La Sibundoy',
                'regional_id' => 301,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'30114',
                'cost_center_name' => 'Ipiales',
                'regional_id' => 301,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'30119',
                'cost_center_name' => 'Correrias 3 Pasto',
                'regional_id' => 301,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'30301',
                'cost_center_name' => 'Tuquerres principal',
                'regional_id' => 303,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'30303',
                'cost_center_name' => 'Ricaute',
                'regional_id' => 303,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'30309',
                'cost_center_name' => 'Correrias Tuquerres',
                'regional_id' => 303,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'30312',
                'cost_center_name' => 'Llorente',
                'regional_id' => 303,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'70101',
                'cost_center_name' => 'Pitalito',
                'regional_id' => 701,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'70102',
                'cost_center_name' => 'Puerto asis',
                'regional_id' => 701,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'70103',
                'cost_center_name' => 'Mocoa',
                'regional_id' => 701,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'=>'99901',
                'cost_center_name' => 'Nacional',
                'regional_id' => 999,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Usar el Query Builder para insertar los datos de forma eficiente
        DB::table('cost_centers')->insert($costCenters);

        $this->command->info('Centros de Costo creados exitosamente.');
    }
}
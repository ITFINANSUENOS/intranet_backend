<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            // Cargos de Análisis y Contabilidad
            [
                'name_position' => 'Analista contable',
                'description_position' => 'Registro, control y análisis de las operaciones financieras y contables.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Analista de auditoria',
                'description_position' => 'Revisión y verificación de procesos internos para asegurar el cumplimiento normativo.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Analista de credito',
                'description_position' => 'Estudio de mercado, planificación y ejecución de estrategias de marketing.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Analista de nomina',
                'description_position' => 'Soporte de primer nivel a usuarios para la solución de problemas técnicos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Analista operativo',
                'description_position' => 'Análisis y establecimiento de la política de precios de productos y servicios.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Analista talento humano',
                'description_position' => 'Gestión y seguimiento de las campañas publicitarias.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Asesoría Comercial
            [
                'name_position' => 'Asesor comercial externo',
                'description_position' => 'Prospección y venta de productos o servicios fuera de la oficina o punto de venta.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Asesor comercial interno',
                'description_position' => 'Atención al cliente y venta de productos o servicios dentro del punto de venta o por medios digitales.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Asesor comercial interno quincenal',
                'description_position' => 'Atención y ventas con esquema de pago de comisiones quincenal.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Auxiliar y Asistente
            [
                'name_position' => 'Asistente administrativo',
                'description_position' => 'Soporte en tareas administrativas, documentación y gestión de oficina.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Auxiliar de bodega',
                'description_position' => 'Apoyo en el registro de transacciones y conciliaciones contables.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Auxiliar de credito y cartera',
                'description_position' => 'Control de inventarios, recepción y despacho de mercancía en bodega.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Auxiliar de facturacion',
                'description_position' => 'Gestión de cobro y seguimiento a la cartera de clientes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Auxiliar de nomina',
                'description_position' => 'Soporte técnico y mantenimiento básico de equipos y software.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Auxiliar de servicio al cliente',
                'description_position' => 'Procesamiento de solicitudes de crédito y apoyo en la gestión de cartera.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Auxiliar de servicio al cliente y  bodega',
                'description_position' => 'Atención al cliente en entregas y apoyo en el manejo de inventario físico.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Auxiliar gestion documental',
                'description_position' => 'Mantenimiento y limpieza de las instalaciones de la empresa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Jefatura y Dirección
            [
                'name_position' => 'Auxiliar servicios generales',
                'description_position' => 'Supervisión y gestión general de una unidad de negocio o sucursal.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Auxiliar SST',
                'description_position' => 'Planificación y control de las operaciones de almacén e inventarios.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Cajero',
                'description_position' => 'Dirección y coordinación del equipo de ventas para el logro de objetivos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Cajero / administrador',
                'description_position' => 'Gestión y supervisión de las operaciones comerciales en un área geográfica específica.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Cobrador',
                'description_position' => 'Definición de políticas y estrategias para la gestión de cobro y el riesgo de cartera.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Cobrador call center',
                'description_position' => 'Liderazgo de todas las funciones de recursos humanos de la organización.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Conductor',
                'description_position' => 'Máxima autoridad en la estrategia comercial y los objetivos de venta a nivel corporativo.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Coordinación
            [
                'name_position' => 'Coordinador comercial zona norte',
                'description_position' => 'Planificación, organización y supervisión de las tareas de un equipo o área funcional.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Coordinador comercial zona sur',
                'description_position' => 'Supervisión de las actividades comerciales y el equipo de ventas en la zona Norte.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Coordinador de atencion al cliente CAC',
                'description_position' => 'Coordinación de procesos de crédito, cobro y atención al cliente en el Centro de Atención al Cliente (CAC).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Coordinador de compras',
                'description_position' => 'Supervisión de la satisfacción del cliente después de la venta y gestión de garantías.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Coordinador de credito y cartera',
                'description_position' => 'Gestión del equipo y los procesos de servicio al cliente en el Centro de Atención al Cliente (CAC).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Call Center
            [
                'name_position' => 'Coordinador de inventarios',
                'description_position' => 'Supervisión, capacitación y motivación del equipo de agentes del Call Center.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Coordinador de sistemas',
                'description_position' => 'Atención de llamadas, soporte y gestión de consultas o ventas telefónicas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Gerencia
            [
                'name_position' => 'Director de auditoria interna',
                'description_position' => 'Responsable de la gestión del riesgo crediticio y la eficiencia en el proceso de cobro.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Director de talento humano',
                'description_position' => 'Dirección de la cadena de suministro, transporte, almacén y distribución.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Director financiero',
                'description_position' => 'Liderazgo de las operaciones de producción y fabricación de la empresa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Gerente comercial',
                'description_position' => 'Implementación y mantenimiento de los sistemas de gestión de calidad.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Operación y Producción
            [
                'name_position' => 'Gerente de gestion humana',
                'description_position' => 'Mantenimiento preventivo y correctivo de la maquinaria y equipos de la planta.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Gerente de sistema integrado de calidad (SIC)',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Gerente general',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Gestor de cartera',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Jefe de bodega',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Jefe de ventas',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Lider de zona',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Mayordomo',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Pasante sena etapa productiva 2025',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Secretaria',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Supernumerario',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'Tesorero (a)',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
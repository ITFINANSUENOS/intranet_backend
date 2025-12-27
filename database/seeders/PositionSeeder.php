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
                'name_position' => 'ANALISTA CONTABLE',
                'description_position' => 'Registro, control y análisis de las operaciones financieras y contables.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'ANALISTA DE AUDITORIA',
                'description_position' => 'Revisión y verificación de procesos internos para asegurar el cumplimiento normativo.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'ANALISTA DE CREDITO',
                'description_position' => 'Estudio de mercado, planificación y ejecución de estrategias de marketing.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'ANALISTA DE NOMINA',
                'description_position' => 'Soporte de primer nivel a usuarios para la solución de problemas técnicos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'ANALISTA OPERATIVO',
                'description_position' => 'Análisis y establecimiento de la política de precios de productos y servicios.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'ANALISTA TALENTO HUMANO',
                'description_position' => 'Gestión y seguimiento de las campañas publicitarias.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Asesoría Comercial
            [
                'name_position' => 'ASESOR COMERCIAL EXTERNO',
                'description_position' => 'Prospección y venta de productos o servicios fuera de la oficina o punto de venta.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'ASESOR COMERCIAL INTERNO',
                'description_position' => 'Atención al cliente y venta de productos o servicios dentro del punto de venta o por medios digitales.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'ASESOR COMERCIAL INTERNO QUINCENAL',
                'description_position' => 'Atención y ventas con esquema de pago de comisiones quincenal.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Auxiliar y Asistente
            [
                'name_position' => 'ASISTENTE ADMINISTRATIVO',
                'description_position' => 'Soporte en tareas administrativas, documentación y gestión de oficina.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'AUXILIAR DE BODEGA',
                'description_position' => 'Apoyo en el registro de transacciones y conciliaciones contables.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'AUXILIAR DE CREDITO Y CARTERA',
                'description_position' => 'Control de inventarios, recepción y despacho de mercancía en bodega.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'AUXILIAR DE FACTURACION',
                'description_position' => 'Gestión de cobro y seguimiento a la cartera de clientes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'AUXILIAR DE NOMINA',
                'description_position' => 'Soporte técnico y mantenimiento básico de equipos y software.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'AUXILIAR DE SERVICIO AL CLIENTE',
                'description_position' => 'Procesamiento de solicitudes de crédito y apoyo en la gestión de cartera.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'AUXILIAR DE SERVICIO AL CLIENTE Y BODEGA',
                'description_position' => 'Atención al cliente en entregas y apoyo en el manejo de inventario físico.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'AUXILIAR GESTION DOCUMENTAL',
                'description_position' => 'Mantenimiento y limpieza de las instalaciones de la empresa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Jefatura y Dirección
            [
                'name_position' => 'AUXILIAR SERVICIOS GENERALES',
                'description_position' => 'Supervisión y gestión general de una unidad de negocio o sucursal.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'AUXILIAR SST',
                'description_position' => 'Planificación y control de las operaciones de almacén e inventarios.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'CAJERO',
                'description_position' => 'Dirección y coordinación del equipo de ventas para el logro de objetivos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'CAJERO / ADMINISTRADOR',
                'description_position' => 'Gestión y supervisión de las operaciones comerciales en un área geográfica específica.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'COBRADOR',
                'description_position' => 'Definición de políticas y estrategias para la gestión de cobro y el riesgo de cartera.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'COBRADOR CALL CENTER',
                'description_position' => 'Liderazgo de todas las funciones de recursos humanos de la organización.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'CONDUCTOR',
                'description_position' => 'Máxima autoridad en la estrategia comercial y los objetivos de venta a nivel corporativo.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Coordinación
            [
                'name_position' => 'COORDINADOR COMERCIAL ZONA NORTE',
                'description_position' => 'Planificación, organización y supervisión de las tareas de un equipo o área funcional.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'COORDINADOR COMERCIAL ZONA SUR',
                'description_position' => 'Supervisión de las actividades comerciales y el equipo de ventas en la zona Norte.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'COORDINADOR DE ATENCION AL CLIENTE CAC',
                'description_position' => 'Coordinación de procesos de crédito, cobro y atención al cliente en el Centro de Atención al Cliente (CAC).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'COORDINADOR DE COMPRAS',
                'description_position' => 'Supervisión de la satisfacción del cliente después de la venta y gestión de garantías.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'COORDINADOR DE CREDITO Y CARTERA',
                'description_position' => 'Gestión del equipo y los procesos de servicio al cliente en el Centro de Atención al Cliente (CAC).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Call Center
            [
                'name_position' => 'COORDINADOR DE INVENTARIOS',
                'description_position' => 'Supervisión, capacitación y motivación del equipo de agentes del Call Center.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'COORDINADOR DE SISTEMAS',
                'description_position' => 'Atención de llamadas, soporte y gestión de consultas o ventas telefónicas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Gerencia
            [
                'name_position' => 'DIRECTOR DE AUDITORIA INTERNA',
                'description_position' => 'Responsable de la gestión del riesgo crediticio y la eficiencia en el proceso de cobro.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'DIRECTOR DE TALENTO HUMANO',
                'description_position' => 'Dirección de la cadena de suministro, transporte, almacén y distribución.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'DIRECTOR FINANCIERO',
                'description_position' => 'Liderazgo de las operaciones de producción y fabricación de la empresa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'GERENTE COMERCIAL',
                'description_position' => 'Implementación y mantenimiento de los sistemas de gestión de calidad.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cargos de Operación y Producción
            [
                'name_position' => 'GERENTE DE GESTION HUMANA',
                'description_position' => 'Mantenimiento preventivo y correctivo de la maquinaria y equipos de la planta.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'GERENTE DE SISTEMA INTEGRADO DE CALIDAD (SIC)',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'GERENTE GENERAL',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'GESTOR DE CARTERA',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'JEFE DE BODEGA',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'JEFE DE VENTAS',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'LIDER DE ZONA',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'MAYORDOMO',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'PASANTE SENA ETAPA PRODUCTIVA 2025',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'SECRETARIA',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'SUPERNUMERARIO',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_position' => 'TESORERO (A)',
                'description_position' => 'Ejecución de tareas manuales o asistidas para la fabricación de productos en la etapa final.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
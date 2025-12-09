<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Resetear la caché de permisos de Spatie
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. LISTA MAESTRA DE PERMISOS (Coincide con Sidebar.jsx y Roles.jsx)
        $permissions = [
            // --- Acceso General ---
            'view_dashboard',

            // --- Módulo: Configuración (Administración) ---
            'view_users',
            'view_roles',
            'view_companies',
            'view_positions',
            'view_regionals',
            'view_cost_centers',

            // --- Módulo: Publicación ---
            'view_objectives',
            'view_events',
            'view_news',

            // --- Módulo: Operaciones ---
            'view_datacredito',
            'view_inventory',
            'view_documents', // Anteriormente "gestionar documentos"
            
            // --- Soporte (Opcional si quieres restringirlo también) ---
            'view_help_desk',
            'view_api_docs',
        ];

        // Crear permisos en bucle
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 3. CREAR ROLES Y ASIGNAR PERMISOS INICIALES

        // --- ROL: ASESOR ---
        // Acceso básico: Dashboard e Inventario
        $asesorRole = Role::firstOrCreate(['name' => 'ASESOR']);
        $asesorRole->syncPermissions([
            'view_dashboard',
            'view_inventory',
            'view_help_desk'
        ]);

        // --- ROL: ADMINISTRATIVO ---
        // Acceso intermedio: Dashboard, Inventario, Documentos
        $adminiRole = Role::firstOrCreate(['name' => 'ADMINISTRATIVO']);
        $adminiRole->syncPermissions([
            'view_dashboard',
            'view_inventory',
            'view_documents',
            'view_help_desk'
        ]);

        // --- ROL: GESTOR ---
        // Acceso alto: Publicación completa, Operaciones completas
        $gestorRole = Role::firstOrCreate(['name' => 'COBRADOR']);
        $gestorRole->syncPermissions([
            'view_dashboard',
            // Publicación
            'view_objectives',
            'view_events',
            'view_news',
            // Operaciones
            'view_datacredito',
            'view_inventory',
            'view_documents',
            // Soporte
            'view_help_desk'
        ]);

        // --- ROL: ADMINISTRADOR ---
        // Acceso total a todo el sistema
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        $adminRole->syncPermissions(Permission::all());
    }
}
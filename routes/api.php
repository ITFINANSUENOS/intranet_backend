<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CostCenterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RegionalController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\ProcesamientoDatacreditoController;
use Illuminate\Support\Facades\Route;


//Ruta de las API
// Rutas de Acceso (NO Requieren Token)
Route::post('/users/login', [UserController::class, 'login']);
Route::post('/users', [UserController::class, 'store']); // Registro



Route::middleware('auth:api')->group(function () {
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/objectives', [ObjectiveController::class, 'index']);
    Route::get('/events', [EventController::class, 'index']);
    // --- Rutas de Autenticación JWT ---
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/refresh', [UserController::class, 'refresh']);
    Route::get('/me', [UserController::class, 'me']); // Devuelve el usuario actual

    // --- 1. FUNCIONES GENERALES DE GESTIÓN (Administrador) ---
    // Protegido por el ROL de Spatie
    Route::middleware('role:Administrador')->group(function () {
        // El CRUD de Usuarios (excepto 'store', que es público para registro)
        Route::apiResource('users', UserController::class)->except(['store']);
        Route::apiResource('cost-centers', CostCenterController::class);
        Route::post('regionals/{regional}/cost-centers', [CostCenterController::class, 'storeByRegional']);

        Route::apiResource('companies', CompanyController::class);
        Route::apiResource('regionals', RegionalController::class);
        Route::apiResource('positions', PositionController::class);

        
        Route::post('/news', [NewsController::class, 'store']);
        Route::post('/news/{news}', [NewsController::class, 'update']); // Usar POST para update con subida de archivo
        Route::delete('/news/{news}', [NewsController::class, 'destroy']);

        
        Route::post('/objectives', [ObjectiveController::class, 'store']);
        Route::put('/objectives/{objective}', [ObjectiveController::class, 'update']);
        Route::delete('/objectives/{objective}', [ObjectiveController::class, 'destroy']);

        
        Route::post('/events', [EventController::class, 'store']);
        
        Route::put('/events/{event}', [EventController::class, 'update']);
        Route::delete('/events/{event}', [EventController::class, 'destroy']);
        // Agrgegar rutas para asignar y quitar roles a usuarios
        // Rutas para Roles y Permisos
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);
        // Asignar un rol a un usuario
        Route::post('/users/{user}/roles', [UserRoleController::class, 'assignRole']);
        // Quitar un rol a un usuario
        Route::delete('/users/{user}/roles/{role}', [UserRoleController::class, 'removeRole']);
        // --- NUEVAS RUTAS: Procesamiento de archivos DataCredito ---
        Route::post('/procesamiento/generar-urls', [ProcesamientoDatacreditoController::class, 'generarUrls']);
        Route::post('/procesamiento/iniciar', [ProcesamientoDatacreditoController::class, 'iniciarProceso']);
        Route::get('/procesamiento/estado', [ProcesamientoDatacreditoController::class, 'verificarEstado']);
        
    Route::get('/news/{news}', [NewsController::class, 'show']);
     Route::get('/objectives/{objective}', [ObjectiveController::class, 'show']);
     Route::get('/events/{event}', [EventController::class, 'show']);
     
    
    });

    // --- 2. MODULO DE INVENTARIO ---
    Route::middleware('role:Asesor|Administrativo|Gestor|Administrador')->group(function () {
        // Route::get('/events/{event}', [EventController::class, 'show']);
        // Route::get('/objectives/{objective}', [ObjectiveController::class, 'show']);
        // Route::get('/news/{news}', [NewsController::class, 'show']);
    });

    // --- 3. MODULO MESA DE AYUDA ---
    Route::middleware('role:Administrativo|Gestor|Administrador')->group(function () {
        // Route::get('/events/{event}', [EventController::class, 'show']);
        // Route::get('/objectives/{objective}', [ObjectiveController::class, 'show']);
        // Route::get('/news/{news}', [NewsController::class, 'show']);
    });

    // --- 4. MODULO DE CARTERA ---
    Route::middleware('role:Gestor|Administrador')->group(function () {
        // Route::get('/events/{event}', [EventController::class, 'show']);
        // Route::get('/objectives/{objective}', [ObjectiveController::class, 'show']);
        // Route::get('/news/{news}', [NewsController::class, 'show']);
    });
});
<?php

use App\Http\Controllers\AuthController;
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
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\WalletController;

use Illuminate\Support\Facades\Route;


//Ruta de las API
// Rutas de Acceso (NO Requieren Token)
Route::post('/users/login', [AuthController::class, 'login']);
Route::post('/users', [UserController::class, 'store']); // Registro



Route::middleware('auth:api')->group(function () {
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/objectives', [ObjectiveController::class, 'index']);
    Route::get('/events', [EventController::class, 'index']);
    // --- Rutas de Autenticación JWT ---
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']); // Devuelve el usuario actual

    // --- 1. FUNCIONES GENERALES DE GESTIÓN (Administrador) ---
    // Protegido por el ROL de Spatie
    Route::middleware('role:Super_usuario')->group(function () {
        // El CRUD de Usuarios (excepto 'store', que es público para registro)
        Route::get('/sso/inventario', [AuthController::class, 'generateInventorySsoUrl']);
        Route::get('/sso/mesa-de-ayuda', [AuthController::class, 'generateSsoUrl']);
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
       Route::prefix('reportes')->group(function () {
        Route::post('/generar-url', [ReportesController::class, 'generarUrlSubida']);
        Route::post('/iniciar-procesamiento', [ReportesController::class, 'iniciarProcesamiento']);
        Route::get('/activo', [ReportesController::class, 'getActivo']);
    });

    // Rutas de visualización de datos (Wallet)
    Route::prefix('wallet')->group(function () {
        Route::get('/init/{modulo}', [WalletController::class, 'initDashboard']);
        Route::post('/buscar', [WalletController::class, 'buscar']);
    });

    });
    
    });

    // --- 2. MODULO DE INVENTARIO ---
    Route::middleware('role:Asesor|Administrativo|Gestor|Super_usuario')->group(function () {
         Route::get('/sso/inventario', [AuthController::class, 'generateInventorySsoUrl']);
        Route::get('/sso/mesa-de-ayuda', [AuthController::class, 'generateSsoUrl']);
      
    });

    // --- 3. MODULO MESA DE AYUDA ---
    Route::middleware('role:Administrativo|Gestor|Super_usuario')->group(function () {
        
    });

    // --- 4. MODULO DE CARTERA ---
    Route::middleware('role:Gestor|Super_usuario')->group(function () {
       
    });

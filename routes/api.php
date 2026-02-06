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

// Rutas de Acceso (NO Requieren Token)
Route::post('/users/login', [AuthController::class, 'login']);
Route::post('/users', [UserController::class, 'store']);

Route::middleware('auth:api')->group(function () {
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/objectives', [ObjectiveController::class, 'index']);
    Route::get('/events', [EventController::class, 'index']);
    
    // Autenticación JWT
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);

    // --- ZONA PÚBLICA AUTENTICADA (Reportes y Wallet para todos) ---
    Route::prefix('reportes')->group(function () {
        Route::post('/generar-url', [ReportesController::class, 'generarUrlSubida']);
        Route::post('/iniciar-procesamiento', [ReportesController::class, 'iniciarProcesamiento']);
        Route::get('/activo', [ReportesController::class, 'getActivo']);
    });

    Route::prefix('wallet')->group(function () {
        Route::get('/init/{modulo}', [WalletController::class, 'initDashboard']);
        Route::post('/buscar', [WalletController::class, 'buscar']);
    });

    // --- ZONA ADMINISTRADOR (Super Usuario) ---
    Route::middleware('role:Super_usuario')->group(function () {
        Route::get('/sso/inventario', [AuthController::class, 'generateInventorySsoUrl']);    
        Route::get('/sso/mesa-de-ayuda', [AuthController::class, 'generateSsoUrl']);
        Route::apiResource('users', UserController::class)->except(['store']);
        Route::apiResource('cost-centers', CostCenterController::class);
        Route::post('regionals/{regional}/cost-centers', [CostCenterController::class, 'storeByRegional']);

        Route::apiResource('companies', CompanyController::class);
        Route::apiResource('regionals', RegionalController::class);
        Route::apiResource('positions', PositionController::class);

        Route::post('/news', [NewsController::class, 'store']);
        Route::post('/news/{news}', [NewsController::class, 'update']);
        Route::delete('/news/{news}', [NewsController::class, 'destroy']);

        Route::post('/objectives', [ObjectiveController::class, 'store']);
        Route::put('/objectives/{objective}', [ObjectiveController::class, 'update']);        
        Route::delete('/objectives/{objective}', [ObjectiveController::class, 'destroy']);    

        Route::post('/events', [EventController::class, 'store']);
        Route::put('/events/{event}', [EventController::class, 'update']);
        Route::delete('/events/{event}', [EventController::class, 'destroy']);
        
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);
        Route::post('/users/{user}/roles', [UserRoleController::class, 'assignRole']);        
        Route::delete('/users/{user}/roles/{role}', [UserRoleController::class, 'removeRole']);
        
        Route::post('/procesamiento/generar-urls', [ProcesamientoDatacreditoController::class, 'generarUrls']);
        Route::post('/procesamiento/iniciar', [ProcesamientoDatacreditoController::class, 'iniciarProcesamiento']);
        Route::get('/procesamiento/estado', [ProcesamientoDatacreditoController::class, 'verificarEstado']);

        Route::get('/news/{news}', [NewsController::class, 'show']);
        Route::get('/objectives/{objective}', [ObjectiveController::class, 'show']);
        Route::get('/events/{event}', [EventController::class, 'show']);
    });
});

Route::middleware('role:Asesor|Administrativo|Gestor|Super_usuario')->group(function () { 
     Route::get('/sso/inventario', [AuthController::class, 'generateInventorySsoUrl']);   
    Route::get('/sso/mesa-de-ayuda', [AuthController::class, 'generateSsoUrl']);
});
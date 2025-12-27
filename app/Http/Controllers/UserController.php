<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Firebase\JWT\JWT; // <--- NECESARIO PARA generateSsoUrl
use Illuminate\Support\Facades\Auth; // Lo usaremos para el helper auth()
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT as JWTAuthJWT;

class UserController extends Controller
{
    /**
     * Constructor para aplicar el middleware de autenticación.
     * El middleware 'auth:api' (que ahora usa JWT) protegerá
     * todas las rutas de este controlador, EXCEPTO 'login' y 'store'.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'store']]);
        
        // --- Middleware de Permisos de Spatie ---
        // Descomenta y ajusta esto según tus necesidades de producción.
        // Solo 'Administrador' puede listar, crear, ver y borrar usuarios.
        // $this->middleware('role:Administrador', ['except' => ['login']]);
        
        // O, mejor aún, basado en permisos:
        // $this->middleware('permission:gestionar usuarios', ['except' => ['login', 'logout', 'refresh', 'me']]);
    }

    /**
     * Display a listing of the resource.
     * * [MODIFICADO] Implementa la paginación de Laravel.
     */
    public function index(Request $request)
    {
       $perPage = $request->get('per_page', 10);
        
        // Cargamos todas las relaciones de una vez (Eager Loading)
        $users = User::with(['roles', 'position', 'company', 'regional', 'costCenter']) 
            ->included() 
            ->sort();
            
        // --- LÓGICA DE FILTRADO ---
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $users->where(function ($query) use ($searchTerm) {
                $query->where('name_user', 'like', '%' . $searchTerm . '%')
                      ->orWhere('last_name_user', 'like', '%' . $searchTerm . '%')
                      ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }
        
        if ($request->filled('company_id')) {
            $users->where('company_id', $request->get('company_id'));
        }
        
        if ($request->filled('cost_center_id')) {
            $users->where('cost_center_id', $request->get('cost_center_id'));
        }
        
        if ($request->filled('position_id')) {
            $users->where('position_id', $request->get('position_id'));
        }
            
        return response()->json($users->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     * (MODIFICADO para asignar un ROL al crear)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_user'      => 'required|string|max:255',
            'last_name_user' => 'required|string|max:255',
            'birthdate'      => 'nullable|date',
            'email'          => 'required|email|unique:users|max:255',
            'number_document'=> 'required|string|unique:users|max:255',
            'company_id'     => 'required|integer|exists:companies,id',
            'regional_id'    => 'required|integer|exists:regionals,id',
            'position_id'    => 'required|integer|exists:positions,id',
            'cost_center_id' => [
                'nullable', 
                'integer', 
                Rule::exists('cost_centers', 'id')->where(function ($query) use ($request) {
                    // El Centro de Costo (id) debe tener la Regional (regional_id)
                    // que el usuario está enviando en el mismo request.
                    return $query->where('regional_id', $request->regional_id);
                }),
            ],
            'password'       => 'required|min:8|max:255',
            

            // --- ¡AÑADIDO! Validación de Rol (de Spatie) ---
            // 'role_name' es más legible que 'role_id'
            'role_name'      => 'required|string|exists:roles,name', 
        ]);

        $user = User::create([
            'name_user'      => $request->name_user,
            'last_name_user' => $request->last_name_user,
            'birthdate'      => $request->birthdate,
            'email'          => $request->email,
            'number_document'=> $request->number_document,
            'company_id'     => $request->company_id,
            'regional_id'    => $request->regional_id,
            'position_id'    => $request->position_id,
            'cost_center_id' => $request->cost_center_id,
            
            // No usamos Hash::make() porque tu modelo User.php
            // ya tiene el 'cast' de 'password' => 'hashed'
            'password'       => Hash::make($request->password), 
        ]);

        // --- ¡AÑADIDO! Asignar el rol de Spatie al usuario nuevo ---
        $user->assignRole($request->role_name);

        // [MODIFICACIÓN] Retornamos el usuario con sus relaciones cargadas para el frontend
        // para que pueda ser añadido correctamente a la lista paginada.
        return response()->json($user->load(['roles', 'costCenter', 'company']), 201);
    }

    /**
     * Display the specified resource.
     * (Tu código está perfecto, no se toca)
     */
    public function show($id)
    {
        // Añadimos 'with' para cargar los roles y permisos del usuario
        $user = User::with(['roles', 'permissions', 'costCenter', 'company', 'regional', 'position'])->findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     * (MODIFICADO para actualizar el ROL)
     */
public function update(Request $request, User $user)
{
    $request->validate([
        'name_user'      => 'required|string|max:255',
        'last_name_user' => 'required|string|max:255',
        'birthdate'      => 'nullable|date',
        'email'          => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        
        // CORRECCIÓN 1: number_document
        // El error 422 indica que no es reconocido como string. Al quitar la regla 'string'
        // y mantener 'max', Laravel es más flexible, aunque el campo debe ser requerido.
        'number_document'=> ['required', 'max:255', Rule::unique('users')->ignore($user->id)],
        
        'company_id'     => 'required|integer|exists:companies,id',
        'regional_id'    => 'required|integer|exists:regionals,id',
        'position_id'    => 'required|integer|exists:positions,id',
        'password'       => 'nullable|min:8|max:255', 
        'cost_center_id' => [
            'nullable', 
            'integer', 
            Rule::exists('cost_centers', 'id')->where(function ($query) use ($request) {
                return $query->where('regional_id', $request->regional_id);
            }),
        ],
        'role_name'      => 'required|string|exists:roles,name', 
    ]);

    // 1. Prepara los datos a actualizar
    $data = $request->except(['password', 'role_name']);

    // 2. Si se proporciona una contraseña, hasheala e inclúyela
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    // 3. Actualiza el usuario
    $user->update($data);

    // 4. Actualiza el rol (SOLUCIÓN al error de Spatie: RoleDoesNotExist for guard 'api')
    $newRoleName = $request->input('role_name');

    // CORRECCIÓN 2: Buscamos el rol explícitamente en el 'web' guard, 
    // ya que tus roles se crearon sin guard, lo que hace que Spatie use 'web'.
    // Si el rol ya existe en la DB, esta búsqueda es segura.
    try {
        $role = Role::findByName($newRoleName, 'api'); 
        
        // Sincroniza (reemplaza) todos los roles del usuario con el rol encontrado
        if ($role) {
            $user->syncRoles([$role]);
        }
    } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
        // En caso de error, devolvemos un error 422 descriptivo.
        return response()->json(['message' => 'Error al asignar el rol: ' . $e->getMessage()], 422);
    }
    
    // 5. Devuelve el usuario actualizado (con sus roles y costCenter)
    // [MODIFICACIÓN] Cargamos 'costCenter' para la tabla del frontend
    return response()->json($user->load(['roles', 'costCenter', 'company']), 200); 
}
    /**
     * Remove the specified resource from storage.
     * (Tu código está perfecto, no se toca)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }


  
}
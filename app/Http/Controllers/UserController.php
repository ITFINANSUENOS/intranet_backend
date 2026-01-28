<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'store']]);
    }

    /**
     * Listado paginado con filtros.
     * SOLUCIÓN: Cargamos 'regional' y 'costCenter' para que la tabla muestre los nombres.
     */
    public function index(Request $request)
    {
       $perPage = $request->get('per_page', 10);
        
        // Eager Loading de todas las relaciones necesarias
        $users = User::with(['roles', 'position', 'company', 'regional', 'costCenter']) 
            ->included() 
            ->sort();
            
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
        
        if ($request->filled('regional_id')) {
            $users->where('regional_id', $request->get('regional_id'));
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
     * Creación de usuario.
     * SOLUCIÓN: Retornamos el objeto cargado con relaciones para actualizar el estado del frontend.
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
                    return $query->where('regional_id', $request->regional_id);
                }),
            ],
            'password'       => 'required|min:8|max:255',
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
            'password'       => Hash::make($request->password), 
        ]);

        $user->assignRole($request->role_name);

        // Retornamos relaciones completas
        return response()->json($user->load(['roles', 'costCenter', 'company', 'regional', 'position']), 201);
    }

    /**
     * Ver detalles del usuario.
     */
    public function show($id)
    {
        $user = User::with(['roles', 'permissions', 'costCenter', 'company', 'regional', 'position'])->findOrFail($id);
        return response()->json($user);
    }

    /**
     * Actualización de usuario.
     * SOLUCIÓN: Aseguramos que el regional_id se mantenga y se devuelvan todas las relaciones.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name_user'      => 'required|string|max:255',
            'last_name_user' => 'required|string|max:255',
            'birthdate'      => 'nullable|date',
            'email'          => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
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

        $data = $request->except(['password', 'role_name']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $newRoleName = $request->input('role_name');
        try {
            $role = Role::findByName($newRoleName, 'api'); 
            if ($role) {
                $user->syncRoles([$role]);
            }
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            return response()->json(['message' => 'Error al asignar el rol: ' . $e->getMessage()], 422);
        }
        
        // Retornamos el objeto completo para que el frontend tenga el regional_id y cost_center actualizado
        return response()->json($user->load(['roles', 'costCenter', 'company', 'regional', 'position']), 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
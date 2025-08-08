<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolePermissions = [
            'Usuario Registrado' => [
                // Dashboard
                'Dashboard de Trámites: Ver',
                // Perfil de Usuario
                'Perfil de Usuario: Ver',
                'Perfil de Usuario: Actualizar Información',
                'Perfil de Usuario: Actualizar Contraseña',
                'Perfil de Usuario: Desactivar Cuenta',
            ],
            'Usuario Administrativo' => [
                // Dashboard
                'Dashboard Administrativo: Ver',
                'Dashboard de Trámites: Ver',
                // Todos los Trámites
                'Todos los Trámites: Listar',
                'Todos los Trámites: Administrar',
                // Trámites de mi Oficina
                'Trámites de mi Oficina: Listar',
                'Trámites de mi Oficina: Ver Trámite',
                'Trámites de mi Oficina: Generar Número',
                'Trámites de mi Oficina: Ver Encargado',
                'Trámites de mi Oficina: Crear Acción',
                'Trámites de mi Oficina: Crear Número',
                'Trámites de mi Oficina: Administrar',
                // Resoluciones
                'Resoluciones: Listar',
                'Resoluciones: Crear',
                'Resoluciones: Actualizar',
                'Resoluciones: Eliminar',
                // Perfil de Usuario
                'Perfil de Usuario: Ver',
                'Perfil de Usuario: Actualizar Información',
                'Perfil de Usuario: Actualizar Contraseña',
                'Perfil de Usuario: Desactivar Cuenta',
            ],
            'Administrador' => [
                // Dashboard
                'Dashboard Administrativo: Ver',
                'Dashboard de Trámites: Ver',
                // Tipos de Documentos
                'Tipos de Documentos: Listar',
                'Tipos de Documentos: Crear',
                'Tipos de Documentos: Actualizar',
                'Tipos de Documentos: Eliminar',
                // Categorías de Trámites
                'Categorías de Trámites: Listar',
                'Categorías de Trámites: Crear',
                'Categorías de Trámites: Actualizar',
                'Categorías de Trámites: Eliminar',
                // Prioridades de Trámites
                'Prioridades de Trámites: Listar',
                'Prioridades de Trámites: Crear',
                'Prioridades de Trámites: Actualizar',
                'Prioridades de Trámites: Eliminar',
                // Estados de Trámites
                'Estados de Trámites: Listar',
                'Estados de Trámites: Crear',
                'Estados de Trámites: Actualizar',
                'Estados de Trámites: Eliminar',
                // Oficinas
                'Oficinas: Listar',
                'Oficinas: Crear',
                'Oficinas: Actualizar',
                'Oficinas: Eliminar',
                // Todos los Trámites
                'Todos los Trámites: Listar',
                'Todos los Trámites: Administrar',
                // Trámites de mi Oficina
                'Trámites de mi Oficina: Listar',
                'Trámites de mi Oficina: Ver Trámite',
                'Trámites de mi Oficina: Generar Número',
                'Trámites de mi Oficina: Ver Encargado',
                'Trámites de mi Oficina: Crear Acción',
                'Trámites de mi Oficina: Crear Número',
                'Trámites de mi Oficina: Administrar',
                // Tipos de Resolución
                'Tipos de Resolución: Listar',
                'Tipos de Resolución: Crear',
                'Tipos de Resolución: Actualizar',
                'Tipos de Resolución: Eliminar',
                // Estados de Resolución
                'Estados de Resolución: Listar',
                'Estados de Resolución: Crear',
                'Estados de Resolución: Actualizar',
                'Estados de Resolución: Eliminar',
                // Resoluciones
                'Resoluciones: Listar',
                'Resoluciones: Crear',
                'Resoluciones: Actualizar',
                'Resoluciones: Eliminar',
                // Usuarios
                'Usuarios: Listar',
                'Usuarios: Crear',
                'Usuarios: Actualizar',
                'Usuarios: Eliminar',
                // Roles
                'Roles: Listar',
                'Roles: Crear',
                'Roles: Actualizar',
                'Roles: Eliminar',
                // Perfil de Usuario
                'Perfil de Usuario: Ver',
                'Perfil de Usuario: Actualizar Información',
                'Perfil de Usuario: Actualizar Contraseña',
                'Perfil de Usuario: Desactivar Cuenta',
            ],
        ];

        foreach ($rolePermissions as $roleName => $allPermissions) {
            $role = Role::create(['name' => $roleName]);
            foreach ($allPermissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $role->givePermissionTo($permission);
            }
        }
    }
}

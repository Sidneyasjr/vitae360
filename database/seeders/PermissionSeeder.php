<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permissões para empresas
        Permission::create([
            'name' => 'companies.index',
            'guard_name' => 'web',
            'display_name' => 'Listar Empresas',
            'description' => 'Permissão para listar empresas',
            'is_menu' => true,
            'menu_icon' => 'Building2',
            'menu_route' => 'companies.index',
            'menu_order' => 1,
        ]);

        Permission::create([
            'name' => 'companies.create',
            'guard_name' => 'web',
            'display_name' => 'Criar Empresa',
            'description' => 'Permissão para criar empresas',
            'is_menu' => false,
        ]);

        Permission::create([
            'name' => 'companies.edit',
            'guard_name' => 'web',
            'display_name' => 'Editar Empresa',
            'description' => 'Permissão para editar empresas',
            'is_menu' => false,
        ]);

        Permission::create([
            'name' => 'companies.destroy',
            'guard_name' => 'web',
            'display_name' => 'Excluir Empresa',
            'description' => 'Permissão para excluir empresas',
            'is_menu' => false,
        ]);
    }
}

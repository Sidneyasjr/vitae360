<?php

namespace App\Services;

use App\Models\Permission;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class MenuService
{
    /**
     * Obter itens de menu com base nas permissões do usuário atual
     */
    public function getUserMenu(): Collection
    {
        $user = Auth::user();
        
        if (!$user) {
            return collect([]);
        }
        
        // Usar cache para evitar consultas frequentes ao banco de dados
        $cacheKey = "user_menu_{$user->id}";
        
        return Cache::remember($cacheKey, now()->addMinutes(60), function () use ($user) {
            // Obter permissões que são itens de menu
            $menuItems = Permission::where('is_menu', true)
                ->orderBy('menu_order')
                ->get();
            
            // Filtrar apenas as permissões que o usuário possui
            $userMenuItems = $menuItems->filter(function ($permission) use ($user) {
                return $user->hasPermissionTo($permission->name);
            });
            
            // Formatação para o formato de menu da aplicação
            return $userMenuItems->map(function ($permission) {
                return [
                    'title' => $permission->display_name ?: $permission->name,
                    'href' => $permission->menu_route ? route($permission->menu_route) : '#',
                    'icon' => $permission->menu_icon,
                    'parent_id' => $permission->parent_id,
                ];
            });
        });
    }
    
    /**
     * Limpar o cache de menu para um usuário específico
     */
    public function clearMenuCache(int $userId): void
    {
        Cache::forget("user_menu_{$userId}");
    }
    
    /**
     * Limpar o cache de menu para todos os usuários
     */
    public function clearAllMenuCache(): void
    {
        // Isso irá limpar todo o cache, mas é uma maneira simples de limpar todos os caches de menu
        // Em produção, você pode querer ser mais seletivo
        Cache::flush();
    }
}

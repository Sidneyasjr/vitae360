<?php

namespace App\Http\Middleware;

use App\Services\MenuService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        // Obter itens de menu dinâmicos
        $menuItems = [];
        if ($request->user()) {
            $menuService = new MenuService();
            $menuItems = $menuService->getUserMenu();
        }

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $request->user(),
            ],
            'menu' => [
                'items' => $menuItems,
            ],
            'flash' => [
                'message' => session('message'),
                'error' => session('error'),
                'success' => session('success'),
                'warning' => session('warning'),
                'info' => session('info'),
            ],
        ];
    }
}

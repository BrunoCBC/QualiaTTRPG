<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Caminho para a rota "home" da aplicação.
     */
    public const HOME = '/home';

    /**
     * Carrega as rotas para a aplicação.
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }

    /**
     * Define as rotas web.
     */
    protected function mapWebRoutes()
    {
        $this->loadRoutesFrom(base_path('routes/web.php'));
    }

    /**
     * Define as rotas API.
     */
    protected function mapApiRoutes()
    {
        $this->loadRoutesFrom(base_path('routes/api.php'));
    }
}

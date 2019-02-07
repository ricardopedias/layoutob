<?php
namespace LayoutUI;
use Illuminate\Foundation\AliasLoader;
use LayoutUI\Services\AdminService;
use LayoutUI\Services\AuthService;
use LayoutUI\Facades\Admin;
use LayoutUI\Facades\Authentication;
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indica que o ServiceProvider deve ser adiado.
     *
     * @var bool
     */
    //protected $defer = true;
    private function modPath($path)
    {
        $ds = DIRECTORY_SEPARATOR;
        return dirname(__DIR__) . $ds . str_replace('\\', $ds, $path);
    }
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom($this->modPath('routes.php'));
        //$this->loadMigrationsFrom($this->modPath('database/migrations'));
        $this->loadViewsFrom($this->modPath('resources/views'), 'layout-ui');
        $this->loadTranslationsFrom($this->modPath('resources/lang'), 'layout-ui');
        \LayoutUI\Core::loadHelpers();
        \LayoutUI\Core::loadBladeDirectives();
        \LayoutUI\Core::loadCustomValidations();
        if ($this->app->runningInConsole()) {
           $this->commands([

           ]);
       }
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $config_file = env('LAYOUT_CONFIG_FILE', $this->modPath('config/layout-ui.php'));
        $this->mergeConfigFrom($config_file, 'layout-ui');
        // Disponibiliza o serviço como singleton
        $this->app->singleton(AdminService::class, function ($app) {
            return new AdminService;
        });
        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService;
        });
        // Registra os alias para os facades
        $this->app->booting(function() {
            $loader = AliasLoader::getInstance();
            $loader->alias('Admin', Admin::class);
            $loader->alias('Authentication', Authentication::class);
        });
        $after = config('auth.providers.users.model');
        // Configura o autenticador personalizado
        \LayoutUI\Core::registerAuthProvider();
        // Troca a localização dos templates de emails
        \Config::set('mail.markdown.theme', config('layout-ui.mail_theme'));
        \Config::set('mail.markdown.paths', [$this->modPath('resources/views/mails')]);
    }
    public function provides()
    {
        return [
            AdminService::class,
            AuthService::class,
        ];
    }
}
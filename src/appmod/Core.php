<?php
namespace LayoutUI;

use LayoutUI\Validations\Validator;
use LayoutUI\Core\Auth\UserProvider;
use LayoutUI\Core\Auth\LoginGuard;

class Core
{
    /** @var array */
    protected static $debug = [];

    /** @var boolean */
    protected static $registered = false;

    /** @var string */
    protected static $version = null;


    public static function modPath($path)
    {
        $ds = DIRECTORY_SEPARATOR;
        return dirname(__DIR__) . $ds . str_replace('\\', $ds, $path);
    }

    /**
     * Devolve a versão do layout ui
     *
     * @return void
     */
    public static function version()
    {
        if (self::$version !== null) {
            return self::$version;
        }

        $ds = DIRECTORY_SEPARATOR;
        $file = dirname(dirname(__DIR__)) . $ds . 'version';
        self::$version = file_get_contents($file);
        return self::$version;
    }

    /**
     * Configura o driver de autenticação do LayouUI
     *
     * @return void
     */
    public static function registerAuthProvider()
    {
        // Model
        // Caso se queira apenas trocar o model usado para popular os dados autenticados
        // Força o uso do modelo de usuários personalizado pelo autenticador
        // \Config::set('auth.providers.users.model', \LayoutUI\Models\User::class);

        // ---

        // UserProvider
        // Registra o provedor de usuários
        // Caso não se queira implementar um SessionGuard inteiro
        // \Auth::provider('layoutui-user', function ($app, array $config) {
        //     $provider = \LayoutUI\Models\User::class;
        //     // $provider = $config['provider'];
        //     return new UserProvider($app['hash'], $provider);
        // });
        // // Força o uso do driver personalizado layoutui
        // \Config::set('auth.providers.users.driver', 'layoutui-user');

        // ---

        // SessionGuard
        // Registra o autenticador personalizado
        \Auth::extend('layoutui-guard', function ($app, $name, array $config) {

            $user_model = config('auth.providers.users.model');
            $user_provider = new UserProvider($app['hash'], $user_model);
            $guard = new LoginGuard($name, $user_provider, $app['session.store']);

            // When using the remember me functionality of the authentication services we
            // will need to be set the encryption instance of the guard, which allows
            // secure, encrypted cookie values to get generated for those cookies.
            if (method_exists($guard, 'setCookieJar')) {
                $guard->setCookieJar($app['cookie']);
            }

            if (method_exists($guard, 'setDispatcher')) {
                $guard->setDispatcher($app['events']);
            }

            if (method_exists($guard, 'setRequest')) {
                $guard->setRequest($app->refresh('request', $guard, 'setRequest'));
            }

            return $guard;

        });

        // Força o uso do SessionGuard personalizado layoutui
        \Config::set('auth.guards.web.driver', 'layoutui-guard');
    }


    /**
     * Carrega os helpers
     *
     * @return void
     */
    public static function loadHelpers()
    {
        include( self::modPath('helpers.php'));
    }

    /**
     * Carrega e registra as diretivas para o blade
     *
     * @return void
     */
    public static function loadBladeDirectives()
    {
        include( self::modPath('directives.php'));
    }

    /**
     * Carrega e registra as validações personalizadas.
     *
     * @return void
     */
    public static function loadCustomValidations()
    {
        app('validator')->resolver(function ($translator, $data, $rules, $messages, $customAttributes) {
            return new Validator($translator, $data, $rules, $messages, $customAttributes);
        });
    }

    public static function getDebug($param = null)
    {
        if ($param == null) {
            $value = self::$debug;
            self::$debug = [];
        } else {
            $value = self::$debug[$param] ?? null;
            self::$debug[$param] = null;
        }

        return $value;
    }

    public static function setDebug($param, $value)
    {
        self::$debug[$param] = $value;
    }

    public static function resetCore()
    {
        self::$debug = [];
        self::$registered = false;
    }
}

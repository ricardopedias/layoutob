<?php
namespace LayoutUI\Http\Controllers\Auth;

use Illuminate\Http\Request;
use LayoutUI\Http\Controllers\Controller as UIController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends UIController
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = null;

    public $maxAttempts = 3; // change to the max attemp you want.

    public $decayMinutes = 1; // change to the minutes you want.

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Após login, redirecionar para admin
        $base_route = config('layout-ui.base_route');
        $this->redirectTo = route($base_route);

        // Controla o máximo de erros de login antes de bloquear o ip por algum tempo
        $this->maxAttempts = config('layout-ui.login_max_attempts');
        $this->decayMinutes = config('layout-ui.login_decay_minutes');

        $this->middleware('guest')->except('logout');
    }

    /**
     * Exibe o formulário de login.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $settings = config('layout-ui.login_provider');
        (new $settings)->register();

        return view('layout-ui::auth.login');
    }

    /**
     * Valida os dados enviados pelo usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $settings = config('layout-ui.login_provider');
        (new $settings)->register();

        // Valida o email e a senha
        $validations = [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'context'  => (\Authentication::getLogin()->hasContextField() == true ? 'required' : 'nullable')
        ];

        // @see Illuminate\Foundation\Validation\ValidatesRequests;
        $this->validate($request, $validations);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        // Acrescenta o campo context para as credenciais
        return $request->only($this->username(), 'password', 'context');
    }

    /**
     * O usuário está devidamente autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Rotina para executar após o usuário estar devidamente autenticado
    }
}

<?php
namespace LayoutUI\Http\Controllers\Auth;

use LayoutUI\Http\Controllers\Controller as UIController;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends UIController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = null;

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

        $this->middleware('guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        $settings = config('layout-ui.login_provider');
        (new $settings)->register();

        $rules = $this->rules();
        $min = 6; // por padrão é 6 caracteres
        if (isset($rules['password'])) {
            $validations = explode('|', $rules['password']);
            foreach ($validations as $index => $rule) {
                if (preg_match('#min#', $rule)) {
                    $min = explode(':', $rule)[1];
                    break;
                }
            }
        }

        return view('layout-ui::auth.password-reset')->with(
            ['token' => $token, 'email' => $request->email, 'password_min' => $min]
        );
    }
}

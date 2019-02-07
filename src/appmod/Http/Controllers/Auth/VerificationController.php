<?php
namespace LayoutUI\Http\Controllers\Auth;

use Illuminate\Http\Request;
use LayoutUI\Http\Controllers\Controller as UIController;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends UIController
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be resent if the user did not receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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

        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $settings = config('layout-ui.login_provider');
        (new $settings)->register();
        
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : view('layout-ui::auth.verify');
    }
}

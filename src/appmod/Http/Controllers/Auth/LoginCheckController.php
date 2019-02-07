<?php
namespace LayoutUI\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class LoginCheckController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __invoke()
    {
        $logged = \Auth::check() == true ? 'yes' : 'no';
        return response()->json([ 'logged' => $logged ]);
    }
}

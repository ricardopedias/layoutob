<?php
namespace LayoutUI\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin(Request $request)
    {
        $settings = config('layout-ui.admin_provider');
        (new $settings)->register();

        return view('layout-ui::admin.body-admin');
    }
}

<?php
namespace LayoutUI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request)
    {
        \Admin::setHomePageRoute('admin.samples.grid');

        //$theme = app()->make(\LayoutUI\Services\AdminService::class)->getTheme();
        //\View::share('theme', $theme);
        \View::share('theme', \Admin::getTheme());
    }
}

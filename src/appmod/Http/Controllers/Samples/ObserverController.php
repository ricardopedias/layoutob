<?php
namespace LayoutUI\Http\Controllers\Samples;

use Illuminate\Http\Request;
use LayoutUI\Http\Controllers\Controller;

class ObserverController extends Controller
{
    public function front(Request $request)
    {
        return view('layout-ui::samples.observer-front');
    }

    public function back(Request $request)
    {
        return view('layout-ui::samples.observer-back');
    }
}

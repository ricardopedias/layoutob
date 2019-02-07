<?php
namespace LayoutUI\Http\Controllers\Samples;

use Illuminate\Http\Request;
use LayoutUI\Http\Controllers\Controller;

class InfoController extends Controller
{
    public function front(Request $request)
    {
        return view('layout-ui::samples.info');
    }
}

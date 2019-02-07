<?php
namespace LayoutUI\Http\Controllers\Samples;

use Illuminate\Http\Request;
use LayoutUI\Http\Controllers\Controller;
use LayoutUI\Services\Samples\FormService;

class FormController extends Controller
{
    public function formulary(Request $request)
    {
        (new FormService)->make($request->all());
        return view('layout-ui::samples.form');
    }

    public function save(Request $request)
    {
        return (new FormService)->register($request->all());
    }

    public function delete(Request $request)
    {
        return (new FormService)->delete($request->all());
    }
}

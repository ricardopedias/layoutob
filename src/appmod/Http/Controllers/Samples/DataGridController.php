<?php
namespace LayoutUI\Http\Controllers\Samples;

use Illuminate\Http\Request;
use LayoutUI\Http\Controllers\Controller;
use LayoutUI\Services\Samples\DatagridService;

class DataGridController extends Controller
{
    public function datagrid(Request $request)
    {
        (new DatagridService)->make($request->all());
        return view('layout-ui::samples.grid');
    }

    public function dataprovider(Request $request)
    {
        return (new DatagridService)->extract($request->all());
    }
}

<?php

// Rotas de exemplo

Route::middleware(['web', 'auth'])->namespace('LayoutUI\Http\Controllers')->group(function () {

    Route::get('ui/sample/info', 'Samples\InfoController@front')->name('admin.samples.info');

    Route::get('ui/sample/grid', 'Samples\DataGridController@datagrid')->name('admin.samples.grid');
    Route::get('ui/sample/grid-back', 'Samples\DataGridController@dataprovider')->name('admin.samples.grid-back');

    Route::get('ui/sample/form', 'Samples\FormController@formulary')->name('admin.samples.form');
    Route::post('ui/sample/form-back', 'Samples\FormController@save')->name('admin.samples.form-back');
    Route::delete('ui/sample/delete', 'Samples\FormController@delete')->name('admin.samples.delete');

    Route::get('ui/sample/observer-front', 'Samples\ObserverController@front')->name('admin.samples.observer-front');
    Route::any('ui/sample/observer-back', 'Samples\ObserverController@back')->name('admin.samples.observer-back');

});

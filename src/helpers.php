<?php

if (function_exists('field_name') == false) {

    function field_name($name)
    {
        return \Admin::getForm()->getMaskedFieldName($name);
    }
}

if (function_exists('field_label') == false) {

    function field_label($name)
    {
        return \Admin::getForm()->getFieldLabel($name);
    }
}

if (function_exists('field_value') == false) {

    function field_value($name)
    {
        return \Admin::getForm()->getFieldValue($name);
    }
}

if (function_exists('asset_js') == false) {

    function asset_js($filename)
    {
        $base = config('layout-ui.asset_url');
        return asset("$base/js/$filename") . '?v=' . \LayoutUI\Core::version();
    }
}

if (function_exists('asset_css') == false) {

    function asset_css($filename)
    {
        $base = config('layout-ui.asset_url');
        return asset("$base/css/$filename") . '?v=' . \LayoutUI\Core::version();
    }
}

if (function_exists('asset_theme') == false) {

    function asset_theme()
    {
        $theme = Admin::getTheme();

        // Se for um caminho completo, é um tema local
        if (strpos($theme, "/") !== false) {
            return $theme;
        }
        // se for um apenas um nome, é um tema do LayoutUI
        else {
            $theme = Admin::getTheme() . '.css';
            $base = config('layout-ui.asset_url');
            return asset("$base/css/themes/$theme") . '?v=' . \LayoutUI\Core::version();
        }
    }
}

if (function_exists('asset_img') == false) {

    function asset_img($filename)
    {
        $base = config('layout-ui.asset_url');
        return asset("$base/imgs/$filename");
    }
}

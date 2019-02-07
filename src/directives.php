<?php

/**
 * Para Mais informações sobre a criação de diretivas:
 *
 * https://laravel.com/docs/5.5/blade#extending-blade
 * https://scotch.io/tutorials/all-about-writing-custom-blade-directives
 */

 \Blade::directive('asset_js', function ($expression) {
     $open = "?php";
     $close = "?";
     return "<{$open} echo asset_js($expression); {$close}>";
 });

 \Blade::directive('asset_css', function ($expression) {
     $open = "?php";
     $close = "?";
     return "<{$open} echo asset_css($expression); {$close}>";
 });

 \Blade::directive('asset_theme', function () {
     $open = "?php";
     $close = "?";
     return "<{$open} echo asset_theme(); {$close}>";
 });

 \Blade::directive('asset_img', function ($expression) {
     $open = "?php";
     $close = "?";
     return "<{$open} echo asset_img($expression); {$close}>";
 });

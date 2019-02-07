<?php

return [

    'theme'      => 'sunrise',

    'mail_theme' => 'sunrise',

    'asset_url'  => 'ui',

    'admin_url'  => 'admin',

    'base_route' => 'layoutui',

    'login_provider' => 'LayoutUI\Services\Providers\AuthProviderService',

    'admin_provider' => 'LayoutUI\Services\Providers\AdminProviderService',

    'login_max_attempts' => 4,

    'login_decay_minutes' => 1,

    'login_repeated_username' => false,

    'copyright'     => '© Layout UI - Todos os Direitos reservados'
];

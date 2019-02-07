
// --------------------------------------------------------------------------
// admin.js
// Copyright (c) 2018 Ricardo Pereira Dias (https://rpdesignerfly.github.io)
// Implementações para o painel administrativo
// --------------------------------------------------------------------------

require('./app');

// Ferramentas adicionais
require('./helpers');

// Componentes
require('./components/fontawesome/index');
require('./components/bootstrap/index');
require('./components/jquery-confirm/index');
require('./components/jquery-maskedinput/index');
require('./components/jquery-maskmoney/index');
require('./components/chart-js/index');
require('./components/hammerjs/index');
require('./components/window-resizer/index');
require('./components/admin/index');

// Abaixo os testes da API

WindowResizer.addCallback(function(){
    console.log('MAHOE');
});

WindowResizer.addCallback(function(){
    console.log('HI HI');
});

// setTimeout(function(){
//     Admin.mainLoader('show');
// },3000);
//
//
// setTimeout(function(){
//     Admin.mainLoader('hide');
// },6000);

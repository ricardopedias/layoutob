
// --------------------------------------------------------------------------
// app.js
// Copyright (c) 2018 Ricardo Pereira Dias (https://rpdesignerfly.github.io)
// Neste arquivo são efetuadas as chamadas a todas as dependências javascript
// necessárias tanto para o painel como para o site publico
// --------------------------------------------------------------------------

window._ = require('lodash');

// Por conveniência, é registrado o token CSRF como um cabeçalho no Axios, de
// modo que todas as solicitações HTTP sejam efetuadas automaticamente com o token.

// let token = document.head.querySelector('meta[name="csrf-token"]');
// if (token) {
//     window.csrf_token = token.content;
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }

try {

    // Retro-compatibilidade
    require('html5shiv');

    // Bibliotecas globais
    window.$ = window.jQuery = require('jquery');
    window.axios = require('axios');
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

} catch (e) {}

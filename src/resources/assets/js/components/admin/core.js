
/**
 * Objeto Admin
 */
 var Admin = window.Admin = {

     MODE_DEBUG : 'debug',
     MODE_TESTING : 'testing',
     MODE_PRODUCTION : 'production',

     // O delay deve bater com pageloader.scss
     animation_delay: 400,

     timer_interval: null,

     page_loader_status: 'hidded',

     main_loader_status: 'hidded',

     current_page_type: null,

     current_page_url: null,

     /**
      * Inicializa as funcionalidades básicas do painel.
      *
      * @return {void}
      */
     init: function()
     {
         // oculta o carregador do documento
         $('#js-mainloader-panel-backdrop').hide();
         $('#js-pageloader-panel-backdrop').hide();
         $('#js-pageloader').hide();

         this.callHomePage();
     },

     getTimerInterval: function()
     {
         if (this.timer_interval === null) {
             this.timer_interval = new TimerInterval();
         }

         return this.timer_interval;
     },

     addInterval: function(tag, delay, callback)
     {
         this.getTimerInterval().addCallback(tag, delay, callback);
     },

     clearInterval: function(tag)
     {
         this.getTimerInterval().removeTag(tag);
     },

     addPageInterval: function(delay, callback)
     {
         var url = this.current_page_url;
         this.getTimerInterval().addCallback(url, delay, callback);
     },

     clearPageInterval: function()
     {
         var url = this.current_page_url;
         this.getTimerInterval().removeTag(url);
     },

     /**
      * Devolve o modo de execução do painel no momento atual.
      * Valores possíveis são: 'debug', 'testing' ou 'production'
      *
      * @return {string}
      */
     mode: function()
     {
         var env = $('[name="environment"]').attr('content');
         var debug = $('[name="debug"]').attr('content');

         if (env === 'local') {
             return 'debug';
         } else if (env === 'production' && debug === '1') {
             return 'testing';
         } else {
             return 'production'
         }
     },

     /**
      * Dispara uma mensagem de log.
      *
      * @param  {mixed} message Mensagem a ser logada
      * @param  {string} scope 'debug', 'testing' ou 'production'
      * @return {void}
      */
     log: function(message, scope)
     {
         var caller = (undefined !== arguments.callee.caller && arguments.callee.caller !== null)
            ? '' + arguments.callee.caller.name + ': '
            : '';

        if (undefined === scope || this.mode() === scope) {

            if (this.mode() === this.MODE_DEBUG) {
                if (caller !== '') {
                    console.log(caller, message);
                } else {
                    console.log(message);
                }
            }
        }
     },

     redirectToLogin: function()
     {
         $(location).attr({ href: '/login' });
     },


     /**
      * Carrega a página inicial do paienl.
      *
      * @return {boolean}
      */
     callHomePage: function()
     {
         var self = this;
         var url = $('meta[name="homepage"]').attr('content');

         // Inicia com a página ocultada
         $('#js-page-content, #js-toppanel').css({ opacity: 0 });

         self.callPageUrl(url, null, 'main-loader');
     },

     /**
      * Carrega uma url via AJAX.
      *
      * @param  {HtmlElement} elem
      * @return {void}
      */
     callAjaxUrl: function(elem)
     {
         var self = this;
         var url = $(elem).data('url');
         self.callPageUrl(url);
     },

     /**
      * Invoca o conteúdo de uma página front.
      *
      * @param  {string}   url
      * @param  {object}   params
      * @param  {Function} callpage
      * @param  {string}  loader Possiveis valores são page-loader e main-loader. Padrão é page-loader
      * @return {void}
      */
     callPageUrl: function(url, params, loader)
     {
         var self = this;
         var loader = undefined === loader ? 'page-loader' : loader;

         // Se a página for diferente da última invocada:
         if (this.current_page_url !== null) {

             // Remove os eventos criados na requisição anterior
             this.clearInterval(this.current_page_url);
         }

         // Declara a url que será verificada na próxima requisição
         this.current_page_url = url;

         switch(loader) {
             case 'page-loader':
                self.pageLoader('show');
                break;
            case 'main-loader':
               self.mainLoader('show');
               break;
         }

         setTimeout(function(){

             var ajax = new Ajax(url);
             ajax.setParams(params);
             ajax.call(function (status, obj) {

                 $("html, body").animate({ scrollTop: 0 }, 1);

                 if (loader !== 'none') {

                     $('#js-page-content, #js-toppanel').stop().animate({ opacity: 0 }, self.animation_delay);
                     setTimeout(function(){
                         self.callPageUrlManageReponse(status, obj, loader, params);
                     }, self.animation_delay + 50);

                 } else {
                     self.callPageUrlManageReponse(status, obj, loader, params);
                 }
             });

         }, self.animation_delay + 50);
     },

     /**
      * Decide o que fazer com a resposta html da página front adquirida na requisição AJAX
      *
      * @param  {string} status Pode ser 'success' ou 'error'
      * @param  {object} obj { ajax: xhr, response: 'content', httpStatus: 200, httpStatusText: 'Ok', headers: [] }
      * @param  {string} loader Possiveis valores são page-loader e main-loader. Padrão é page-loader
      * @return {void}
      */
     callPageUrlManageReponse: function(status, obj, loader, params)
     {
         var self = this;
         var response = obj.response;

         // -----------------------------------------------------------
         // Sessão do usuaŕio expirada
         if (status === 'error' && obj.http_status === 401) {
             self.redirectToLogin();
             return;
         }

         // -----------------------------------------------------------
         // Exceção do lado do servidor

         if (status === 'error') {

             var title = 'HTTP Status ' + obj.http_status + ' ' + obj.http_status_text;
             var content = '<h5>'
                + obj.response.message + ": <br>"
                + '<small>' + obj.response.exception + ' on ' + obj.response.file + ' in line ' + obj.response.line + '</small>'
                + '</h5>'
                + '<hr>';

             $.each(obj.response.trace, function(k, item){

                 var number = k+1;

                 var file = (undefined !== item.file)
                    ? item.file + ' in line ' + item.line + ' on '
                    : '';

                 var method = (undefined !== item.class)
                    ? item.class + item.type + item.function
                    : item.function;

                 content += '<p>'
                    + number + '. ' + file + method
                    + '</p>';
             });
             response = '<header class="page-header"><div class="mr-auto px-2 pt-2"><h3 class="mb-0">' + title + '</h3></div>'
                      + '<div class="card mx-2 mt-2"><div class="card-body">' + content + '</div></div>';

            self.current_page_type = 'error'
         }

         // -----------------------------------------------------------
         // Desenha a página no painel
         $('#js-page-content').html(response);

         // Inicia o cabeçalho da página
         PageHeader.init();

         // Detecta o tipo da pagina para configurá-la adequadamente
         var page_type = obj.ajax.getResponseHeader('X-PAGE-TYPE');
         if (page_type === 'page-grid') {

             self.current_page_type = page_type;

             var grid = $('.page-grid').get(0);
             if (undefined !== grid) {
                 PageGrid.init(grid);
             } else {
                 self.log('Datagrid não encontrado na página!', this.MODE_DEBUG);
             }

         } else if (page_type === 'page-form') {

             self.current_page_type = page_type;

             var form = $('.page-form').get(0);
             if (undefined !== form) {
                 PageForm.init(form);

                 if (undefined !== params && undefined !== params.operation) {
                     PageForm.showAlert(form, 'success', params.message);
                     Admin.pageLoader('hide'); // formulário sempre inicia o pageloader
                     // setTimeout(function(){
                     //     PageForm.showAlert(form, 'success', params.message);
                     // }, self.animation_delay + 50);
                 }

             } else {
                 self.log('Formulário não encontrado na página!', this.MODE_DEBUG);
             }
         }

         $("html, body").animate({ scrollTop: 0 }, 1); // para a nova pagina aparecer no inicio

         switch(loader) {
             case 'page-loader':
                self.pageLoader('hide');
                break;
            case 'main-loader':
               self.mainLoader('hide');
               $('#js-page-content, #js-toppanel').animate({ opacity: 1 });
               break;
         }
     },

     /**
      * Exibe/oculta o carregador de páginas do painel.
      *
      * @param  {string} action    Pode ser 'show' ou 'hide'
      * @param  {Function} callcontent
      * @return {void}
      */
     pageLoader: function(action)
     {
         var self = this;

         var backdrop = $('#js-pageloader-panel-backdrop');
         var loader = $('#js-pageloader');
         var progress = $('#js-pageloader .pageloader-bar');
         var animation = null;

         if (action === 'show') {

             self.page_loader_status = 'showed';

             $('#js-page-content, #js-toppanel').animate({ opacity: .6 }, self.animation_delay);

             $('body').addClass('pageloader');
             $(backdrop).show().addClass('show-loader');
             $(loader).show().addClass('show-loader');

             self.pageLoaderClear();

             // seta o valor inicial
             var progress_values = [10, 20];
             var progress_percent = progress_values[Math.floor(Math.random()*progress_values.length)];
             $(progress).addClass('w-' + progress_percent);

             animation = setInterval(function(){
                 var increment_values = [10,20];
                 var increment = increment_values[Math.floor(Math.random()*increment_values.length)];
                 if ((progress_percent + increment) < 90 && $(progress).hasClass('w-100') === false) {
                     progress_percent = progress_percent + increment;
                     $(progress).addClass('w-' + progress_percent);
                 } else {
                     clearInterval(animation);
                 }
             }, self.animation_delay/2);

         } else {

             $('body').removeClass('pageloader');

             clearInterval(animation);

             $(progress).addClass('w-100');

             setTimeout(function(){

                 $(backdrop).removeClass('show-loader');
                 $(loader).removeClass('show-loader');

                 setTimeout(function(){
                     $('body').removeClass('pageloader');
                     $(backdrop).hide();
                     $(loader).hide();
                     self.pageLoaderClear();

                     self.page_loader_status = 'hidded';
                     $('#js-page-content, #js-toppanel').animate({ opacity: 1 }, self.animation_delay);

                 }, 500);

             }, 400);
         }
     },

     /**
      * Zera os valores da barra de progresso do page loader.
      *
      * @return {void}
      */
     pageLoaderClear: function()
     {
         // zera os valores existentes
         var progress = $('#js-pageloader .pageloader-bar');
         $.each([10,20,30,40,50,60,70,80,90,100], function(k, percent){
            $(progress).removeClass('w-' + percent);
         });
     },

     /**
      * Exibe/oculta o carregador principal do painel.
      *
      * @param  {string} action    Pode ser 'show' ou 'hide'
      * @param  {Function} calloader
      * @return {void}
      */
     mainLoader: function(action)
     {
         var callback = (undefined === callback) ? function(){} : callback;

         var context = $('#js-mainloader-panel-backdrop');
         if (action === 'show') {
             $('body').addClass('mainloader');
             $(context).show().addClass('show-loader');

         } else {
             $('body').removeClass('mainloader');
             $(context).removeClass('show-loader');
             setTimeout(function(){
                 $(context).hide();
             }, 800);
         }
     },



     deleteConfirm: function(delete_key, delete_value, delete_url, csrf_token, callback)
     {
         var callback = (undefined === callback) ? function(response){ } : callback;
         var delete_action = delete_url + '?' + delete_key + '=' + delete_value;

         var confirm = $.confirm({
             title: 'Confirmação',
             content: 'Deseja realmente excluir este registro e os itens que, por ventura, dependam dele?',
             buttons: {
                 confirm: {
                     text: 'Excluir',
                     btnClass: 'btn-red',
                     keys: ['enter', 'shift'],
                     action: function(){
                         var loader = $.alert({
                             content: function () {
                                 var self = this;
                                 return $.ajax({
                                     url: delete_action,
                                     dataType: 'json',
                                     method: 'post',
                                     data: $.param({ _method : 'delete', _token: csrf_token })
                                 }).done(function (response) {

                                     if (response.status === 'success') {
                                         callback(response, self);
                                         loader.close();
                                     } else {
                                         self.setTitle('Erro ao excluir');
                                         self.setContent('Um erro aconteceu ao tentar excluir este registro.');
                                     }

                                 }).fail(function(){
                                     self.setTitle('Erro ao excluir');
                                     self.setContent('Um erro aconteceu ao tentar excluir este registro.');
                                 });
                             }
                        });
                     }
                 },
                 cancel: {
                     text: 'Cancelar',
                     btnClass: 'btn-gray',
                     keys: ['esc'],
                     action: function(){
                         confirm.close();
                     }
                 }
             }
         });

         console.log(delete_key);
         console.log(delete_value);
         console.log(delete_url);
     }
 };

 $(document).ready(function () {
     Admin.init();
 });

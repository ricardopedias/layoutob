
/**
 * Objeto PageGrid
 */
var PageGrid = window.PageGrid = {

    grid: null,

    init: function(grid)
    {
        // Armazena o grid a ser tratado
        this.grid = grid;

        // Configurações
        this.setupDefaultParams();
        this.setupHeaders();

        // Eventos
        this.eventsGridControl();
        this.eventsColumnsWidths();
        this.eventsShadows();
        this.eventsRegistersPerPage();
        this.eventsPagination();
        this.eventsOrderables();

        // Popula com a página inicial
        this.callDataProvider();
    },

    // CONFIGURAÇÕES

    setupDefaultParams: function()
    {
        $(this.grid).data('page', 1);
        $(this.grid).data('limit', 25);
        $(this.grid).data('search', '');

        $(this.grid).data('stick-check', 50);
        $(this.grid).data('stick-id', 30);
        $(this.grid).data('stick-main', 100);

        $('.page-grid-row-template', this.grid).appendTo($('thead', this.grid));
    },

    setupHeaders: function()
    {
        var height_header = $('.page-grid-id', this.grid).outerHeight();
        $('th', this.grid).css({
            height: height_header + 'px',
            lineHeight: height_header + 'px'
        });
    },

    // EVENTOS

    eventsGridControl: function()
    {
        var self = this;
        var context = $('.page-grid-search', this.grid);

        $('.page-grid-search-submit', context).click(function(){
            self.callSearch();
        });

        $('.page-grid-search-input', context).keyup(function(e){
            if (e.keyCode=== 13) {
                self.callSearch();
            }
        });
    },

    eventsColumnsWidths: function()
    {
        var self = this;
        $(window).resize(function(){
            self.calcSticky();
        });
    },

    eventsShadows: function()
    {
        var self = this;

        self.calcShadows();

        $(window).resize(function(){
            self.calcShadows();
        });

        $('.page-grid-wrapper', this.grid).scroll(function () {
            self.calcShadows();
        });
    },

    eventsRegistersPerPage: function()
    {
        var self = this;
        var default_limit = $(self.grid).data('limit');
        self.eventsRegistersPerPageValue(default_limit);

        $('.page-grid-registers .dropdown-item', self.grid).click(function(){
            var limit = $(this).data('limit');
            self.eventsRegistersPerPageValue(limit);
            self.callDataProvider();
        });
    },

    eventsRegistersPerPageValue: function(limit)
    {
        var context = $('.page-grid-registers', this.grid);
        var text = '<span class="d-none d-md-inline">Exibindo </span>' + limit + ' itens';
        $('.dropdown-toggle', context).html(text);

        $('.dropdown-item', context).removeClass('active');
        $('.dropdown-item', context).each(function(){
            var item_limit = $(this).data('limit');
            if(item_limit === limit) {
                $(this).addClass('active');
            }
        });

        $(this.grid).data('limit', limit);
    },

    eventsPagination: function()
    {
        var self = this;
        var paginator = $('#' + $(self.grid).attr('id') + '-pagination .pagination');

        $('.page-link', paginator).click(function(){
            var page = $(this).data('page');
            if (page !== 0) {
                $(self.grid).data('page', page);
                self.callDataProvider();
            }
        });
    },

    eventsOrderables: function()
    {
        var self = this;

        $('.page-grid-col.page-grid-orderable', self.grid).each(function(){
            if ($(this).hasClass('order-asc') === true) {
                $('.page-grid-col',self. grid).removeClass('order-desc').removeClass('order-asc');
                $(this).addClass('order-asc');
                return false;
            } else if ($(this).hasClass('order-desc') === true) {
                $('.page-grid-col', self.grid).removeClass('order-desc').removeClass('order-asc');
                $(this).addClass('order-desc');
                return false;
            }
        });

        $('.page-grid-col.page-grid-orderable', self.grid).click(function(){
            self.eventsOrderablesSetState(this);
            self.callDataProvider();
        });
    },

    eventsOrderablesSetState: function(column)
    {
        var order_class = 'order-asc';
        if ($(column).hasClass('order-desc') === true) {
            order_class = 'order-asc';
        } else if ($(column).hasClass('order-asc') === true) {
            order_class = 'order-none';
        } else if ($(column).hasClass('order-none') === true) {
            order_class = 'order-desc';
        }
        $('.page-grid-col', this.grid).removeClass('order-desc').removeClass('order-asc');
        $(column).addClass(order_class);
    },

    callSearch: function()
    {
        var context = $('.page-grid-search', this.grid);
        var text = $('.page-grid-search-input', context).val();
        $(this.grid).data('search', text);
        this.callDataProvider();
    },

    calcSticky: function()
    {
        // Admin.log('grid calc columns');

        var width_window = $(window).width();
        var width_check  = this.getCheckWidth();
        var width_id     = this.getIdWidth();
        var width_main   = this.getMainWidth();
        var width_actions = this.getMobileActionsWidth();

        var page_content_padding = 16*2;
        var page_grid_margin = 8*2;

        if (width_window <= 500 ) {

            width_main = width_window - (width_check+width_id+width_actions+page_content_padding+page_grid_margin);

        } else if (width_window < 768 ) {

            width_main = 270;
        }

        $('.page-grid-check', this.grid).css({ width: width_check, left: 0 });

        $('.page-grid-id', this.grid).css({ width: width_id, left: width_check });
        $('thead .page-grid-id', this.grid).css({ width: width_id });

        $('.page-grid-main', this.grid).css({ width: width_main, left: width_check + width_id });
        $('thead .page-grid-main', this.grid).css({ width: width_main });

        var leftGap = width_check + width_id + width_main;
        $(this.grid).css({ paddingLeft: leftGap });

        // Paraliza as colunas fixas
        $('.page-grid-check, .page-grid-id, .page-grid-main', this.grid).css({
            position: 'absolute'
            //zIndex: 1
            //overflow: 'hidden'
        });

        if ($.browser.mozilla === true) {
            // firefox deve corrigir '1px'
            // outros navegadores, apenas '0.5px'
            $('.page-grid-check, .page-grid-id, .page-grid-main, .page-grid-actions', this.grid).css({
                marginTop: '-1px'
            });
        }

        // Ajusta o grid control
        $('.page-grid-control', this.grid).css({
            marginLeft: -leftGap
        });
    },

    getCheckWidth: function()
    {
        return undefined === $('.page-grid-check', this.grid).get(0)
            ? 0
            : $(this.grid).data('stick-check');
    },

    getIdWidth: function()
    {
        var add_width = $('thead .page-grid-id', this.grid).hasClass('page-grid-orderable') ? 15 : 0;
        var width_id  = $(this.grid).data('stick-id');

        return (width_id > 0 && width_id < 30)
            ? 30  + add_width
            : width_id + add_width;
    },

    getMainWidth: function()
    {
        var add_width = $('thead .page-grid-main', this.grid).hasClass('page-grid-orderable') ? 10 : 0;
        return $(this.grid).data('stick-main') + add_width;
    },

    getMobileActionsWidth: function()
    {
        return $('.page-grid-actions-mobile', this.grid).width();
    },

    getActionsWidth: function()
    {
        var count = $('.page-grid-actions div', this.grid).length;
        return (count > 0)
            ? $('.page-grid-actions div:first', this.grid).width() * count
            : 0;
    },

    calcShadows: function()
    {
        var wrapper = $('.page-grid-wrapper', this.grid);
        var wrapper_width = $(wrapper).width();
        var scroll_width = $('.page-grid-scroller', wrapper).get(0).scrollWidth;
        var left = $(wrapper).scrollLeft();

        // Sem espaço para rolar
        if (wrapper_width === 0) {
            $('.page-grid-main, .page-grid-actions', wrapper).removeClass('scroll-shadow');
            return false;
        }

        // Nada rolado
        if (left > 0) {
            $('.page-grid-main', wrapper).addClass('scroll-shadow');
        } else {
            $('.page-grid-main', wrapper).removeClass('scroll-shadow');
        }

        // Rolagem total
        if ((scroll_width-left) > wrapper_width) {
            $('.page-grid-actions', wrapper).addClass('scroll-shadow');
        } else {
            $('.page-grid-actions', wrapper).removeClass('scroll-shadow');
        }
    },

    callDataProvider: function()
    {
        var self = this;
        var data_provider  = $(self.grid).data('provider');
        var current_page   = $(self.grid).data('page');
        var limit_per_page = $(self.grid).data('limit');
        var search         = $(self.grid).data('search');

        if (undefined === data_provider || data_provider === '') {
            Admin.log('Data Provider inexistente', Admin.MODE_DEBUG);
            return false;
        } else {
            Admin.log('Data Provider: ' + data_provider, Admin.MODE_DEBUG);
        }

        var params = {
            page    : current_page,
            limit   : limit_per_page,
            filters : [],
            orders  : [],
            search  : search
        };

        $('.page-grid-col', self.grid).each(function(){

            var name = $(this).data('id');
            var order = 'none';
            if ($(this).hasClass('order-desc') === true) {
                order = 'desc';
            } else if ($(this).hasClass('order-asc') === true) {
                order = 'asc';
            } else {
                return;
            }

            params.orders.push({
                id: name,
                order: order
            });
        });

        var ajax = new Ajax(data_provider);
        ajax.setParams(params);
        ajax.setResponseType('json');
        ajax.call(function(status, obj) {

            // Atualiza a página atual
            $(self.grid).data('page', obj.response.current_page);

            self.populateGrid(obj.response.data);
            self.populatePagination(obj.response);
            self.populateInfo(obj.response);

            // Valor aproximado em pixels: número de caracteres x 9
            var width_id = $(self.grid).data('column-id-show') === 'yes' ? (obj.response.sizes.id * 9) : 0;
            $(self.grid).data('stick-id', width_id);

            var width_main = obj.response.sizes.main * 9;
            $(self.grid).data('stick-main', width_main);

            self.calcSticky();
        });

        return true;
    },

    populateGrid: function(data)
    {
        var self = this;
        $('tbody', self.grid).empty();

        var column_id = $(self.grid).data('column-id');
        var column_alias_id = $(self.grid).data('column-alias-id');

        $.each(data, function(index, columns){

            var id_value = data[index][column_id];

            // Ccopia o template
            var row = $('<tr>' + $('.page-grid-row-template', self.grid).html() + '</tr>');

            // Prepara os IDs dos checkboxes
            $('.page-grid-check input[type="checkbox"]', row).attr('id', 'check-' + id_value);
            $('.page-grid-check label', row).attr('for', 'check-' + id_value);

            // Prepara os IDs dos actions
            $('.page-grid-actions a', row).data('id', id_value);
            $('.page-grid-actions a', row).click(function(){

                var id = $(this).data('id');
                var url = $(this).data('url');

                var get_params = {};
                get_params[column_alias_id] = id;

                if ($(this).hasClass('page-grid-action-javascript') === true) {
                    var function_name = $(this).data('function');
                    window[function_name](this);

                } else if ($(this).hasClass('page-grid-action-delete') === true) {
                    var function_delete_name = $(this).data('function') + '_delete';
                    window[function_delete_name](this);

                } else if (undefined !== url && url !== 'javascript:void(0)') {
                    Admin.callPageUrl(url, get_params, 'page-loader');
                }
            });

            // Aplica os valores nos campos do template
            $.each(columns, function(name, value){
                $('td[data-id="' + name + '"] span', row).html(value);
            });

            // Adiciona nova linha
            $('tbody', self.grid).append(row);
        });
    },

    populateInfo: function(data)
    {
        var text, pages, info;

        info = $('#' + $(this.grid).attr('id') + '-info');

        if (undefined !== data.from || null !== data.from) {
            text = '<i class="fa fa-info-circle"></i> '
                 + 'Nenhum registro encontrado para exibição';
        } else {
            pages = (data.last_page>1) ? data.last_page + ' páginas' : '1 página';
            text = '<i class="fa fa-info-circle"></i> '
                 + 'Exibindo de ' + data.from + ' a ' + data.to
                 + ' de ' + data.total + ' registros'
                 + ' em ' + pages;
        }

        $(info).html(text);
    },

    populatePagination: function( data)
    {
        var page = 0;
        var paginator = $('#' + $(this.grid).attr('id') + '-pagination .pagination');

        // Anterior
        if (data.prev_page_url === null) {
            $('.page-item-prev .page-link', paginator).data('page', page).parent().addClass('disabled');
        } else {
            page = this.getUrlParam(data.prev_page_url, 'page');
            $('.page-item-prev .page-link', paginator).data('page', page).parent().removeClass('disabled');
        }

        // Próxima
        if (data.next_page_url === null) {
            $('.page-item-next .page-link', paginator).data('page', page).parent().addClass('disabled');
        } else {
            page = this.getUrlParam(data.next_page_url, 'page');
            $('.page-item-next .page-link', paginator).data('page', page).parent().removeClass('disabled');
        }

        // Primeira Página
        $('.page-item-first .page-link', paginator).data('page', 1);
        if (data.current_page > 3 && data.last_page > 5) {
            $('.page-item-first', paginator).show();
        } else {
            $('.page-item-first', paginator).hide();
        }

        // Última Página
        $('.page-item-last .page-link', paginator).data('page', data.last_page).text('... ' + data.last_page);
        if (data.last_page > 5 && data.current_page < (data.last_page - 2)) {
            $('.page-item-last', paginator).show();
        } else {
            $('.page-item-last', paginator).hide();
        }

        // Miolo
        var active_page = data.current_page;
        var start_page = active_page - 2;
        start_page = (start_page <=0) ? 1 : start_page;
        //start_page = (data.current_page <=0) ? 1 : start_page;

        for (var x=0; x<5; x++) {

            var current = start_page + x;

            if (current <= data.last_page) {
                $('.page-item-' + x + ' .page-link', paginator).data('page', current).text(current).parent().show();
            } else {
                $('.page-item-' + x + ' .page-link', paginator).text(current).parent().hide();
            }

            if (current === active_page) {
                $('.page-item-' + x, paginator).addClass('active');
            } else {
                $('.page-item-' + x, paginator).removeClass('active');
            }
        }
    },

    getUrlParam: function(url, param)
    {
        var qstring = url.slice(url.indexOf('?') + 1).split('&');
        for (var i=0; i < qstring.length; i++) {
            var urlparam = qstring[i].split('=');
            if (urlparam[0] === param) {
                return urlparam[1];
            }
        }
    }

 };

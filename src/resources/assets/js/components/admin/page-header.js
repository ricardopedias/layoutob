
/**
 * Objeto PageGrid
 */
 var PageHeader = window.PageHeader = {

     init: function()
     {
         var self = this;
         this.setupBreadcrumb();
         this.setupHelp();
         this.setupRightInfo();
     },

     setupBreadcrumb: function()
     {
         $('#js-toppanel-breadcrumb').empty();

         $('.js-meta-breadcrumb').each(function(){

             var item = $('<a>')
                .data('url', $(this)
                .data('url')).html($(this).html())
                .attr({
                    href: $(this).data('href'),
                    class: $(this).data('class'),
                    target: $(this).data('target')
                });

            $('#js-toppanel-breadcrumb').append(item);
         });

         $('#js-toppanel-breadcrumb a').click(function() {

             var url = $(this).data('url');
             Admin.callPageUrl(url);
         });
     },

     setupHelp: function()
     {
         $('#js-toppanel-help').removeClass('d-none').addClass('d-none');

         var url = $('#js-meta-help-url').data('url');
         if (undefined !== url) {
             $('#js-toppanel-help').data('url', url).removeClass('d-none');
         }
     },

     setupRightInfo: function()
     {
         $('#js-toppanel-info').removeClass('d-none').addClass('d-none');

         var info = $('#js-meta-right-info').data('content');
         if (undefined !== info) {
             $('#js-toppanel-info').html(info).removeClass('d-none');
         }
     }

 };

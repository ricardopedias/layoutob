
/**
 * --------------------------------------------------------------------------
 * Sidemenu
 * Copyright (c) 2018 Ricardo Pereira Dias (https://rpdesignerfly.github.io/)
 * --------------------------------------------------------------------------
 * Este arquivo inclui a API do menu lateral do painel
 */

 var Sidemenu = window.Sidemenu = {

     expand: function()
     {
         this.contract();
         $('#js-sidemenu, #js-sidemenu-minimize').addClass('expanded');
     },

     contract: function()
     {
         this.updateMobileButtonState();
         $('#js-sidemenu, #js-sidemenu-minimize').removeClass('expanded');
     },

     isContracted: function()
     {
         return this.isExpanded() === false;
     },

     isExpanded: function()
     {
         return $('#js-sidemenu').hasClass('expanded') === true;
     },

     toggleExpanded: function()
     {
         this.updateMobileButtonState();
         $('#js-sidemenu').toggleClass('expanded');
         $('#js-sidemenu-minimize').toggleClass('expanded');
     },

     minimize: function()
     {
         // conteudo 'main' é movido para a esquerda
         $('body').addClass('sidemenu-minimized');

         // barra lateral é minimizada
         $('#js-sidemenu-minimize').addClass('minimized');
         $('#js-sidemenu').addClass('minimized');

         // comprime os submenus que estiverem abertos
         $('.sidemenu .has-sub').each(function(){
             $(this).removeClass('opened');
             $(this).next().removeClass('opened');
         });

         // Se for um item de submenu, marca o submenu com aparência de ativo
         var activated = this.getActivatedItem();
         if (this.isSubmenuItem(activated) == true) {
             var activated_submenu = this.getSubmenuByItem(activated);
             $(activated_submenu).addClass('active');
         }
     },

     maximize: function()
     {
         // conteudo 'main' é movido para a direita
         $('body').removeClass('sidemenu-minimized');

         // barra lateral é maximizada
         $('#js-sidemenu').removeClass('minimized');
         $('#js-sidemenu-minimize').removeClass('minimized');

         var activated_submenu = $('#js-sidemenu .has-sub.active');
         if (undefined !== activated_submenu.get(0)) {
             console.log('opened');
             this.openSubmenu(activated_submenu);
         }
     },

     isMinimized: function()
     {
         return $('#js-sidemenu').hasClass('minimized');
     },

     isSubmenu: function(elem)
     {
         return $(elem).hasClass('has-sub');
     },

     isSubmenuItem: function(elem)
     {
         return $(elem).parent().hasClass('sidemenu-sub');
     },

     getSubmenuByItem: function(elem)
     {
         return $(elem).parent().prev('a');
     },

     openSubmenu: function(elem)
     {
         if (this.isSubmenu(elem) === false) {
             return false;
         }

         this.closeSubmenu(elem);
         $(elem).addClass('opened');
         $(elem).next().addClass('opened');
     },

     closeSubmenu: function(elem)
     {
         if (this.isSubmenu(elem) == false) {
             return false;
         }

         $(elem).removeClass('opened');
         $(elem).next().removeClass('opened');
     },

     isOpenedSubmenu: function(elem)
     {
         return $(elem).hasClass('opened');
     },

     isClosedSubmenu:  function(elem)
     {
         return this.isOpenedSubmenu(elem) === false;
     },

     closeAllSubmenus: function()
     {
         var self = this;
         $('.sidemenu .has-sub').each(function(){
             self.closeSubmenu(this);
         });
     },

     activateItem: function(elem)
     {
         if (this.isSubmenu(elem) === true) {

             Sidemenu.closeAllSubmenus();
             Sidemenu.openSubmenu(elem);

         } else if(this.isSubmenuItem(elem) === true) {

             Sidemenu.inactivateAllItems();
             $(elem).addClass('active');

             // se for mobile, contrai o menu
             Sidemenu.contract();

         } else {

             Sidemenu.closeAllSubmenus();
             Sidemenu.inactivateAllItems();
             $(elem).addClass('active');

             // se for mobile, contrai o menu
             Sidemenu.contract();
         }
     },

     inactivateItem: function(elem)
     {
         if (this.isSubmenu(elem) === true) {
             $(elem).removeClass('active');
             $('a', $(elem).next()).removeClass('active');
         } else {
             $(elem).removeClass('active');
         }
     },

     isActivatedItem: function(elem)
     {
         return $(elem).hasClass('active');
     },

     getActivatedItem: function()
     {
         return $('#js-sidemenu a.active');
     },

     inactivateAllItems: function()
     {
         $('#js-sidemenu a').removeClass('active');
     },

     updateMobileButtonState: function()
     {
         // TODO: Melhorar esta veriificação para analisar o estado real do menu,
         // trocando o icone adequadamente neste método
         var mobile_button = $('#js-mobile-menu');
         if ($('svg', mobile_button).attr('data-icon') === "bars") {
             $('svg', mobile_button).attr('data-icon', 'times');
         } else {
             $('svg', mobile_button).attr('data-icon', 'bars');
         }
     }

 };

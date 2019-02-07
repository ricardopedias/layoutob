
if (undefined !== $('#js-sidemenu-touch').get(0)) {

    // Ao arrastar o dedo para a direita
    var open_menu = new Hammer($('#js-sidemenu-touch').get(0));
    open_menu.get('pan').set({ direction: Hammer.DIRECTION_ALL });
    open_menu.on("panright", function(e) {
        e.preventDefault();
        Sidemenu.expand();
    });

    // Ao arrastar o dedo para a esquerda
    var close_menu = new Hammer($('#js-sidemenu').get(0));
    close_menu.get('pan').set({ direction: Hammer.DIRECTION_ALL });
    close_menu.on("panleft", function(e) {
        e.preventDefault();
        Sidemenu.contract();
    });

}




// Cliques no corpo do painel
$('body').mousedown(function(evt){

    // se o menu lateral já estive expandido
    if (Sidemenu.isExpanded() == false) {
        // encerra o evento
        return;
    }

    // se o item clicado for o menu lateral
    if (evt.target.id == "js-sidemenu") {
        // encerra o evento
        return;
    }

    // Para descendentes de menu_content que estão sendo clicados,
    // remova essa verificação se você não quiser colocar restrição em descendentes.
    if ($(evt.target).closest('#js-sidemenu').length) {
        // encerra o evento
        return;
    }

    // clicar no botão de mobile menu
    if ($(evt.target).closest('#js-mobile-menu').length) {
        // encerra o evento
        return;
    }

    // Fecha o menu lateral
    Sidemenu.contract();
});


// ao clicar no botão minimize a barra lateral
// alterna entre minimizada e maximizada
$('#js-sidemenu-minimize').click(function(){
    if (Sidemenu.isMinimized() == true) {
        Sidemenu.maximize();
    } else {
        Sidemenu.minimize();
    }
});

// ao expandir um submenu, a barra lateral
// sai do modo de minimizado automaticamente
$('#js-sidemenu .has-sub').click(function(){
    if (Sidemenu.isMinimized() == true) {
        Sidemenu.maximize();
    }
});

// ao clicar no menu mobile a barra lateral
// sai do modo de minimizado automaticamente
$('#js-mobile-menu').click(function(){
    Sidemenu.maximize();
});

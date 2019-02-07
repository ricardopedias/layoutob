
$('#js-sidemenu a').click(function(){
    if (Sidemenu.isOpenedSubmenu(this) == true) {
        Sidemenu.activateItem(this);
        Sidemenu.closeSubmenu(this);
    } else {
        Sidemenu.activateItem(this);
    }
});

// ao expandir um submenu, a barra lateral
// sai do modo de minimizado automaticamente
$('#js-sidemenu .has-sub').click(function(){

    // if (Sidemenu.isOpenedSubmenu(this) === true) {
    //     Sidemenu.closeSubmenu(this);
    // } else {
    //     Sidemenu.openSubmenu(this);
    // }
});

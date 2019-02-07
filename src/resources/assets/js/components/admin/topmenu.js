
$('#js-profile-menu').appendTo('body');

// Menu do perfil
$('#js-profile-button').click(function(){
    $(this).toggleClass('active');
    $('#js-profile-menu').toggleClass('d-flex');
});

$('html').click(function(event) {

    if($(event.target).closest('#js-profile-button').length) {
        // botão e seus descendentes
        return;
    }

    if($(event.target).closest('#js-profile-menu').length) {
        // menu e seus descendentes
        return;
    }

    // ok, oculta o menu
    $('#js-profile-button').removeClass('active');
    $('#js-profile-menu').removeClass('d-flex');
});

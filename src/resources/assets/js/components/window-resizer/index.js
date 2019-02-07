
// --------------------------------------------------------------------------
// resizer/index.js
// Copyright (c) 2018 Ricardo Pereira Dias (https://rpdesignerfly.github.io)
// Este arquivo contém a implementação do resizer inteligente
// da janela do navegador
// --------------------------------------------------------------------------

window.WindowResizer = {

    initialized : false,

    resize_timeout : null,

    callbacks: [],

    init: function()
    {
        if (this.initialized === true) {
            return true;
        }

        var self = this;

        window.onresize = function() {

            clearTimeout(self.resize_timeout);

            // handle normal resize
            self.resize_timeout = setTimeout(function() {
                $.each(self.getCallbacks(), function(k, callback){
                    callback();
                });
            }, 250); // set for 1/4 second.  May need to be adjusted.
        };

        this.initialized = true;
    },

    /**
     * Adiciona um callback na pilha de execução ao terminar
     * o redimensionamento da janela.
     *
     * @param  {Function} callback
     * @return {[type]}
     */
    addCallback: function(callback)
    {
        this.init();
        this.callbacks.push(callback);
    },

    /**
     * Devolve a pilha de callbacks.
     *
     * @return {[type]}
     */
    getCallbacks: function()
    {
        this.init();
        return this.callbacks;
    }
}

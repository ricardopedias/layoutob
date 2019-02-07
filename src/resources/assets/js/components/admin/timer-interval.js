
// --------------------------------------------------------------------------
// TimerInterval
// Copyright (c) 2018 Ricardo Pereira Dias (https://rpdesignerfly.github.io)
// Este arquivo contém a implementação dos eventos de repetição inteligente
// --------------------------------------------------------------------------

var TimerInterval = window.TimerInterval = function()
{
    this.start_date = new Date();
};

TimerInterval.prototype = {

    callbacks: {},

    intervals: {},

    start_date: null,

    /**
     * Adiciona um callback na pilha de execução ao terminar
     * o redimensionamento da janela.
     *
     * @param  {Function} callback
     * @return {[type]}
     */
    addCallback: function(tag, delay, callback)
    {
        if (typeof callback === 'function') {

            // Adiciona o novo delay
            this.addDelay(delay);

            if (undefined  === this.callbacks[delay][tag]) {
                this.callbacks[delay][tag] = [];
            }

            this.callbacks[delay][tag].push(callback);

        } else {
            throw new Error('Callback para a tag ' + tag + ' não é uma função!');
        }
    },

    removeTag: function(tag)
    {
        var self = this;

        // Varre todos os delays
        $.each(this.callbacks, function(delay, list_delays){

            // Varre todas as tags do delay
            $.each(list_delays, function(current_tag, routine){

                // Remove apenas as rotinas da tag específica
                if (current_tag === tag) {

                    self.callbacks[delay][tag] = [];
                    delete self.callbacks[delay][tag];

                    console.log('removendo: tag: ' + tag + ' do delay: ' + delay + 's');
                }

            });
        });
    },

    /**
     * Devolve a pilha completa de callbacks.
     *
     * @return {object}
     */
    getAllCallbacks: function()
    {
        return this.callbacks;
    },

    addDelay: function(delay)
    {
        var self = this;
        var interval_delay = 1000 * parseFloat(delay, 1);

        if (undefined  === this.callbacks[delay]) {

            // Cria a entrada para callbacks
            this.callbacks[delay] = {};

            // Cria entrada para intervalos
            this.intervals[delay] = [];

            // Cria o intervalo correspondente para o novo delay
            this.intervals[delay].push(setInterval(function(){

                // Executa as rotinas
                self.handle(delay);

            }, interval_delay));

            return true;
        }

        return false;
    },

    removeDelay: function(delay)
    {
        if (undefined  !== this.callbacks[delay]) {

            // Remove o evento de intervalo
            clearInterval(this.intervals[delay]);

            // Limpa a entrada para callbacks
            this.callbacks[delay] = {};
            delete this.callbacks[delay];

            // Limpa a entrada para intervalos
            this.intervals[delay] = [];
            delete this.intervals[delay];
        }
    },

    /**
     * Executa as rotinas armazenadas no delays especificado.
     *
     * @param  {float} delay
     * @return {void}
     */
    handle: function(delay)
    {
        var self = this;

        // varre o delay
        var size = 0;
        $.each(this.callbacks[delay], function(current_tag, routines_list){

            $.each(routines_list, function(k, routine){
                // executa a rotina
                var end_date = new Date();
                var seconds = (end_date.getTime() - self.start_date.getTime()) / 1000;
                Admin.log( '+' + parseInt(seconds)  + ' executando delay ' + delay + 's: rotina ' + k + ' da tag ' + current_tag);
                routine(self);
                size++;
            });
        });

        if (size === 0) {
            self.removeDelay(delay);
        }
    }
}

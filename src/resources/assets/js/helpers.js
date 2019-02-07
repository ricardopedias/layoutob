
// --------------------------------------------------------------------------
// helpers.js
// Copyright (c) 2018 Ricardo Pereira Dias (https://rpdesignerfly.github.io)
// Este arquivo contém funções personalizadas
// --------------------------------------------------------------------------

window.Helpers = {

    strPadLeft: function(input, pad_length, pad_string)
    {
        if (undefined === pad_string) {
            pad_string = ' ';
        }

        var pad_length   = parseInt(pad_length);
        var input_length = parseInt(String(''+input).length);
        var input_string = Array(pad_length).fill(pad_string, 0).join('') + input;

        var result = input_string.substr(pad_length*-1);
        return result;
    },

    /**
     * Formata uma string de data do banco de dados
     * para exibição na tela
     */
    dateToView: function(date_string, separator)
    {
        if (undefined === separator) {
            separator = '/';
        }

        var date = new Date(date_string);
        return this.strPadLeft(date.getUTCDate(), 2, '0')
            + separator
            + this.strPadLeft(date.getUTCMonth(), 2, '0')
            + separator
            + this.strPadLeft(date.getUTCFullYear(), 2, '0');
    },

    /**
     * Formata uma string de data do banco de dados
     * para exibição na tela
     */
    datetimeToView: function(datetime_string, separator)
    {
        if (undefined === separator) {
            separator = '/';
        }

        var parts = datetime_string.split(' ');

        var date = new Date(parts[0]);
        return this.strPadLeft(date.getUTCDate(), 2, '0')
            + separator
            + this.strPadLeft((date.getUTCMonth()+1), 2, '0')
            + separator
            + this.strPadLeft(date.getUTCFullYear(), 4, '0')
            + ' '
            + parts[1];
    }

};

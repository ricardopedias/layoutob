
/**
 * Objeto Admin
 */
var Ajax = window.Ajax = function(url)
{
     this.setUrl(url);
};

Ajax.prototype = {

    url : null,

    method: 'get',

    params: null,

    type: 'html',

    setUrl: function(url)
    {
        if (undefined !== url || null !== url) {
            this.url = url;
        }
    },

    setMethod: function(method)
    {
        this.method = method;
    },

    setParams: function(object)
    {
        this.params = object;
    },

    setResponseType: function(type)
    {
        this.type = type;
    },

    headersToObject: function(string)
    {
        var list = string.split('\r\n');
        var headers = list.reduce(function (acc, current, i){
              var parts = current.split(': ');
              acc[parts[0]] = parts[1];
              return acc;
        }, {});

        return list;
    },

    call: function(callback)
    {
        var self = this;
        var settings = {};

        settings.url = self.url;
        settings.method = self.method;
        settings.dataType = self.type;

        if (self.params !== null) {
            settings.data = self.params;
        }

        settings.headers = {
            // Para que uma mensagem seja exibida no lugar dos redirecionamentos automaticos
            // Por ex: login expirado
            // Veja /app/Http/Middleware/Authenticate::redirectTo()
            Accept: "application/json; charset=utf-8"
        };

        settings.success = function(response, statusText, xhr) {

            if (typeof callback === 'function') {

                callback('success', {
                    ajax: xhr,
                    response: response,
                    http_status: xhr.status,
                    http_status_text: statusText,
                    headers: self.headersToObject(xhr.getAllResponseHeaders())
                });
            }
        };

        settings.error = function(xhr, status, statusText) {

           if (typeof callback === 'function') {

               if(xhr.status !== 200) {
                   // Unautenticated
                   // Quando a sessão expira, e uma página html for solicitada,
                   // uma mensagem json é liberada como se fosse html.
                   // Por isso, deve ser parseada!
                   xhr.responseJSON = JSON.parse(xhr.responseText);
               }

               callback('error', {
                   ajax: xhr,
                   response: (undefined !== xhr.responseJSON && xhr.responseJSON !== '' ? xhr.responseJSON : xhr.responseText),
                   http_status: xhr.status,
                   http_status_text: xhr.statusText,
                   headers: self.headersToObject(xhr.getAllResponseHeaders())
               });
           }
        };

        $.ajax(settings);

    }
}

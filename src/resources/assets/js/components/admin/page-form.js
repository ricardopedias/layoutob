
/**
 * Objeto PageForm
 */
 var PageForm = window.PageForm = {

     init: function(form)
     {
         var self = this;
         this.form = form;

         // Invoca os dados
         self.setupSubmitAction(form);

         self.setupValidations(form);
     },

     setFormJsStatus: function(form, status)
     {
         $(form).data('js-status', status);
     },

     getFormJsStatus: function(form)
     {
         var status = $(form).data('js-status');

         if (status !== 'valid' && status !== 'invalid') {
             var err = new Error();
             Admin.log(err.stack, 'Form.getFormJsStatus');
         }

         return status;
     },

     setFormDbStatus: function(form, status)
     {
         $(form).data('db-status', status);
     },

     getFormDbStatus: function(form)
     {
         var status = $(form).data('db-status');

         if (status !== 'valid' && status !== 'invalid') {
             var err = new Error();
             Admin.log(err.stack, 'Form.getFormDbStatus');
         }

         return status;
     },

     showAlert: function(form, type, message)
     {
         var id = $(form).attr('id');
         var alert = $('#' + id + '-alert');

         // Esconde o alerta
         $(alert).css({ opacity: 0 });
         $(alert).removeClass('d-none');

         // Aplica a classe correta
         $.each(['danger', 'warning', 'info', 'success'], function(k,v){
             $(alert).removeClass('form-alert-' + v);
         });
         $(alert).addClass('form-alert-' + type);

         // Muda a mensagem
         $('.form-' + type + ' span', alert).html(message);

         // Ativa o alerta correto
         $('.form-alert').hide();
         $('.form-' + type, alert).show();

         // Exibe o alerta
         $(alert).animate({ opacity: 1 });
     },

     hideAlert: function(form)
     {
         var id = $(form).attr('id');
         var alert = $('#' + id + '-alert');

         if ($(alert).hasClass('d-none') === true) {
             return false;
         }

         $(alert).animate({ opacity: 0 }, 300, function(){
             $(this).hide();
             $(alert).addClass('d-none');
         });
     },

     setupSubmitAction: function(form)
     {
        var self = this;
        $('form', form).submit(function(){

            // faz a validação em todos os campos
            $('input, textarea, select', form).each(function(){
                self.validationsEvent(form, this);
            });

            var action = $(form).data('action');
            var key_field = $(form).data('key-field');
            var key_value = $(form).data('key-value');
            var status = $(form).data('js-status');

            // se o formulário possuir inconsistencias
            if (status !== 'valid') {
                var message = $(form).data('generic-error-message');
                self.showAlert(form, 'warning', message);
                $("html,body").animate({ "scrollTop": 0 });
                return false;
            }

            // Instância o FormData passando como parâmetro o formulário
            var form_data = new FormData(this);

            // se for atualização, anexa o id
            form_data.append(key_field, key_value);

            Admin.pageLoader('show');

            // Envia o FormData através da requisição AJAX
            $.ajax({
                url: action,
                type: "POST",
                data: form_data,
                dataType: 'json',
                processData: false,
                cache: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('[name="_token"]', form).val()
                },
                success: function(response, status, xhr){

                    self.clearResponseErrors(form);

                    if (response.status === 'error') {

                        Admin.pageLoader('hide');

                        self.populateResponseErrors(form, response.messages);

                        // animação de fadeout manual
                        $('#js-page-content, #js-toppanel').animate({ opacity: 1 }, 400);
                        $("html, body").animate({ scrollTop: 0 }, 1);
                        var message = $(form).data('generic-error-message');
                        self.showAlert(form, 'warning', message);

                    } else if (response.status === 'success') {

                        var front = $(form).data('front');
                        var params = {};

                        if (key_value !== '') {
                            params[key_field] = key_value;
                            params['operation'] = 'updated';
                            params['message'] = $(form).data('generic-updated-message');
                        } else {
                            params[key_field] = response.id;
                            params['operation'] = 'created';
                            params['message'] = $(form).data('generic-created-message');
                        }

                        Admin.callPageUrl(front, params, 'none');
                    }

                },
                error: function (xhr, status, status_message) {

                    var response = (undefined !== xhr.responseJSON && xhr.responseJSON !== '' ? xhr.responseJSON : xhr.responseText);

                    var message = $(form).data('generic-exception-message');
                    if (Admin.mode === 'development') {
                        message += undefined !== response.message ? response.message : json.response;
                    }
                    self.showAlert(form, 'danger', message);

                    // animação de fadeout manual
                    Admin.pageLoader('hide');
                    $('#js-page-content, #js-toppanel').animate({ opacity: 1 }, 400);
                    $("html, body").animate({ scrollTop: 0 }, 1);
                    return;
                }
            });

         });
     },


     setupValidations: function(form)
     {
         var self = this;

         $('input, textarea, select', form).each(function(){
             $(this).blur(function(){
                 self.validationsEvent(form, this);
             });
         });
     },

     getJsValidations: function()
     {
         return [
             'required',
             'numeric',
             'min',
             'max'
         ];
     },

     fieldJsValidated: function(form, field)
     {
         var validations = this.getJsValidations();


     },

     validationsEvent: function(form, elem)
     {
         var self = this;

         if (undefined === $(elem).attr('name')) {
             console.log('Elemento sem "name" encontrado');
             return false;
         }

         var name = $(elem).attr('name').replace('[]', '');
         var value = $(elem).val();

         // Obrigatoriedade
         var required = $('#js-' + name + ' span.required').get(0);
         required = (undefined !== required && $(required).data('value') === 1);
         if (required === true && self.validateRequired(elem) === false) {
             console.log('Elemento "' + name + ' é obrigatorio');
             self.updateFormStatus(form);
             return false;
         }

         // Obrigatoriedade
         var numeric = $('#js-' + name + ' span.numeric').get(0);
         if (undefined !== numeric && self.validateNumeric(elem) === false) {
             console.log('Elemento "' + name + ' deve ser numérico');
             self.updateFormStatus(form);
             return false;
         }

         // Mínimo de caracteres
         $.each(['numeric','file','string','array'], function(k, type){
             var param = $('#js-' + name + ' span.min-' + type).get(0);
             var min = parseInt($(param).data('value'));
             if (undefined !== param && self.validateMin(elem, min, value, type) === false) {
                 console.log('Elemento "' + name + ' deve ter no minimo ' + min + ' caracteres');
                 self.updateFormStatus(form);
                 return false;
             }
         });

         // Maximo de caracteres
         $.each(['numeric','file','string','array'], function(k, type){
             var param = $('#js-' + name + ' span.max-' + type).get(0);
             var max = parseInt($(param).data('value'));
             if (undefined !== param && self.validateMax(elem, max, value, type) === false) {
                 console.log('Elemento "' + name + ' deve ter no máximo ' + max + ' caracteres');
                 self.updateFormStatus(form);
                 return false;
             }
         });

         self.updateFormStatus(form);
     },

     updateFormStatus: function(form)
     {
         var self = this;
         var form_js_status = 'valid';
         var form_db_status = 'valid';

         // Aplica o status no formulário
         $('input, textarea, select', form).each(function(){
             var name = $(this).attr('name');
             if (undefined === name) {
                 console.log('Elemento ' + $(this).prop("tagName").toLowerCase() + ' não possui nome');
             }
             name = name.replace('[]', '');
             var field = $('#js-' + name).get(0);
             if (undefined !== field) {
                 if ($(field).data('js-status') === 'invalid') {
                     form_js_status = 'invalid';
                 }

                 if ($(field).data('db-status') === 'invalid') {
                     form_db_status = 'invalid';
                 }
             }
         });

         this.setFormJsStatus(form, form_js_status);
         this.setFormDbStatus(form, form_db_status);
     },

     validateRequired: function(elem)
     {
         // console.log($(elem).prop("tagName").toLowerCase());
         // if ($(elem).prop("tagName").toLowerCase() === 'select') {
         //
         //     console.log('select: ' + $(elem).val() );
         //     console.log('select: ' + $(elem) );
         //     console.log('option: ' + $('option:first', elem).val());
         //     console.log('option: ' + $('option:first', elem));
         //
         //     // && $('option:first', elem).val() === ''
         //     console.log( $('option:first', elem) );
         //
         //     // Obrigatoriedade de campos select
         //     console.log($(elem).val());
         //     this.setFieldJsStatus(elem, 'invalid', 'required');
         //     return false;
         //
         // } else
         if ($(elem).val() === '') {
             // Obrigatoriedade de campos input e textarea
             console.log($(elem).val());
             this.setFieldJsStatus(elem, 'invalid', 'required');
             return false;

         }

         this.setFieldJsStatus(elem, 'valid', 'required');
         return true;
     },

     validateNumeric: function(elem)
     {
         if ($.isNumeric($(elem).val()) === false) {
             this.setFieldJsStatus(elem, 'invalid', 'numeric');
             return false;
         }

         this.setFieldJsStatus(elem, 'valid', 'numeric');
         return true;
     },

     validateMin: function(elem, size, value, type)
     {
         if (type !== 'string' && type !== 'numeric') {
             // validar arrays e files
             return true;
         }

         var string = value+"";
         if (string.length < size) {
             this.setFieldJsStatus(elem, 'invalid', 'min-' + type, { min : size });
             return false;
         }

        this.setFieldJsStatus(elem, 'valid', 'min-' + type, { min : size });
        return true;
     },

     validateMax: function(elem, size, value, type)
     {
         if (type !== 'string' && type !== 'numeric') {
             // validar arrays e files
             return true;
         }

         var string = value+"";
         if (string.length > size) {
             this.setFieldJsStatus(elem, 'invalid', 'max-' + type, { max : size });
             return false;
         }

         this.setFieldJsStatus(elem, 'valid', 'max-' + type, { max : size });
         return true;
     },

     setFieldStatus: function(elem, status, validation, attributes, status_param)
     {
         var parent = $(elem).parent();
         var name = $(elem).attr('name').replace('[]', '');
         var label = $('#js-' + name).data('label');
         var error_message = $('#js-validation-' + validation).text();
         var success_message = $('#js-validation-ok').text();
         var status_param = undefined !== status_param ? status_param : 'js-status';
         var current_invalid = $(elem).parent().hasClass('field-invalid');


         $(parent).removeClass('field-invalid').removeClass('field-valid');

         // Marca o campo como inválido
         if (status === 'invalid') {

             $(parent).addClass('field-invalid');
             $('#js-' + name).data(status_param, 'invalid');

             // Seta a mensagem correta
             // TODO: se for um array de mensagens, fazer o join para remover a virgula. :)
             var message_string = error_message.replace(/:attribute/, '"' + label + '"');

             if (undefined !== attributes) {
                 $.each(attributes, function(k, v){
                     message_string = message_string.replace(new RegExp(':' + k), v);
                 });
             }

             $('#' + name + '-help').text(message_string);
             return true;
         }

         // Marca o campo como válido
         $('#js-' + name).data(status_param, 'valid');
         $('#' + name + '-help').text('');
         if (current_invalid === true && $('#' + name).val() !== '') {
             // se o campo foi verificado anteriormente como inválido
             // e desta vez foi corrigido...
             $(parent).addClass('field-valid');
             // Seta a mensagem correta
             var message_string = success_message.replace(/:attribute/, '"' + label + '"');
             $('#' + name + '-help').text(message_string);
         }
     },

     setFieldJsStatus: function(elem, status, validation, attributes)
     {
         this.setFieldStatus(elem, status, validation, attributes, 'js-status');
     },

     setFieldDbStatus: function(elem, status, validation, attributes)
     {
         this.setFieldStatus(elem, status, validation, attributes, 'db-status');
     },

     clearResponseErrors: function(form)
     {
         // Limpa o formulário
         $('.js-field', form).each(function() {
             var name = $(this).data('name').replace('[]', '');
             console.log(name);
             var elem = $('[name="' + name + '"]');
             var parent = $(elem).parent();
             $(parent).removeClass('field-invalid').removeClass('field-valid');
             if ($('#js-' + name).data('db-status') === 'invalid') {
                 $('#js-' + name).data('db-status', 'valid');
                 $('#' + name + '-help').text('');
             }
         });
     },

     populateResponseErrors: function(form, fields)
     {
         var self = this;

         // Preenche as validações novamente
         $.each(fields, function(name, message) {
             var elem = $('[name="' + name + '"]');
             var parent = $(elem).parent();
             $(parent).removeClass('field-invalid').removeClass('field-valid');
             $('#js-' + name).data('db-status', 'invalid'); // o status é baseado no banco de dados
             $(parent).addClass('field-invalid');
             $('#' + name + '-help').text(message);
         });

         this.updateFormStatus(form);
     }

 };

$(document).ready(function () {

    // Caso a página inicial seja uma Grade de Dados
    var form = $('.page-form').get(0);
    if (undefined !== form) {
        PageForm.init(form);
    }

});

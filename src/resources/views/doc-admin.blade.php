<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ Admin::getAdminTitle() }}</title>

        @if(Admin::getHomePageUrl() !== null)
            <meta name="homepage" content="{{ Admin::getHomePageUrl() }}">
        @endif

        <meta name="admin-url" content="{{ trim(config('layout-ui.admin_url'), '/') }}">
        <meta name="environment" content="{{ env('APP_ENV') }}">
        <meta name="debug" content="{{ env('APP_DEBUG') }}">

        <link rel="stylesheet" href="@asset_theme">
    </head>

    <body class="admin">

        {!! $slot !!}

        <script src="@asset_js('admin.js')"></script>

        <script>

        // var url = "{{ route('admin.samples.observer-front') }}";
        //
        // Admin.callPageUrl(url, { teste: 'devel' }, function(status, obj){
        //     Admin.log('Observed');
        //     Admin.log(obj);
        // });

        // Admin.call('post', url, { teste: 'devel', _token: $('[name="csrf-token"]').attr('content') }, 'html', function(status, obj){
        //     Admin.log('Observed');
        //     Admin.log(obj);
        // });

            ////////////////////////////////////

            // var callback = function(status, obj){
            //     Admin.log({status: status, object: obj }, 'TestCall');
            // };
            //
            // $.ajax({
            //     url: url,
            //     method: 'get',
            //     data: $.param({ teste: 'devel' }),
            //     dataType: 'html',
            //     complete: function(){
            //        // hide loader
            //     },
            //     success: function(response, status, xhr) {
            //
            //         $('#js-page-content').html(response);
            //
            //         Admin.log({status: status, object: response }, 'TestCall');
            //
            //         // if (undefined !== callback) {
            //         //     callback('success', {
            //         //         ajax: xhr,
            //         //         status: status,
            //         //         response: response
            //         //     });
            //         // }
            //     },
            //     error: function(xhr, status, status_message) {
            //
            //         // Para não executar no documento atual
            //         // var html_document = document.implementation.createHTMLDocument('preview');
            //         // var container = html_document.createElement('div').innerHTML = xhr.responseText;
            //         // var title = $('.exception .exc-message span', container).html();
            //         // var content = $('#plain-exception', container).html();
            //
            //         Admin.log({status: status, object: xhr }, 'Core.call');
            //
            //        if (undefined !== callback) {
            //            callback('error', {
            //                ajax: xhr,
            //                status: status,
            //                response: (undefined !== xhr.responseJSON && xhr.responseJSON !== '' ? xhr.responseJSON : xhr.responseText)
            //                    // '<header class="page-header"><div class="mr-auto px-2 pt-2"><h3 class="mb-0">' + title + '</h3></div>' +
            //                    // '<div class="card mx-2 mt-2"><div class="card-body">' + content + '</div></div>'
            //            });
            //        }
            //     }
            // });

        </script>


    </body>

</html>

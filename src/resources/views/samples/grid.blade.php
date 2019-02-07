
@include('layout-ui::admin.components.page-header')

@include('layout-ui::admin.components.page-grid')

<script>

    Admin.addPageInterval(1, function(obj){
        console.log('GRID');
        console.log(obj.getAllCallbacks());
    });

</script>

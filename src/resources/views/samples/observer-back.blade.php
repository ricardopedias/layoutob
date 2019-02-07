
<div>Teste de Chamada Ajax</div>

<script>

    Admin.addPageInterval(1, function(obj){
        console.log('OBSERVER');
        console.log(obj.getAllCallbacks());
    });

</script>


<script>

    // Faz uma nova chamada ajax assim que a pagina terminar de carregar
    var url = "{{ route('admin.samples.observer-back') }}";
    Admin.callPageUrl(url, { teste: 'devel' });

</script>


<script>
    // Enregistrement du timepicker
    $(function () {
        $('#datetimepicker1').datetimepicker({
            language: 'fr',
            useSeconds: false
            });
    });

    function resetButtons() {
        $('#repetitionButton').removeClass('active');
        $('#concertButton').removeClass('active');
        $('#saisonButton').removeClass('active');
    }

    // Action sur les boutons de type d'évènement
    $('#repetitionButton').click(function() {
        resetButtons();

        $('#eventType').val("repetition");
        $('#repetitionButton').addClass('active');
    });
    
    $('#concertButton').click(function() {
        resetButtons();

        $('#eventType').val("concert");
        $('#concertButton').addClass('active');
    });

    $('#saisonButton').click(function() {
        resetButtons();

        $('#eventType').val("saison");
        $('#saisonButton').addClass('active');
    });
</script>

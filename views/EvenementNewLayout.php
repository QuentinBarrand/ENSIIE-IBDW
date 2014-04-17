<?php echo($header); ?>
<?php echo($navbar); ?>

<?php
$base = Flight::request()->base;
if($base == '/') $base = '';
?>

<h1>Ajouter un évènement</h1>

<div class="row">
    <div class="col-lg-5">

    <?php
        if($fail['error']) {
          echo '<div class="panel panel-danger">';
          echo '<div class="panel-heading">';
          echo '<h3 class="panel-title">Erreur</h3>';
          echo '</div>';
          echo '<div class="panel-body">';
          echo $fail['message'];
          echo '</div>';
          echo '</div>';
        }

    ?>

        <div id="eventTypeButtons" class="btn-group btn-group-lg">
          <button type="button" id="repetitionButton" class="btn btn-default active">Répétition</button>
          <button type="button" id="concertButton" class="btn btn-default">Concert</button>
          <button type="button" id="saisonButton" class="btn btn-default">Saison</button>
        </div>

        <form role="form" action="<?php echo $base; ?>/evenements/nouveau" method="post">
          <div class="form-group">
            <label for="eventName">Nom de l'évènement</label>
            <input type="text" name="nom" class="form-control" id="eventName" placeholder="Intitulé de l'évènement" required>
          </div>
          <div class="form-group" id="lieuDiv">
            <label for="eventPlace">Lieu de l'évènement</label>
            <input type="text" name="lieu" class="form-control" id="eventPlace" placeholder="Adresse, code postal et ville" required>
          </div>

            <div class="form-group" id="dateDiv">
                <label for="eventDate">Date de l'évènement</label>
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' id="eventDate" name="date" class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                    </span>
                </div>
            </div>


          <input id="eventType" type="hidden" name="type" value="repetition">

          <br>
          <div class="button-validate">
            <button type="submit" class="btn btn-lg btn-primary">Ajouter l'évènement</button>
          </div>
        </form>
    </div>
    <div class="col-lg-6 col-lg-offset-1 well">
        <h2>Avant d'ajouter un évènement, vérifiez bien que :</h2>
        <ul>
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </li>
            <li>Donec a diam lectus.</li>
            <li>Sed sit amet ipsum mauris.</li>
            <li>Maecenas congue ligula ac quam viverra nec consectetur ante hendrerit.</li>
            <li>Donec et mollis dolor.</li>
            <li>Praesent et diam eget libero egestas mattis sit amet vitae augue.</li>
        </ul>
    </div>
</div>
    
<script src="<?php echo Flight::request()->base; ?>/js/jquery.min.js"></script>
<script src="<?php echo Flight::request()->base; ?>/js/moment.min.js"></script>

<script src="<?php echo Flight::request()->base; ?>/js/bootstrap.min.js"></script>

<script src="<?php echo Flight::request()->base; ?>/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo Flight::request()->base; ?>/js/bootstrap-datetimepicker.fr.js"></script>


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

    <hr>
    <footer>
        <p>
            Une application réalisé par les étudiants FIPA 6 et FIP 19 de l'ENSIIE
        </p>
    </footer>
    
    </div>
</body>
</html>

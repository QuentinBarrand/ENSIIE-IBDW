<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>Ajouter un évènement</h1>

<div class="row">
    <div class="col-lg-5">
        <form role="form" action="<?php echo Flight::request()->base; ?>/evenements/nouveau" method="post">
          <div class="form-group">
            <label for="eventName">Nom de l'évènement</label>
            <input type="text" class="form-control" id="eventName" placeholder="Intitulé de l'évènement" required>
          </div>
          <div class="form-group">
            <label for="eventPlace">Lieu de l'évènement</label>
            <input type="text" class="form-control" id="eventPlace" placeholder="Adresse, code postal et ville" required>
          </div>
            <div class="form-group">
            <label for="eventDate">Date de l'évènement</label>

            <div id="datepicker">
                <div class="input-group date">
                    <input id="eventDate" type="text" class="form-control" placeholder="DD/MM/AAAA" required>
                    <span class="input-group-addon">Cliquez pour choisir une date</span>
                </div>
            </div>

          </div>

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
<script src="<?php echo Flight::request()->base; ?>/js/bootstrap.min.js"></script>
<script src="<?php echo Flight::request()->base; ?>/js/bootstrap-datepicker.js"></script>
<script src="<?php echo Flight::request()->base; ?>/js/bootstrap-datepicker.fr.js"></script>

<script>
    $('#datepicker .input-group.date').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        language: "fr"
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

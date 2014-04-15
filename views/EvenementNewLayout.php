<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>Ajouter un évènement</h1>

<div class="row">
    <div class="col-lg-5">
        <form role="form" action="<?php echo Flight::request()->base; ?>/evenements/nouveau" method="post">
          <div class="form-group">
            <label for="eventName">Nom de l'évènement</label>
            <input type="text" class="form-control" id="eventName" placeholder="Concert du Bar(c)">
          </div>
          <div class="form-group">
            <label for="eventPlace">Lieu de l'évènement</label>
            <input type="text" class="form-control" id="eventPlace" placeholder="1 Place de la Résistance 90000 Evry">
          </div>
            <div class="form-group">
            <label for="eventDate">Date de l'évènement</label>

            <div id="datepicker">
                <div class="input-group date">
                    <input id="eventDate" type="text" class="form-control">
                    <span class="input-group-addon">Cliquez pour choisir une date</span>
                </div>
            </div>

          </div>

          <button type="submit" class="btn btn-default">Ajouter l'évènement</button>
        </form>
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

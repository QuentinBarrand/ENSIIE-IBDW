<?php echo($header); ?>
<?php echo($navbar); ?>

<?php
$base = Flight::request()->base;
if($base == '/') $base = '';
?>

<h1>Création d'une saison</h1>
<br>

<div class="row">
    <div class="col-lg-5">
        <h2>Etablir le programme de la saison</h2>
        <form role="form" action="<?php echo $base; ?>/evenements/nouveau" method="post" class="form-horizontal" >
            <div class="form-group">
                <label class="col-sm-2 control-label">Nom</label>
                <div class="col-sm-10">
                <p class="form-control-static"><?php echo($infos['nom']); ?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Année</label>
                <div class="col-sm-10">
                <p class="form-control-static"><?php echo($infos['year']); ?></p>
                </div>
            </div>
            
            <div class="form-group">
                <label class="oeuvres">Quelles oeuvres voulez-vous ajouter au programme ?</label>
                <select id="oeuvres" name="oeuvres[]" multiple class="form-control">
                <?php
                foreach($oeuvres as $oeuvre){
                    ?>
                    <option value="<?php echo ($oeuvre['id']); ?>">
                    <?php echo ($oeuvre['titre']); ?></option>
                    <?php
                }
                ?>
                </select>
            </div>
          <br>
          <div class="button-validate">
            <button type="submit" class="btn btn-lg btn-primary">Valider le programme</button>
          </div>
        </form>
        <br><br>
        <h2>Ajouter une oeuvre</h2>
        <form role="form" action="<?php echo $base; ?>/evenements/nouveau" method="post" class="form-horizontal" >
            <div class="form-group">
                <label for="titre" class="col-sm-2 control-label">Titre</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre">
                </div>
            </div>
            <div class="form-group">
                <label for="auteur" class="col-sm-2 control-label">Auteur</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="auteur" name="auteur" placeholder="Auteur">
                </div>
            </div>            
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

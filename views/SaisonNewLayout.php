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
        <form role="form" action="<?php echo $base; ?>/saison/nouveau" method="post" class="form-horizontal" >
            <div class="form-group">
                <label class="col-sm-2 control-label">Nom</label>
                <div class="col-sm-10">
                <p class="form-control-static"><?php echo $nom; ?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Année</label>
                <div class="col-sm-10">
                <p class="form-control-static"><?php echo $annee; ?></p>
                </div>
            </div>
            
            <div class="form-group">
                <label class="oeuvres">Quelles oeuvres voulez-vous ajouter au programme ?</label>
                <select id="oeuvres" name="oeuvres[]" multiple class="form-control">
                <?php
                foreach($oeuvres as $oeuvre) {
                    echo '<option value="' . $oeuvre['idoeuvre'] . '">' . $oeuvre['titre'] . '</option>';
                }
                ?>
                </select>
            </div>
          <br>

          <input id="eventType" type="hidden" name="nom" value="<?php echo $nom; ?>">
          <input id="eventType" type="hidden" name="annee" value="<?php echo $annee; ?>">


          <div class="button-validate">
            <button type="submit" class="btn btn-lg btn-primary">Valider le programme</button>
          </div>
        </form>
    </div>

    <div class="col-lg-5 col-lg-offset-1">
        <?php
            if($added != NULL) {
                echo '<div class="panel panel-success">';
                echo '<div class="panel-heading">';
                echo '<h3 class="panel-title">Oeuvre ajoutée</h3>';
                echo '</div>';
                echo '<div class="panel-body">';
                echo $added;
                echo '</div>';
                echo '</div>';
            }
        ?>
        <div class="well">
            <h2>Ajouter une oeuvre</h2>
            <form role="form" action="<?php echo $base; ?>/oeuvre/nouveau" method="post" class="form-horizontal" >
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
                <div class="form-group">
                    <label for="auteur" class="col-sm-2 control-label">Partition</label>
                    <div class="col-sm-10">
                        <input type="url" class="form-control" id="partition" name="partition" placeholder="Lien vers la partition">
                    </div>
                </div>  
                <div class="form-group">
                    <label for="auteur" class="col-sm-2 control-label">Durée</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="duree" name="duree" placeholder="Durée en secondes">
                    </div>
                </div> 

                <div class="form-group">
                    <label for="auteur" class="col-sm-2 control-label">Style</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="style" name="style" placeholder="Rock, samba...">
                    </div>
                </div> 

                <input type="hidden" name="nom" value="<?php echo $nom; ?>">
                <input type="hidden" name="annee" value="<?php echo $annee; ?>">


                <div class="button-validate">
                    <button type="submit" class="btn btn-lg btn-default">Ajouter l'oeuvre</button>
                </div> 
            </form>
        </div>
    </div>
</div>
    
<?php echo $footer; ?>

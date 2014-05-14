<?php echo($header); ?>
<?php echo($navbar); ?>

<?php
$user = Flight::get('user');
$base = Flight::request()->base;
if($base == '/') $base = '';
?>

<h1>
    Modifier vos informations
    <br>
    
</h1>


<div class="row">
    <div class="col-lg-5">
        <form role="form" action="<?php echo $base; ?>/choristes/account" method="post">
          
          <div class="form-group">
            <label>Identifiant</label>
            <input type="text" name="login" class="form-control" value="<?php echo $user['login']; ?>" readonly>
          </div>

          <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" value="<?php echo $user['prenom']; ?>" required>
          </div>

          <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="<?php echo $user['nom']; ?>" required>
          </div>

          <div class="form-group">
            <label>Ville</label>
            <input type="text" name="ville" class="form-control"value="<?php echo $user['ville']; ?>" required>
          </div>

          <div class="form-group">
            <label>Téléphone</label>
            <input type="tel" name="telephone" class="form-control" value="<?php echo $user['telephone']; ?>">
          </div>

          <?php

          // On affiche le choix de la voix si l'utilisateur est un choriste seulement
          if($user['idvoix'] != NULL) {
            echo '<div class="form-group">';
            echo '<label>Voix</label>';
            echo '<select name="voix" class="form-control" required>';

                foreach($voix as $v) {
		              if($user['idvoix'] == $v['idvoix']) {
                        echo '<option selected>' . $v['typevoix'] .' </option>';
                    } else {
                        echo '<option>' . $v['typevoix'] .'</option>';
                    }
                }

            echo '</select>';
            echo '</div>';
          } 
          ?>

          <br>
          <h3>Mot de passe</h3>

          <div class="form-group">
            <label>Mot de passe actuel</label>
            <input type="password" name="current-pw" class="form-control" placeholder="Mot de passe actuel">
          </div>

          <div class="form-group">
            <label>Nouveau mot de passe</label>
            <input type="password" name="new-pw" class="form-control" placeholder="Nouveau mot de passe">
          </div>

          <div class="form-group">
            <label>Confirmation du nouveau mot de passe</label>
            <input type="password" name="new-pw-confirm" class="form-control" placeholder="Nouveau mot de passe">
          </div>

          <br>
          <div class="button-validate">
            <button type="submit" class="btn btn-lg btn-primary">Modifier</button>
          </div>
        </form>
    </div>

</div>

<?php echo $footer; ?>

<?php

$user = Flight::get('user');
$base = Flight::request()->base;
if($base == '/') $base = '';

?>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $base.'/'; ?>">MyChorus</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <?php

        if($activePage == 'choristes')
          echo '<li class="active"><a href="' . $base . '/choristes">Choristes</a></li>';
        else
          echo '<li><a href="' . $base . '/choristes">Choristes</a></li>';

        if($activePage == 'evenements')
          echo '<li class="active"><a href="' . $base . '/evenements">Evènements</a></li>';
        else
          echo '<li><a href="' . $base . '/evenements">Evènements</a></li>';

        if($activePage == 'programme')
          echo '<li class="active"><a href="' . $base . '/programme">Programme de l\'année</a></li>';
        else
          echo '<li><a href="' . $base . '/programme">Programme de l\'année</a></li>';

        // Si on est webmaster ou tresorier, on ajoute la page de validation
        if($user['authenticated'] and in_array($user['responsabilite'], array(2,3))) {

          // On ajoute un indicateur de validations en attente
          $badge = '<span class="badge"></span>';
          if($user['validations'] > 0) {
              $alert = 'alert-success';
              if($user['validations'] > 3)
                  $alert = 'alert-danger';
              $badge = '<span class="badge ' . $alert . '">' . $user['validations'] . '</span>';
          }

          if($activePage == 'inscriptions')
            echo '<li class="active"><a href="' . $base . '/inscriptions">Inscriptions en attente ' . $badge . '</a></li>';
          else
            echo '<li><a href="' . $base . '/inscriptions">Inscriptions en attente ' . $badge . '</a></li>';
        }

        ?>
      </ul>
      <div class="navbar-form navbar-right">
        <?php

        $user = Flight::get('user');
        $base = Flight::request()->base;
        if($base == '/') $base = '';

        if($user['authenticated']) {
          echo '<div id="welcome" class="form-group">';
          echo '<h4> Bienvenue, <a href="' . $base . '/choristes/account">' . $user['prenom'] . ' ' . $user['nom'] . '</a>   </h4>';
          echo '</div>';
          echo '<div class="form-group">';
          echo '<a href="' . $base . '/logout" class="btn btn-warning" role="button">Déconnexion</a>';
          echo '</div>';
        }
        else {
          echo '<a href="' . $base . '/login" class="btn btn-default" role="button">Connexion</a>';
        }
        ?>
      </div>
    </div><!--/.nav-collapse -->
  </div>
</div>

<div class="container">

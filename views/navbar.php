<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">MyChorus</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <?php
        if($activePage == 'home')
          echo '<li class="active"><a href="">Accueil</a></li>';
        else
          echo '<li><a href="/">Accueil</a></li>';

        if($activePage == 'choristes')
          echo '<li class="active"><a href="choristes">Choristes</a></li>';
        else
          echo '<li><a href="choristes">Choristes</a></li>';

        if($activePage == 'evenements')
          echo '<li class="active"><a href="evenements">Evènements</a></li>';
        else
          echo '<li><a href="evenements">Evènements</a></li>';
        ?>
      </ul>
      <div class="navbar-form navbar-right">
        <?php
        if(isset($session)) {
          echo '<h4>Bienvenue, ' . $session['username'] . '</h4>';
        }
        else {
          echo '<a href="login" class="btn btn-default" role="button">Connexion</a>';
        }
        ?>
      </div>
    </div><!--/.nav-collapse -->
  </div>
</div>

<div class="container">

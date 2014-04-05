<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    
    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin" role="form">
        <h2 class="form-signin-heading">Se connecter</h2>
		
        <?php
        if($fail) {
			echo '<div class="panel panel-danger">';
			echo '<div class="panel-heading">';
			echo '<h3 class="panel-title">Erreur d\'authentification</h3>';
			echo '</div>';
			echo '<div class="panel-body">';
			echo 'Les informations transmises n\'ont pas permis de vous authentifier (identifiant ou mot de passe incorrect).';
			echo '</div>';
			echo '</div>';
		}
		?>

        <input type="email" class="form-control" placeholder="Email" required autofocus>
        <input type="password" class="form-control" placeholder="Mot de passe" required>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Se souvenir de moi
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>

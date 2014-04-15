<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Inscription</title>
  </head>
  <body>
    <form method="post" action="traitement.php"> 
	<p>
		<label for="login">Login</label>
    		<input type="text" name="login" id="login" />
	</p>
    
	<p>
		<label for="Mot de passe">Mot de passe</label>
 		<input type="password" name="pass" id="pass" />		
	</p>
  
	<p>
		<label for="Mot de passe">Confirmation du mot de passe</label>
		<input type="password" name="pass" id="pass" />
	</p>
  
	<p>
		<label for="nom">Nom</label>
		<input type="text" name="nom" id="nom" />
	</p>
  	
	<p>
        	<label for="prenom">Prénom</label>
        	<input type="text" name="prenom" id="prenom" />
	</p>
  	
	<p>
        	<label for="ville">Ville</label>
        	<input type="text" name="ville" id="ville" />
	</p>  
  	
	<p>
        	<label for="telephone">Numéro de téléphone</label>
		<input type="text" name="telephone" id="telephone" />
	</p>  
  	
	<p>
		<label for="voix">Type de voix</label><br />
			<select name="voix" id="voix">
			<option value="1">Soprano</option>
       			<option value="2">Alto</option>
       			<option value="3">Ténor</option>
       			<option value="4">Basse</option>
        		</select>
	</p> 

  <input type="submit" value="Envoyer" />
  </form>
  </body>
</html>

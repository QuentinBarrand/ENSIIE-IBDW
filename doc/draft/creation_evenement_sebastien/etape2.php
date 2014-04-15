<?php
session_start();
require_once('sql.inc.php');
require_once('fct.inc.php');
$connected = 1;
$idChoriste = 1;

$saison = 0;
$concert = 0; 
$repetition = 0;
$valid = 1;

if((isset($_POST['idEvt']) && isset($_POST['nom']) && isset($_POST['dateHeure']) && isset($_POST['lieu'])) 
	|| isset($_SESSION['addEvenement']))
{
	/* On vient de valider l'étape 1 */

	if(isset($_POST['idEvt']))
	{
		/* Les variables transmises par le formulaire existent */
		$idEvt = $_POST['idEvt'];
		$nom = $_POST['nom'];
		$dateHeure = $_POST['dateHeure'];
		$lieu = $_POST['lieu'];
	}
	else if(isset($_SESSION['addEvenement']))
	{
		/* Les variables transmises par session existent */
		$idEvt = $_SESSION['addEvenement']['idEvt'];
		$nom = $_SESSION['addEvenement']['nom'];
		$dateHeure = $_SESSION['addEvenement']['dateHeure'];
		$lieu = $_SESSION['addEvenement']['lieu'];
	}

	/* On vérifie alors leur validité */
	
	/* Validité -> dateHeure */
	if(!(checkDateHeure($dateHeure))){
		$valid = 0;
		$erreurDate = 1;
	}
	
	/* Validité -> idEvt */
	if($valid && !(checkIdEvt($idEvt, $bdd))){
		$valid = 0;
		$erreurEvt = 1;
	}
	else{
		$typeEvt = checkIdEvt($idEvt, $bdd);
		if($typeEvt=='Saison') $saison = 1;
		else if($typeEvt=='Concert') $concert = 1;
		else if($typeEvt=='Répétition') $repetition = 1;
	}
	
	/* Validité -> Nom - Lieu */
	if($valid && !(checkNomLieu($nom, $lieu))){
		$valid = 0;
		$erreurNom = 1;
	}
	
	/* On vérifie qu'une saison n'existe pas déjà pour l'année saisie */
	if($valid && $saison && getSaison($bdd, substr($dateHeure, 6, 4))!=null){
		$valid = 0;
		$erreurSaisonExist = 1;
	}
	
	/* Donnees valides -> mises en session */
	if($valid)
	{
		/* On sauvegarde les donnees pour la page suivante */
		$_SESSION['addEvenement']['idEvt'] = $idEvt;
		$_SESSION['addEvenement']['nom'] = $nom;
		$_SESSION['addEvenement']['dateHeure'] = $dateHeure;
		$_SESSION['addEvenement']['lieu'] = $lieu;
	}
}
else if(isset($_POST['titre']) && isset($_POST['auteur']) && 
		isset($_POST['partition']) && isset($_POST['duree']) && isset($_POST['style']))
{
	/* On vient d'ajouter une oeuvre dans la BDD */
}
else $valid = 0;
?>
<html>
	<head>
		<title>Cr&eacute;ation d'un &eacute;v&egrave;nement [E1]</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<div class="content">
		<h2 style="text-align:center;">Cr&eacute;ation d'un &eacute;v&egrave;nement | Etape n°2</h2>
		<hr size="2">
		<?php 
		if(!($valid))
		{
			if(isset($erreurDate))
			{
				$erreur = 'Erreur avec le champs "date" : format ou valeur incorrect.';
			}
			else if(isset($erreurEvt))
			{
				$erreur = 'Erreur avec le champs "évènement" : format ou valeur incorrect.';
			}
			else if(isset($erreurNom))
			{
				$erreur = 'Erreur avec le champs "nom" ou "lieu" : format ou valeur incorrect.';
			}
			else if(isset($erreurSaisonExist))
			{
				$erreur = 'Une saison existe déjà pour l\'année '.substr($dateHeure, 6, 4).'.';
			}
			if(isset($erreurEvt) || isset($erreurDate) || isset($erreurNom) || isset($erreurSaisonExist))
			{
				echo '<p><span style="color:red;">'.$erreur.'</span><br />'.
						'<a href="index.php">Retour à l\'étape n°1.</a></p>';
			}
			else
			{
				echo '<p><span style="color:red;">Accès refusé :</span><br />'.
						'<a href="index.php">Retour à l\'étape n°1.</a></p>';
			}
		}
		else
		{
			?>
			<form method="POST" action="etape3.php">
			<p>
			<label for="idEvt">Evenement</label>
			<select name="idEvt" disabled>
				<option value="<?php echo $idEvt; ?>">
				<?php echo $typeEvt; ?></option>
			</select>
			</p>	
			<p>
			<label for="nom">Nom</label>
			<input name="nom" type="text" value="<?php echo $nom; ?>" disabled />
			</p>
			<p>
			<label for="dateHeure">Date</label>
			<input name="dateHeure" type="text" value="<?php echo $dateHeure; ?>" disabled />
			</p>
			<p>
			<label for="lieu">Lieu</label>
			<input name="lieu" type="text" value="<?php echo $lieu; ?>" disabled />
			</p>
			<p>
			<label for="oeuvres[]">Quelles oeuvres voulez-vous ajouter au programme ?</label><br />
			<br />
			<select name="oeuvres[]" multiple size="5">
			<?php
			if($saison)
			{
				/* On affiche le formulaire pour la saison */
				$lesOeuvres = getOeuvres($bdd);
				while($oeuvre = $lesOeuvres->fetch())
				{
					?>
					<option value="<?php echo $oeuvre['idOeuvre'] ?>">
					<?php echo $oeuvre['titre']; ?></option>
					<?php
				}
			}
			else if($concert || $repetition)
			{
				/* On affiche le formulaire pour la repetition/le concert */
				$lesOeuvres = getProgramme($bdd);
				while($oeuvre = $lesOeuvres->fetch())
				{
					?>
					<option value="<?php echo $oeuvre['idOeuvre'] ?>">
					<?php echo $oeuvre['titre']; ?></option>
					<?php
				}
			}
			?>
			</select>
			</p>
			<p><input type="submit" value="Valider" /></p>
			</form>
			<?php
		}
		?>
		</div>
		<?php
		if($valid && $saison)
		{
			?>
			<div class="content">
			<h2 style="text-align:center;">Ajout d'une Oeuvre</h2>
			<hr size="2">
			<form method="POST" action="etape2.php">
			<p>
			<label for="titre">Titre</label>
			<input type="text" name="titre" />
			</p>
			<p>
			<label for="auteur">Auteur</label>
			<input type="text" name="auteur" />
			</p>
			<p>
			<label for="partition">Partition</label>
			<input type="text" name="partition" placeholder="lien de la partition" />
			</p>
			<p>
			<label for="duree">Durée</label>
			<input type="text" name="duree" placeholder="durée en secondes" />
			</p>
			<p>
			<label for="style">Style</label>
			<input type="text" name="style" />
			</p>
			<p><input type="submit" value="Ajouter" /></p>
			</form>
			</div>
			<?php
		}
		?>
	</body>
</html> 
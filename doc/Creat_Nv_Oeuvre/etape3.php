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
	if(isset($_POST['oeuvres']))
	{
		/* Les variables transmises par le formulaire existent */
		$oeuvres = $_POST['oeuvres'];
	}
	else if(isset($_SESSION['addEvenement']['oeuvres']))
	{
		/* Les variables transmises par session existent */
		$oeuvres = $_SESSION['addEvenement']['oeuvres'];
	}
	$idEvt = $_SESSION['addEvenement']['idEvt'];
	$nom = $_SESSION['addEvenement']['nom'];
	$dateHeure = $_SESSION['addEvenement']['dateHeure'];
	$lieu = $_SESSION['addEvenement']['lieu'];
		
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

	/* Validité -> Oeuvres */
	if($valid && !(count(checkOeuvres($oeuvres, $bdd, $saison)))){
		$valid = 0;
		$erreurOeuvres = 1;
	}
	
	/* Donnees valides */
	if($valid)
	{
		/* On sauvegarde les donnees en session */
		$_SESSION['addEvenement']['oeuvres'] = $oeuvres;

		/* Donnes valides -> insertion dans la BDD */
		$idEvt = addEvenement(array( 
				'idType' => $_SESSION['addEvenement']['idEvt'],
				'heureDate' => formaterDate($_SESSION['addEvenement']['dateHeure'], 'en'),
				'lieu' => $_SESSION['addEvenement']['lieu'],
				'nom' => $_SESSION['addEvenement']['nom'])
				, $bdd);
		foreach($_SESSION['addEvenement']['oeuvres'] as $idOeuvre)
		{
			addElementProgramme($idEvt, $idOeuvre, $bdd);
		}
	}
}
else $valid = 0;
?>
<html>
	<head>
		<title>Cr&eacute;ation d'un &eacute;v&egrave;nement [E3]</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<div class="content">
		<h2 style="text-align:center;">Cr&eacute;ation d'un &eacute;v&egrave;nement | Etape n°3</h2>
		<hr size="2">
		<p style="color:green;">Création d'un évènement avec les informations suivantes : </p>
		<form>
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
		<label for="oeuvres[]">Les oeuvres au programme :</label><br />
		<br />
		<select name="oeuvres[]" multiple size="5" disabled>
		<?php
		$lesOeuvres = checkOeuvres($oeuvres, $bdd, $saison);
		foreach($lesOeuvres as $key => $value){
			?>
			<option value="<?php echo $key; ?>">
			<?php echo $value; ?></option>
			<?php
		}
		?>
		</select>
		</p>
		</form>
		</div>
	</body>
</html> 
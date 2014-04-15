<?php
require_once('sql.inc.php');
$connected = 1;
$idChoriste = 1;

$idEvenements = getTypeEvenements($bdd);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Cr&eacute;ation d'un &eacute;v&egrave;nement [E1]</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<div class="content">
		<h2 style="text-align:center;">Cr&eacute;ation d'un &eacute;v&egrave;nement | Etape n°1</h2>
		<hr size="2">
		<form method="POST" action="etape2.php">
		<p>
		<label for="idEvt">Quel évènement souhaitez-vous créer ?</label>
		<select name="idEvt">
		<?php
		while ($evenement = $idEvenements->fetch())
		{
		?>
			<option value="<?php echo $evenement['idType'] ?>">
			<?php echo $evenement['typeEvt']; ?></option>
		<?php
		}
		?>
		</select>
		</p>
		<p>
		<label for="nom">Nom</label>
		<input name="nom" type="text" />
		</p>
		<p>
		<label for="dateHeure">Date</label>
		<input name="dateHeure" type="text" placeholder="12-06-2014 19:30:00" />
		</p>
		<p>
		<label for="lieu">Lieu</label>
		<input name="lieu" type="text" placeholder="Salle + Ville" />
		</p>
		<p><input type="submit" value="Choisir le programme" /></p>
		</form>
		</div>
	</body>
</html> 
<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>Liste des choristes</h1>

<?php
	$user = Flight::get('user');

	if(! $user['authenticated']) {
		echo '<a id="subscribe" href="' . Flight::request()->base . '/choristes/new" class="btn btn-success" role="button"><b>+</b> M\'inscrire</a>';
	}
?>

<table class="table table-striped">
<?php

	if(count($data['content']) > 0) {
		echo '<thead>';

		echo '<tr>';
		echo '<th>Prénom Nom</th>';		
		echo '<th>Voix</th>';

		if($user['authenticated'])
		{
			echo '<th>Téléphone</th>';		
			echo '<th>Ville</th>';
		}

		echo '</tr>';

		echo '</thead>';
		echo '<tbody>';

		foreach($data['content'] as $row) {
			echo '<tr>';

			echo '<td>' . $row['prenom'] . ' ' .$row['nom'];
			
			// Un label pour la responsabilité ou rien
			if($row['responsabilite'] != NULL)
				echo '&nbsp;&nbsp;<span class="label label-info">' . $row['responsabilite'] . '</span>';
			else
				echo '</td>';

			echo '<td>' . $row['typevoix'] . '</td>';

			if($user['authenticated'])
			{
				echo '<td>' . $row['telephone'] . '</td>';
				echo '<td>' . $row['ville'] . '</td>';
			}

			echo '</tr>';
		}

		echo '</tbody>';
	}
	else {
		echo '<h3>Aucune donnée à afficher.';
	}

?>
</table>

<?php echo($footer); ?>

<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>Liste des choristes</h1>

<?php
	$user = Flight::get('user');

	if(! $user['authenticated']) {
		echo '<a id="subscribe" href="' . Flight::request()->base . 'choristes/new" class="btn btn-success" role="button"><b>+</b> M\'inscrire</a>';
	}
?>

<table class="table table-striped">
<?php

	if(count($data['content']) > 0) {
		echo '<thead>';

		echo '<tr>';
		echo '<th>Prénom</th>';		
		echo '<th>Nom</th>';
		echo '<th>Lieu</th>';
		echo '</tr>';

		echo '</thead>';
		echo '<tbody>';

		foreach($data['content'] as $row) {
			echo '<tr>';

			echo '<td>' . $row['prenom'] . '</td>';
			echo '<td>' . $row['nom'] . '</td>';
			echo '<td>' . $row['typeVoix'] . '</td>';

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

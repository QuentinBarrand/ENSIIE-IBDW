<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>Programme de l'année</h1>

<?php
	// $user = Flight::get('user');

	// if(! $user['authenticated']) {
	// 	echo '<a id="subscribe" href="' . Flight::request()->base . 'programme/new" class="btn btn-success" role="button"><b>+</b> M\'inscrire</a>';
	// }
?>
<h2>Liste des oeuvres</h2>
<table class="table table-striped">
<?php

	if(count($data['content']) > 0) {
		echo '<thead>';

		echo '<tr>';
		echo '<th>Titre</th>';		
		echo '<th>Aueur</th>';
		echo '<th>Partition</th>';
		echo '<th>Durée</th>';
		echo '<th>Style</th>';
		echo '</tr>';

		echo '</thead>';
		echo '<tbody>';

		foreach($data['content'] as $row) {
			echo '<tr>';

			echo '<td>' . $row['titre'] . '</td>';
			echo '<td>' . $row['auteur'] . '</td>';
			echo '<td>' . $row['partition'] . '</td>';
			echo '<td>' . $row['duree'] . '</td>';
			echo '<td>' . $row['style'] . '</td>';

			echo '</tr>';
		}

		echo '</tbody>';
	}
	else {
		echo '<h3>Aucune donnée à afficher.';
	}
?>
</table>

<h2>Durée par style</h2>
<table class="table table-striped">
<?php

	if(count($data['styles']) > 0) {
		echo '<thead>';

		echo '<tr>';
		echo '<th>Style</th>';		
		echo '<th>Durée</th>';
		echo '</tr>';

		echo '</thead>';
		echo '<tbody>';

		foreach($data['styles'] as $row) {
			echo '<tr>';

			echo '<td>' . $row['style'] . '</td>';
			echo '<td> TODO </td>';

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

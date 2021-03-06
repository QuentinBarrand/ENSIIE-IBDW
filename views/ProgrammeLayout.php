<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>
	Programme de l'année
	<br>
	<small>
		<?php 
			// Affichage de la saison
            if (isset($data['content'][0]['nomsaison']))
			    echo $data['content'][0]['nomsaison'];
		?>
	</small>
</h1>

<?php
	// $user = Flight::get('user');
        // $base = Flight::request()->base;
        // if($base == '/') $base = '';

	// if(! $user['authenticated']) {
	// 	echo '<a id="subscribe" href="' . $base . 'programme/new" class="btn btn-success" role="button"><b>+</b> M\'inscrire</a>';
	// }
?>
<h2>Liste des oeuvres</h2>
<table class="table table-striped">
<?php
	$user = Flight::get('user');

	if(count($data['content']) > 0) {
		echo '<thead>';

		echo '<tr>';
		echo '<th>Titre</th>';		
		echo '<th>Auteur</th>';
		echo '<th>Partition</th>';
		echo '<th>Durée</th>';
		echo '<th>Style</th>';

		if($user['authenticated'] && $user['validation'] > 1)
			echo '<th>Niveau</th>';

		echo '</tr>';

		echo '</thead>';
		echo '<tbody>';

		foreach($data['content'] as $row) {
			echo '<tr>';

			echo '<td>' . $row['titre'] . '</td>';
			echo '<td>' . $row['auteur'] . '</td>';
			echo '<td><a href="' . $row['partition'] . '">' . $row['partition'] . '</a></td>';
			echo '<td>' . $row['duree'] . '</td>';
			echo '<td>' . $row['style'] . '</td>';

			if($user['authenticated'] && $user['validation'] > 1) {
				if(isset($data['progression'][$row['idoeuvre']]))
					$niveau = $data['progression'][$row['idoeuvre']];
				else
					$niveau = 0;

				echo '<td>';

				if($niveau == 0)
					echo '<span class="label label-danger">Non maîtrisée</span>';

				elseif($niveau < 4)
					echo '<span class="label label-warning">Apprentissage</span>';

				else
					echo '<span class="label label-success">Maîtrisée</span>';

				echo '</td>';
			}

			echo '</tr>';
		}

		echo '</tbody>';
	}
	else {
		echo '<h4>Aucune donnée à afficher.</h4>';
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
			echo '<td>' . $row['dureestyle'] . '</td>';

			echo '</tr>';
		}

		echo '</tbody>';
	}
	else {
		echo '<h4>Aucune donnée à afficher.</h4>';
	}
?>
</table>


<?php echo($footer); ?>

<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>Liste des évènements</h1>

<?php
	$user = Flight::get('user');
        $base = Flight::request()->base;
        if($base == '/') $base = '';

	if($user['authenticated'] && $user['responsabilite'] == 1)
		echo '<a id="subscribe" href="' . $base . '/choristes/new" class="btn btn-success" role="button"><b>+</b> Nouvel évènement</a>';

	date_default_timezone_set('UTC');

	function printTable($type, $user, $data) {
		echo '<table class="table table-striped">';
		echo '<thead>';

		echo '<tr>';
		echo '<th>Nom</th>';
		echo '<th>Date et heure</th>';
		echo '<th>Lieu</th>';
		
		if($user['authenticated']) {
			echo '<th>Statut</th>';	
		}

		echo '</tr>';

		echo '</thead>';
		echo '<tbody>';

		foreach($data['content'] as $row) {
			$epoch_evenement = strtotime($row['heuredate']);

			if($type == 'a_venir')
				$condition = time() > $epoch_evenement;
			else
				$condition = time() < $epoch_evenement;

			if($condition) {
				echo '<tr>';
				
				echo '<td>' . $row['nom'] . '</td>';
				echo '<td>' . date('d / m / Y -  H:i:s', $epoch_evenement) . '</td>';
				echo '<td>' . $row['lieu'] . '</td>';

				if($user['authenticated']) {
					echo '<td>';
					echo '<span class="label label-danger">Pas assez de choristes</span>';
					echo '</td>';
				}

				echo '</tr>';
			}
		}

		echo '</tbody>';
		echo '</table>';
	}


	echo '<h2>Evènements à venir</h2>';
	printTable('a_venir', $user, $data);
	
	echo '<h2>Evènements passés</h2>';
	printTable('passes', $user, $data);
?>

<?php echo($footer); ?>

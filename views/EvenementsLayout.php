<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>Liste des évènements</h1>

<?php
	$user = Flight::get('user');

	if($user['authenticated'] && $user['responsabilite'] == 1)
		echo '<a id="subscribe" href="' . Flight::request()->base . '/choristes/new" class="btn btn-success" role="button"><b>+</b> Nouvel évènement</a>';

	date_default_timezone_set('UTC');

?>

<h2>Evènements à venir</h2>
<table class="table table-striped">
<?php
	echo '<thead>';

	echo '<tr>';
	echo '<th>Nom</th>';
	echo '<th>Date et heure</th>';
	echo '<th>Lieu</th>';
	echo '</tr>';

	echo '</thead>';
	echo '<tbody>';

	foreach($data['content'] as $row) {
		$epoch_evenement = strtotime($row['heuredate']);

		if(time() < $epoch_evenement) {
			echo '<tr>';
			
			echo '<td>' . $row['nom'] . '</td>';
			echo '<td>' . date('d / m / Y -  H:i:s', strtotime($row['heuredate'])) . '</td>';
			echo '<td>' . $row['lieu'] . '</td>';

			echo '</tr>';
		}
	}

	echo '</tbody>';
?>
</table>

<h2>Evènements passés</h2>
<table class="table table-striped">
<?php
	echo '<thead>';

	echo '<tr>';
	echo '<th>Nom</th>';
	echo '<th>Date et heure</th>';
	echo '<th>Lieu</th>';
	echo '</tr>';

	echo '</thead>';
	echo '<tbody>';

	foreach($data['content'] as $row) {
		$epoch_evenement = strtotime($row['heuredate']);

		if(time() > $epoch_evenement) {
			echo '<tr>';
			
			echo '<td>' . $row['nom'] . '</td>';
			echo '<td>' . date('d / m / Y -  H:i:s', $epoch_evenement) . '</td>';
			echo '<td>' . $row['lieu'] . '</td>';

			echo '</tr>';
		}
	}

	echo '</tbody>';
?>
</table>

<?php echo($footer); ?>

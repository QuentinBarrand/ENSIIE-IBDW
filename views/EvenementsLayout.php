<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>Liste des évènements</h1>

<?php
	$user = Flight::get('user');

	if($user['authenticated'] && $user['responsabilite'] == 1) {
		echo '<a id="subscribe" href="' . Flight::request()->base . '/choristes/new" class="btn btn-success" role="button"><b>+</b> Nouvel évènement</a>';
	}
?>

<table class="table table-striped">
<?php

	echo '<thead>';

	echo '<tr>';
	echo '<th>Nom</th>';
	echo '<th>Lieu</th>';
	echo '</tr>';

	echo '</thead>';
	echo '<tbody>';

	foreach($data['content'] as $row) {
		echo '<tr>';
		
		echo '<td>' . $row['nom'] . '</td>';
		echo '<td>' . $row['lieu'] . '</td>';

		echo '</tr>';
	}

	echo '</tbody>';

?>
</table>

<?php echo($footer); ?>

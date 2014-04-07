<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>Liste des évènements</h1>

<?php
	// TODO : si l'utilisateur est le chef de choeur, afficher un bouton d'ajout d'un évènement.
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

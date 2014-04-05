<?php echo($header); ?>
<?php echo($navbar); ?>

<div class="container">

<h1>Liste des évènements</h1>

<table class="table table-striped">
<?php

	echo '<thead>';

	echo '<tr>';
	echo '<th>Nom</th>';
	echo '<th>Lieu</th>';
	echo '</tr>';

	echo '</thead>';
	echo '<tbody>';

	foreach($data as $row) {
		echo '<tr>';
		
		echo '<td>' . $row['nom'] . '</td>';
		echo '<td>' . $row['lieu'] . '</td>';

		echo '</tr>';
	}

	echo '</tbody>';

?>
</table>

</div><!-- /.container -->

<?php echo($footer); ?>

<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>Liste des choristes</h1>

<?php 

$user = Flight::get('user');
$base = Flight::request()->base;
if($base == '/') $base = '';

if(! $user['authenticated']) {
	echo '<a id="subscribe" href="' . $base . '/choristes/nouveau" class="btn btn-success" role="button"><b>+</b> M\'inscrire</a>';
}

// Liste des choristes
echo '<table class="table table-striped">';

if(count($data['content']) > 0) {
	echo '<thead>';

	echo '<tr>';
	echo '<th>Prénom Nom</th>';		
	echo '<th>Voix</th>';

	// Détails supplémentaires si l'utilisateur est authentifié
	if($user['authenticated'])
	{
		echo '<th>Téléphone</th>';		
		echo '<th>Ville</th>';
		echo '<th>Présence aux répétitions</th>';
	}

	echo '</tr>';

	echo '</thead>';
	echo '<tbody>';

	foreach($data['content'] as $row) {
		echo '<tr>';

		echo '<td>' . ucfirst($row['prenom']) . ' ' . ucfirst($row['nom']);
		
		// Un label pour la responsabilité ou rien
		if($row['responsabilite'] != NULL)
			echo '&nbsp;&nbsp;<span class="label label-info">' . $row['responsabilite'] . '</span>';
		else
			echo '</td>';

		echo '<td>' . $row['typevoix'] . '</td>';

		// Détails supplémentaires si l'utilisateur est authentifié
		if($user['authenticated'])
		{
			echo '<td>' . $row['telephone'] . '</td>';
			echo '<td>' . $row['ville'] . '</td>';

			// Taux de présence
			$p = (int)$row['participations'];
			$r = $data['repets_count'];
			$pc = ($p / $r) * 100;

			echo '<td>' . $p . ' / ' . $r;

			if($pc < 25)
				echo '&nbsp;&nbsp;<span class="label label-danger">' . $pc . ' %</span>';
			elseif($pc < 60)
				echo '&nbsp;&nbsp;<span class="label label-warning">' . $pc . ' %</span>';
			else
				echo '&nbsp;&nbsp;<span class="label label-success">' . $pc . ' %</span>';

			echo '</td>';
		}

		echo '</tr>';
	}

	echo '</tbody>';
}
else
	echo '<h3>Aucune donnée à afficher.';

echo '</table>';

echo $footer; 

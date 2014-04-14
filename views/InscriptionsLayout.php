<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>Liste des inscriptions à valider</h1>

<?php
	$user = Flight::get('user');
        $base = Flight::request()->base;
        if($base == '/') $base = '';

        // Detection du type de validation à afficher
        $type = 0;
        if($user['responsabilite'] == 2)
            $type = 1;

        echo '<h2>Inscriptions à valider</h2>';
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Nom</th>';
        echo '<th>Prenom</th>';
	echo '<th>Type de Voix</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';

        foreach($data['content'] as $row) {

            $link = 'href="/inscriptions/validation/' . $row['idinscription'] . '"';
            $class = 'class="label label-warning"';
            $role = 'role="button"';
            echo '<tr>';
	    echo '<td>' . $row['nom'] . '</td>';
	    echo '<td>' . $row['prenom'] . '</td>';
	    echo '<td>' . $row['typevoix'] . '</td>';
            echo '<td><a ' . $link . ' ' . $class . ' ' . $role . '>Valider</a></td>';
        }

        echo '</tbody>';
        echo '</table>';

?>

<?php echo($footer); ?>

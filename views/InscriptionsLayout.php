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

    function show_table($data, $user_type, $display_type) {

    // Affichage du titre en fonction de la validation à afficher
        if($user_type == $display_type) {
            echo '<h2>Inscriptions à valider</h2>';
        }
        else {
            $other_user = "Webmaster";
            if($display_type == 1)
                $other_user = "Trésorier";
            echo '<h2>Inscriptions en attente du ' . $other_user . '</h2>';
        }

    // Affichage des en-têtes du tableau
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Nom</th>';
        echo '<th>Prenom</th>';
        echo '<th>Type de Voix</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

    // Affichage des éléments du tableau (seulement ceux du bon type)
        foreach($data['content'] as $row) {

            if($row['validation'] == $display_type) {
                echo '<tr>';
                echo '<td>' . $row['nom'] . '</td>';
                echo '<td>' . $row['prenom'] . '</td>';
                echo '<td>' . $row['typevoix'] . '</td>';
                echo '<td>' . $row['typeinscription'] . '</td>';
                echo '<td>';

    // Affichage du bouton de validation si nécessaire
                if($user_type == $display_type) {
                    $link = 'href="' .Flight::request()->base .'/inscriptions/validation/' . $row['idinscription'] . '"';
                    $class = 'class="label label-warning"';
                    $role = 'role="button"';
                    echo '<a ' . $link . ' ' . $class . ' ' . $role . '>Valider</a>';
                }

                echo '</td>';
            }

        }

        echo '</tbody>';
        echo '</table>';
    }

    show_table($data, $type, abs($type-1));
    show_table($data, $type, $type);

?>

<?php echo($footer); ?>

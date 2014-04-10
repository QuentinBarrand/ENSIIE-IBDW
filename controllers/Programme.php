<?php

class Programme {
	function get() {
        $user = Flight::get('user');

        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        $sql1 = 'SELECT titre, auteur, partition, duree, style
            FROM oeuvre
            ORDER BY style;';

        $sql2 = 'SELECT DISTINCT style
            FROM oeuvre
            ORDER BY style;';

        // On récupère l'ID de la saison actuelle
        $sql3 = "SELECT idEvenement
            FROM Evenement
            NATURAL JOIN TypeEvt
            WHERE typeEvt LIKE 'Saison' 
            AND EXTRACT(YEAR from heureDate) = EXTRACT(YEAR from now());";

        // Puis on recupere toutes les oeuvres de la saison 
        $sql4 = 'SELECT Oeuvre.*, nom as nomSaison
            FROM Oeuvre
            NATURAL JOIN est_au_programme
            NATURAL JOIN Evenement
            NATURAL JOIN TypeEvt
            WHERE idEvenement = :saison_actuelle
            ORDER BY Oeuvre.style;';

        $sql5 = 'SELECT idOeuvre, Count(est_au_programme.idEvenement) AS nbEvenements
            FROM est_au_programme
            NATURAL JOIN evenement
            NATURAL JOIN participe
            WHERE idType = 2 AND idChoriste = :id_choriste AND confirmation = 1 
            GROUP BY idOeuvre;';

        // On récupère la durée par style
        $sql6 = 'SELECT style, SUM(duree) AS dureeStyle
            FROM Oeuvre
            NATURAL JOIN est_au_programme
            NATURAL JOIN Evenement
            WHERE idEvenement = :saison_actuelle
            GROUP BY style, nom;';

        if($db) {
            try {
                // On récupère toutes les oeuvres
                $query = $db->prepare($sql1);
                $query->execute();

                $data['content'] = $query->fetchAll();


                // On récupère les différents styles
                $query = $db->prepare($sql2);
                $query->execute();

                $data['styles'] = $query->fetchAll();

                // On récupère l'ID de la saison actuelle
                $query = $db->prepare($sql3);
                $query->execute();

                $result = $query->fetch();
                $data['id_saison'] = $result[0];
                

                // On récupère l'ID de la saison actuelle
                $query = $db->prepare($sql4);
                $query->execute(array(
                    ':saison_actuelle' => $data['id_saison']
                    )
                );

                $data['content'] = $query->fetchAll();

                if($user['authenticated'] && $user['idChoriste'] != NULL) {
                    // On récupère la progression de l'utilisateur connecté sur chaque oeuvre
                    $query = $db->prepare($sql5);
                    $query->execute(array(
                        ':id_choriste' => $user['idChoriste']
                        )
                    );

                    $result = $query->fetchAll();

                    foreach($result as $r) {
                        $data['progression'][$r['idoeuvre']] = $r['nbevenements'];
                    }
                }

                // Durée par style
                $query = $db->prepare($sql6);
                $query->execute(array(
                    ':saison_actuelle' => $data['id_saison']
                    )
                );

                $data['styles'] = $query->fetchAll();

                $data['success'] = true;

            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }

        // Header
        Flight::render('header.php',
            array(
                'title' => 'Programme de l\'année'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'programme'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');      

        // Finalement on rend le layout
        if($data['success'])
            Flight::render('ProgrammeLayout.php', array('data' => $data));
        else
            Flight::render('ErrorLayout.php', array('data' => $data));
    }
}
<?php

class Evenements {

    // GET /evenements
    function get() {
        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        // On récupère tous les évènements
        $sql1 = "SELECT idEvenement, heureDate, lieu, nom 
            FROM evenement
            NATURAL JOIN TypeEvt
            WHERE typeEvt LIKE 'Concert' 
            ORDER BY heureDate DESC;";

        $voix = Choristes::getVoix();

        // echo '<pre>';
        // var_dump($voix);
        // echo '</pre>';

        // die;

        $sql2 = 'SELECT Evenement.idEvenement, heureDate, lieu, nom';


        foreach($voix as $v)
            $sql2 .= ', nbc_' . $v;


        $sql2 .= ' FROM Evenement
                  NATURAL JOIN TypeEvt ';

        foreach($voix as $v)
            $sql2 .= 'LEFT OUTER JOIN (
                          SELECT idEvenement, count(participe.idChoriste) as nbc_' . $v . '
                          FROM participe
                          NATURAL JOIN Choriste
                          WHERE idVoix = ' . $v . '
                          AND confirmation = 1
                          GROUP BY idEvenement
                        ) as view_nbvoix_' . $v . '
                      ON Evenement.idEvenement = view_nbvoix_' . $v . '.idEvenement ';

        $sql2 .= "WHERE typeEvt='Concert'
                  ORDER BY heureDate DESC;";

        if($db) {
            try {
                // SQL 1
                $query = $db->prepare($sql1);
                $query->execute();

                $data['success'] = true;
                $data['content'] = $query->fetchAll();

                // SQL2
                $query = $db->prepare($sql2);
                $query->execute();

                $result = $query->fetchAll();
                // var_dump($sql2);
                // echo '<pre>';
                // var_dump($result);
                // echo '</pre>';
                // die;
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }

        // Header
        Flight::render('header.php',
            array(
                'title' => 'Liste des évènements'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'evenements'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');      

        // Finalement on rend le layout
        if($data['success'])
            Flight::render('EvenementsLayout.php', array('data' => $data));
        else
            Flight::render('ErrorLayout.php', array('data' => $data));
    }


    /* Retourne le nombre total d'évènements du type passé en paramètre
     * (par défaut 2 = répétitions) dans la base de données.
     */
    function getCount($type = 2) {
        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
        }

        $sql = 'SELECT count(idEvenement) as TotalRepetitions
                    FROM evenement
                    WHERE idType = ' . $type . ';';

        $count = NULL;

        if($db) {
            try {
                $query = $db->prepare($sql);
                $query->execute();

                $result = $query->fetch();
                $count = $result[0];
            }
            catch(PDOException $e) { }
        }

        return $count;
    }
}

<?php

class Inscriptions {

    // GET /inscriptions
    function get() {
        $user = Flight::get('user');

        // Restriction aux responsabilites webmaster et tresorier
        if(! $user['authenticated']) {
            Flight::forbidden();
            return;
        }
        if(! in_array($user['responsabilite'], array(2, 3))) {
            Flight::forbidden();
            return;
        }

        // On cherche les validations du webmaster par defaut
        //    $type = 0;
        // Si tresorier, on cherche les validations du tresorier
        //    if($user['responsabilite'] == 2)
        //        $type = 1;

        // Connexion à la base de données
        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        $sql = 'SELECT nom, prenom, typeVoix, typeInscription, idInscription, validation
                FROM Choriste
                NATURAL JOIN Voix 
                NATURAL JOIN Inscription
                WHERE validation < 2;';

        if($db) {
            try {
                $query = $db->prepare($sql);
                
                $query->execute();

                $data['success'] = true;
                $data['content'] = $query->fetchAll();
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }

        // Header
        Flight::render('header.php',
            array(
                'title' => 'Liste des inscriptions'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'inscriptions'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');      

        // Finalement on rend le layout
        if($data['success'])
            Flight::render('InscriptionsLayout.php', array('data' => $data));
        else
            Flight::render('ErrorLayout.php', array('data' => $data));
    }

    /*
     * Incrémente la valeur de validation pour l'id
     * fourni en paramètre.
     */
    function validate($inscriptionId) {
        $user = Flight::get('user');
        $base = Flight::request()->base;
        if($base == '/') $base = '';

        // Restriction aux responsabilites webmaster et tresorier
        if(! $user['authenticated']) {
            Flight::forbidden();
            return;
        }
        if(! in_array($user['responsabilite'], array(2, 3))) {
            Flight::forbidden();
            return;
        }

        // Connexion à la base de données
        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
        }

        // Detection du type de validation (Webmaster/Tresorier)
        $type = 1;
        if($user['responsabilite'] == 2)
            $type = 2;

        $sql = 'UPDATE Inscription
                SET validation = ' . $type . '
                WHERE idInscription = ' . $inscriptionId . ';';

        // Execution de la requête SQL
        if($db) {
            try {
                $query = $db->prepare($sql);
                $query->execute();
                $data['success'] = true;
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }

        // Finalement on reditige vers la liste des validations
        Flight::redirect($base . '/inscriptions');
    }

    /* Retourne le nombre total d'inscriptions en fonction
     * du type donné en paramètre.
     * 0: 1ère validation (webmaster)
     * 1: 2nde validation (trésorier)
     */
    function getCount($type) {
        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
        }

        $sql = 'SELECT count(*)
                FROM Choriste
                NATURAL JOIN Inscription
                WHERE validation = ' . $type . ';';

        $count = 0;

        if($db) {
            try {
                $query = $db->prepare($sql);
                $query->execute();

                $result = $query->fetch();
                if($result[0])
                    $count = $result[0];
            }
            catch(PDOException $e) { }
        }

        return $count;
    }
}

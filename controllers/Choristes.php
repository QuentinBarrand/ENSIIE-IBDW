<?php

class Choristes {

    // GET /choristes
    function get() {
        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        $sql = 'SELECT nom, prenom, typeVoix, ville, telephone, titre as responsabilite, SUM(participe.confirmation) as participations
            FROM Choriste
            LEFT JOIN participe ON Choriste.idChoriste = participe.idChoriste
            NATURAL JOIN Voix 
            NATURAL JOIN Utilisateur 
            LEFT JOIN Endosse ON Utilisateur.login = Endosse.login
            LEFT JOIN Responsabilite ON Endosse.id = Responsabilite.id 
            GROUP BY Choriste.idChoriste, nom, prenom, typeVoix, ville, telephone, responsabilite
            ORDER BY typeVoix;';

        // On récupère le nombre d'évènements
        $data['repets_count'] = Evenements::getCount();

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
                'title' => 'Liste des choristes'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'choristes'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');      

        // Finalement on rend le layout
        if($data['success'])
            Flight::render('ChoristesLayout.php', array('data' => $data));
        else
            Flight::render('ErrorLayout.php', array('data' => $data));
    }

    function displayChoristeForm() {
        // Header
        Flight::render('header.php',
            array(
                'title' => 'Ajouter un évènement'
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

        Flight::render('ChoristeNewLayout.php');
    }

    function getVoix() {
        $voix = NULL;

        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        $sql = 'SELECT idVoix FROM Voix;';

        // On récupère le nombre d'évènements
        $data['repets_count'] = Evenements::getCount();

        if($db) {
            try {
                $query = $db->prepare($sql);
                
                $query->execute();

                $result = $query->fetchAll();

                for($i = 0; $i < $query->rowCount(); $i++)
                    $voix[$i] = $result[$i][0];
            }
            catch(PDOException $e) { }
        }

        return $voix;
    }
}
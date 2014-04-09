<?php

class Choristes {

    // GET /choristes
    function get() {
        try {
            $db = new PDO('pgsql:host='. Flight::get('postgres.host') .';dbname='. Flight::get('postgres.database'), 
                Flight::get('postgres.user'), 
                Flight::get('postgres.password'));
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        $sql = 'SELECT nom, prenom, typeVoix, ville, telephone, titre as responsabilite, AVG(participe.confirmation) as participations
            FROM Choriste
            LEFT JOIN participe ON Choriste.idChoriste = participe.idChoriste
            LEFT JOIN Voix ON Choriste.idVoix = Voix.idVoix 
            LEFT JOIN Utilisateur ON Choriste.login = Utilisateur.login 
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
}
<?php

class Programme {
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

        $sql = 'SELECT titre, auteur, partition, duree, style
            FROM oeuvre;';

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
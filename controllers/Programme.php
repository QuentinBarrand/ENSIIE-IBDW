<?php

class Programme {
	function get() {
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

        if($db) {
            try {
                $query = $db->prepare($sql1);
                $query->execute();

                $data['content'] = $query->fetchAll();

                $query = $db->prepare($sql2);
                $query->execute();

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